<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    public function send($phone, $message)
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        return Http::withToken($token)
            ->post(
                "https://graph.facebook.com/v22.0/{$phoneNumberId}/messages",
                [
                    'messaging_product' => 'whatsapp',

                    'to' => $phone,

                    'type' => 'text',

                    'text' => [
                        'body' => $message
                    ]
                ]
            )->json();
    }
}