<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\BroadcastItem;
use App\Models\Customer;
use App\Models\User;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $view = 'dashboard';
        $totalLeads = Customer::whereNull('is_customer')->count();
        $newLeadsToday = Customer::whereNull('is_customer')->whereDate('created_at', today())->count();
        $activeCustomers = Customer::where('is_customer', 1)
            ->where('updated_at', '>=', now()->subDays(30))
            ->count();
        $totalCustomers = Customer::where('is_customer', 1)->count();
        $newCustomersThisMonth = Customer::where('is_customer', 1)->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();

        $conversionRate = $totalLeads > 0 ? round(($totalCustomers / $totalLeads) * 100, 1) : 0;

        $todayChats = WhatsappMessage::whereDate('created_at', today())->count();
        $incomingChats = WhatsappMessage::whereDate('created_at', today())->where('sender', 'customer')->count();
        $outgoingChats = WhatsappMessage::whereDate('created_at', today())->where('sender', 'agent')->count();

        $unreadChats = WhatsappConversation::where('unread_count', '>', 0)->count();
        $broadcastToday = BroadcastItem::where('status', 'sent')->whereDate('created_at', today())->count();

        return view('crm.dashboard', compact('view', 'totalLeads', 'newLeadsToday', 'activeCustomers', 'newCustomersThisMonth', 'conversionRate', 'todayChats', 'incomingChats', 'outgoingChats', 'unreadChats','broadcastToday'));
    }

    public function hearbeat(Request $request)
    {
        User::where('id', Auth::user()->id)->update([
            'last_seen' => now(),
        ]);
    }
}
