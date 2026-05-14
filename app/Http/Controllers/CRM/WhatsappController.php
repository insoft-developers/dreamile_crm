<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\MessageReaction;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        |--------------------------------------------------------------------------
        | HANDLE INCOMING MESSAGE
        |--------------------------------------------------------------------------
        */

            if (!empty($value['messages'])) {
                $messageData = $value['messages'][0];

                $phone = $messageData['from'] ?? null;

                $type = $messageData['type'] ?? 'text';

                $message = '';

                $attachment = null;

                $mimeType = null;

                $fileName = null;

                /*
            |--------------------------------------------------------------------------
            | TEXT
            |--------------------------------------------------------------------------
            */

                if ($type === 'text') {
                    $message = $messageData['text']['body'] ?? '';
                }
                /*
            |--------------------------------------------------------------------------
            | IMAGE
            |--------------------------------------------------------------------------
            */ elseif ($type === 'image') {
                    $image = $messageData['image'];

                    $mediaId = $image['id'] ?? null;

                    $message = $image['caption'] ?? '';

                    $mimeType = $image['mime_type'] ?? null;

                    if ($mediaId) {
                        // ambil url media
                        $media = app(WhatsappService::class)->getMediaUrl($mediaId);

                        $url = $media['url'] ?? null;

                        if ($url) {
                            // download file
                            $file = app(WhatsappService::class)->downloadMedia($url);

                            $extension = explode('/', $mimeType)[1] ?? 'jpg';

                            $path = 'chat/' . Str::uuid() . '.' . $extension;

                            Storage::disk('public')->put($path, $file->body());

                            $attachment = $path;
                        }
                    }
                }
                /*
            |--------------------------------------------------------------------------
            | DOCUMENT
            |--------------------------------------------------------------------------
            */ elseif ($type === 'document') {
                    $document = $messageData['document'];

                    $mediaId = $document['id'] ?? null;

                    $fileName = $document['filename'] ?? 'file';

                    $mimeType = $document['mime_type'] ?? null;

                    if ($mediaId) {
                        $media = app(WhatsappService::class)->getMediaUrl($mediaId);

                        $url = $media['url'] ?? null;

                        if ($url) {
                            $file = app(WhatsappService::class)->downloadMedia($url);

                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);

                            $path = 'chat/' . Str::uuid() . '.' . $extension;

                            Storage::disk('public')->put($path, $file->body());

                            $attachment = $path;
                        }
                    }

                    $type = 'file';
                }

                /*
            |--------------------------------------------------------------------------
            | CONVERSATION
            |--------------------------------------------------------------------------
            */

                $conversation = WhatsappConversation::firstOrCreate(
                    [
                        'phone' => $phone,
                    ],

                    [
                        'customer_name' => $phone,
                    ],
                );

                /*
            |--------------------------------------------------------------------------
            | SAVE MESSAGE
            |--------------------------------------------------------------------------
            */

                WhatsappMessage::create([
                    'conversation_id' => $conversation->id,

                    'phone' => $phone,

                    'message' => $message,

                    'sender' => 'customer',

                    'message_id' => $messageData['id'] ?? null,

                    'status' => 'sent',

                    'attachment' => $attachment,

                    'mime_type' => $mimeType,

                    'file_name' => $fileName,

                    'type' => $type,

                    'reply_message_id' => $messageData['context']['id'] ?? null,
                ]);

                /*
            |--------------------------------------------------------------------------
            | UPDATE CONVERSATION
            |--------------------------------------------------------------------------
            */

                $conversation->update([
                    'last_message_at' => now(),

                    'unread_count' => $conversation->unread_count + 1,
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | HANDLE REACTION
        |--------------------------------------------------------------------------
        */

            if (!empty($value['messages']) && ($value['messages'][0]['type'] ?? null) === 'reaction') {
                $messageData = $value['messages'][0];

                $phone = $messageData['from'] ?? null;

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

            /*
        |--------------------------------------------------------------------------
        | HANDLE STATUS
        |--------------------------------------------------------------------------
        */

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

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            Log::error($e->getTraceAsString());

            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
