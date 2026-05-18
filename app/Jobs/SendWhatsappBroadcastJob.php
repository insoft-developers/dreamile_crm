<?php

namespace App\Jobs;

use App\Models\Broadcast;
use App\Models\BroadcastItem;
use App\Models\Template;
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

        Log::info([
            'template_name' => $broadcast->template_name,
            'language' => $template->language,
        ]);

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

        foreach ($details as $detail) {
            try {
                $response = Http::timeout(120)
                    ->connectTimeout(60)
                    ->withToken($token)
                    ->post($waUrl, [
                        'messaging_product' => 'whatsapp',
                        'to' => $detail->phone,
                        'type' => 'template',
                        'template' => [
                            'name' => $broadcast->template_name,

                            'language' => [
                                'code' => $template->language,
                            ],

                            'components' => [
                                [
                                    'type' => 'body',

                                    'parameters' => [
                                        [
                                            'type' => 'text',

                                            'text' => 'Budi',
                                        ],
                                        [
                                            'type' => 'text',

                                            'text' => 'Budi',
                                        ],
                                        [
                                            'type' => 'text',

                                            'text' => 'Budi',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ]);

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
