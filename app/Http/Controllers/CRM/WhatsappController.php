<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\MessageReaction;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VERIFY WEBHOOK
    |--------------------------------------------------------------------------
    */

    public function verify(Request $request)
    {
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN');

        if ($request->hub_verify_token == $verifyToken) {
            return response($request->hub_challenge, 200);
        }

        return response('Invalid Verify Token', 403);
    }

    /*
    |--------------------------------------------------------------------------
    | RECEIVE MESSAGE
    |--------------------------------------------------------------------------
    */

    public function receive(Request $request)
    {
        try {
            $data = $request->all();

            Log::info($data);

            $value = $data['entry'][0]['changes'][0]['value'] ?? [];

            /*
        |--------------------------
        | HANDLE MESSAGE INCOMING
        |--------------------------
        */
            if (!empty($value['messages'])) {
                $messageData = $value['messages'][0];

                $phone = $messageData['from'] ?? null;
                $message = $messageData['text']['body'] ?? '';

                $conversation = WhatsappConversation::firstOrCreate(['phone' => $phone], ['customer_name' => $phone]);

                WhatsappMessage::create([
                    'conversation_id' => $conversation->id,
                    'phone' => $phone,
                    'message' => $message,
                    'sender' => 'customer',
                    'message_id' => $messageData['id'] ?? null,
                    'status' => 'sent',
                    'reply_message_id' => $messageData['context']['id'] ?? null,
                ]);

                $conversation->update([
                    'last_message_at' => now(),
                    'unread_count' => $conversation->unread_count + 1,
                ]);
            }

            $type = $messageData['type'] ?? null;
            if ($type === 'reaction') {
                $reactionData = $messageData['reaction'];

                $waMessageId = $reactionData['message_id'] ?? null;

                $emoji = $reactionData['emoji'] ?? '';

                $msg = WhatsappMessage::where('message_id', $waMessageId)->first();
                if ($msg) {
                    // remove reaction
                    if (empty($emoji)) {
                        MessageReaction::where('message_id', $msg->id)->where('customer_phone', $phone)->delete();
                    } else {
                        MessageReaction::updateOrCreate(
                            [
                                'message_id' => $msg->id,
                                'customer_phone' => $phone,
                            ],

                            [
                                'emoji' => $emoji,
                            ],
                        );
                    }
                }
            }

            if (!empty($value['statuses'])) {
                $statusData = $value['statuses'][0];

                $messageId = $statusData['id'] ?? null;
                $status = $statusData['status'] ?? null;

                if ($messageId) {
                    WhatsappMessage::where('message_id', $messageId)->update([
                        'status' => $status,
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
