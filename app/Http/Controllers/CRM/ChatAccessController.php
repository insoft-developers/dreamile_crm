<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ChatAccessToken;
use App\Models\WhatsappConversation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatAccessController extends Controller
{
    public function index(String $token)
    {
        $access = ChatAccessToken::where('token', $token)
            ->where('expired_at', '>', now())
            ->firstOrFail();

        if ($access) {
            Auth::loginUsingId($access->userid);
            $conv = WhatsappConversation::findorFail($access->conversation_id);
            if ($conv) {
                $access->used_at = Carbon::now();
                $access->save();
                return redirect('/chat/' . $conv->customer->id);
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }
}
