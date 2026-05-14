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

    public function react($phone, $messageId, $emoji)
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $payload = [
            'messaging_product' => 'whatsapp',

            'to' => $phone,

            'type' => 'reaction',

            'reaction' => [
                'message_id' => $messageId,
                'emoji' => $emoji,
            ],
        ];

        return Http::withToken($token)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", $payload)
            ->json();
    }

    public function uploadMedia($filePath, $mimeType)
    {
        
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $response = Http::withToken($token)

            ->attach('file', fopen(storage_path('app/public/' . $filePath), 'r'), basename($filePath))

            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/media", [
                'messaging_product' => 'whatsapp',
                'type' => $mimeType,
            ]);

       
        return $response->json();
    }

    public function sendImage($phone, $mediaId, $caption = null, $replyId = null)
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $payload = [
            'messaging_product' => 'whatsapp',

            'to' => $phone,

            'type' => 'image',

            'image' => [
                'id' => $mediaId,
                'caption' => $caption,
            ],
        ];

        if ($replyId) {
            $payload['context'] = [
                'message_id' => $replyId,
            ];
        }

        return Http::withToken($token)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", $payload)
            ->json();
    }

    public function sendDocument($phone, $mediaId, $filename, $replyId = null)
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $payload = [
            'messaging_product' => 'whatsapp',

            'to' => $phone,

            'type' => 'document',

            'document' => [
                'id' => $mediaId,
                'filename' => $filename,
            ],
        ];

        if ($replyId) {
            $payload['context'] = [
                'message_id' => $replyId,
            ];
        }

        return Http::withToken($token)
            ->post("https://graph.facebook.com/v22.0/{$phoneNumberId}/messages", $payload)
            ->json();
    }

    public function getMediaUrl($mediaId)
    {
        $token = env('WHATSAPP_TOKEN');

        return Http::withToken($token)
            ->get("https://graph.facebook.com/v22.0/{$mediaId}")
            ->json();
    }

    public function downloadMedia($url)
    {
        $token = env('WHATSAPP_TOKEN');

        return Http::withToken($token)->get($url);
    }
}
