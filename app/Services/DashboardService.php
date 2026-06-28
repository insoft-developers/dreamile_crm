<?php

namespace App\Services;

use App\Models\WhatsappConversation;

class DashboardService
{

    public function dashboard($user)
    {

        return [

            'all'=>WhatsappConversation::count(),

            'mychat'=>WhatsappConversation::where('assigned_to',$user->id)->count(),

            'assigned'=>WhatsappConversation::whereNotNull('assigned_to')
                            ->where('status','open')
                            ->count(),

            'unassigned'=>WhatsappConversation::whereNull('assigned_to')
                            ->count(),

            'resolved'=>WhatsappConversation::where('status','resolved')
                            ->count(),

        ];

    }

}