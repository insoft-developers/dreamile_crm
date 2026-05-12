<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    public function send($phone, $message, $isReply = null)
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $payload = [
            'messaging_product' => 'whatsapp',

            'to' => $phone,

            'type' => 'text',

            'text' => [
                'body' => $message,
            ],
        ];

        // REPLY MESSAGE
        if ($isReply) {
            $payload['context'] = [
                'message_id' => $isReply,
            ];
        }

        return Http::withToken($token)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", $payload)
            ->json();
    }
}
