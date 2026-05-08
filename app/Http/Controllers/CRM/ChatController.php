<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = 'inbox';
        return view('crm.whatsapp.inbox.index2', compact('view'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function waTest()
    {
        $token = env('WHATSAPP_TOKEN');

        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');

        $response = Http::withToken($token)->post("https://graph.facebook.com/v22.0/$phoneNumberId/messages", [
            'messaging_product' => 'whatsapp',

            'to' => '6282165174835',

            'type' => 'text',
            'text' => [
                'body' => 'WhatsApp CRM Testing KIrim dari laravel',
            ],
        ]);

        dd($response->status(), $response->json());
    }
}
