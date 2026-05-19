<?php

namespace App\Jobs;

use App\Models\Broadcast;
use App\Models\BroadcastItem;
use App\Models\Template;
use App\Models\TemplateDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappBroadcastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $broadcastId;

    public function __construct($broadcastId)
    {
        $this->broadcastId = $broadcastId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $broadcast = Broadcast::find($this->broadcastId);
        $template = Template::where('template_name', $broadcast->template_name)->first();

        // Log::info([
        //     'template_name' => $broadcast->template_name,
        //     'language' => $template->language,
        // ]);

        if (!$template) {
            $broadcast->update([
                'status' => 'failed',
            ]);

            return;
        }

        if (!$broadcast) {
            return;
        }

        $details = BroadcastItem::where('broadcast_id', $broadcast->id)->where('status', 'pending')->get();

        $token = env('WHATSAPP_TOKEN');
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $waUrl = "https://graph.facebook.com/v23.0/{$phoneNumberId}/messages";
        $templateDetail = TemplateDetail::where('template_id', $template->id)->get();
        $paramNumber = $templateDetail->count();

        foreach ($details as $detail) {
            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $detail->phone,
                'type' => 'template',
                'template' => [
                    'name' => $broadcast->template_name,
                    'language' => [
                        'code' => $template->language,
                    ],
                ],
            ];

            if ($paramNumber > 0) {
                $components = [];

                $grouped = $templateDetail->groupBy('content_type');

                foreach ($grouped as $contentType => $items) {
                    $parameters = [];

                    foreach ($items as $item) {
                        $value = $item->field_value;

                        //
                        // VARIABLE DARI DATABASE
                        //
                        if ($item->field_type == 'name') {
                            $value = $detail->customer?->fullname ?? '';
                        } elseif ($item->field_type == 'phone') {
                            $value = $detail->customer?->phone_number ?? '';
                        } elseif ($item->field_type == 'email') {
                            $value = $detail->customer?->email ?? '';
                        } elseif ($item->field_type == 'address') {
                            $value = $detail->customer?->full_address ?? '';
                        } elseif ($item->field_type == 'school') {
                            $value = $detail->customer?->school_from ?? '';
                        }

                        //
                        // IMAGE
                        //
                        if ($item->field_type == 'image') {
                            $parameters[] = [
                                'type' => 'image',
                                'image' => [
                                    'link' => $value,
                                ],
                            ];
                        }

                        //
                        // TEXT
                        //
                        else {
                            $parameters[] = [
                                'type' => 'text',
                                'text' => (string) $value,
                            ];
                        }
                    }

                    //
                    // Tambahkan component
                    //
                    if (!empty($parameters)) {
                        $components[] = [
                            'type' => $contentType,
                            'parameters' => $parameters,
                        ];
                    }
                }

                //
                // Tambahkan ke payload
                //
                if (!empty($components)) {
                    $payload['template']['components'] = $components;
                }

                Log::info('payload', $payload);
            }

            try {
                $response = Http::timeout(120)->connectTimeout(60)->withToken($token)->post($waUrl, $payload);

                if ($response->successful()) {
                    $detail->update([
                        'status' => 'sent',
                        'error' => null,
                    ]);
                } else {
                    $detail->update([
                        'status' => 'failed',
                        'error' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                $detail->update([
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ]);
            }

            $broadcast->update([
                'sent' => BroadcastItem::where('broadcast_id', $broadcast->id)->where('status', 'sent')->count(),

                'failed' => BroadcastItem::where('broadcast_id', $broadcast->id)->where('status', 'failed')->count(),
            ]);

            sleep(2);
        }

        $broadcast->update([
            'status' => 'completed',
        ]);
    }
}
