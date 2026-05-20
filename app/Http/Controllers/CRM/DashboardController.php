<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\BroadcastItem;
use App\Models\Customer;
use App\Models\User;
use App\Models\WhatsappConversation;
use App\Models\WhatsappMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $view = 'dashboard';
        $totalLeads_query = Customer::whereNull('is_customer');
        if (Auth::user()->branch_id) {
            $totalLeads_query->where('branch_id', Auth::user()->branch_id);
        }
        $totalLeads = $totalLeads_query->count();

        $newLeadsToday_query = Customer::whereNull('is_customer')->whereDate('created_at', today());
        if (Auth::user()->branch_id) {
            $newLeadsToday_query->where('branch_id', Auth::user()->branch_id);
        }
        $newLeadsToday = $newLeadsToday_query->count();

        $activeCustomers_query = Customer::where('is_customer', 1)->where('updated_at', '>=', now()->subDays(30));
        if (Auth::user()->branch_id) {
            $activeCustomers_query->where('branch_id', Auth::user()->branch_id);
        }
        $activeCustomers = $activeCustomers_query->count();

        $totalCustomers_query = Customer::where('is_customer', 1);
        if (Auth::user()->branch_id) {
            $totalCustomers_query->where('branch_id', Auth::user()->branch_id);
        }
        $totalCustomers = $totalCustomers_query->count();

        $newCustomersThisMonth_query = Customer::where('is_customer', 1)->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year);
        if (Auth::user()->branch_id) {
            $newCustomersThisMonth_query->where('branch_id', Auth::user()->branch_id);
        }

        $newCustomersThisMonth = $newCustomersThisMonth_query->count();

        $conversionRate = $totalLeads > 0 ? round(($totalCustomers / $totalLeads) * 100, 1) : 0;

        $todayChats_query = WhatsappMessage::with('user')->whereDate('created_at', today());
        if (Auth::user()->branch_id) {
            $todayChats_query->whereHas('user', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $todayChats = $todayChats_query->count();

        $incomingChats_query = WhatsappMessage::with('user')->whereDate('created_at', today())->where('sender', 'customer');
        if (Auth::user()->branch_id) {
            $incomingChats_query->whereHas('user', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }

        $incomingChats = $incomingChats_query->count();

        $outgoingChats_query = WhatsappMessage::with('user')->whereDate('created_at', today())->where('sender', 'agent');
        if (Auth::user()->branch_id) {
            $outgoingChats_query->whereHas('user', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $outgoingChats = $outgoingChats_query->count();

        $unreadChats_query = WhatsappConversation::with('customer')->where('unread_count', '>', 0);
        if (Auth::user()->branch_id) {
            $unreadChats_query->whereHas('customer', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $unreadChats = $unreadChats_query->count();

        $broadcastToday_query = BroadcastItem::with('customer')->where('status', 'sent')->whereDate('created_at', today());
        if (Auth::user()->branch_id) {
            $broadcastToday_query->whereHas('customer', function ($q) {
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $broadcastToday = $broadcastToday_query->count();

        $dates = collect();
        $incomingData = collect();
        $outgoingData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $dates->push($date->format('d M'));

            // incoming
            $incoming_query = WhatsappMessage::with('user')->whereDate('created_at', $date->toDateString())->where('sender', 'customer');
            if (Auth::user()->branch_id) {
                $incoming_query->whereHas('user', function ($q) {
                    $q->where('branch_id', Auth::user()->branch_id);
                });
            }
            $incoming = $incoming_query->count();

            // outgoing
            $outgoing_query = WhatsappMessage::with('user')->whereDate('created_at', $date->toDateString())->where('sender', 'agent');
            if (Auth::user()->branch_id) {
                $outgoing_query->whereHas('user', function ($q) {
                    $q->where('branch_id', Auth::user()->branch_id);
                });
            }
            $outgoing = $outgoing_query->count();

            $incomingData->push($incoming);
            $outgoingData->push($outgoing);
        }

        $months = [];
        $leadData = [];
        $customerData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            // leads
            $leadData_query = Customer::whereNull('is_customer')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year);
            if (Auth::user()->branch_id) {
                $leadData_query->where('branch_id', Auth::user()->branch_id);
            }
            $leadData[] = $leadData_query->count();

            // customer conversion
            $customerData_query = Customer::where('is_customer', 1)->whereMonth('updated_at', $date->month)->whereYear('updated_at', $date->year);
            if (Auth::user()->branch_id) {
                $customerData_query->where('branch_id', Auth::user()->branch_id);
            }
            $customerData[] = $customerData_query->count();
        }

        $totalBroadcast_query = BroadcastItem::with('customer');
        if (Auth::user()->branch_id) {
            $totalBroadcast_query->whereHas('customer', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $totalBroadcast = $totalBroadcast_query->count();

        $broadcastSent_query = BroadcastItem::with('customer')->where('status', 'sent');
        if (Auth::user()->branch_id) {
            $broadcastSent_query->whereHas('customer', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $broadcastSent = $broadcastSent_query->count();



        $broadcastDelivered_query = BroadcastItem::with('customer')->where('status', 'delivered');
        if (Auth::user()->branch_id) {
            $broadcastDelivered_query->whereHas('customer', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $broadcastDelivered = $broadcastDelivered_query->count();

        
        $broadcastRead_query = BroadcastItem::with('customer')->where('status', 'read');
        if (Auth::user()->branch_id) {
            $broadcastRead_query->whereHas('customer', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $broadcastRead = $broadcastRead_query->count();

        $broadcastFailed_query = BroadcastItem::with('customer')->where('status', 'failed');
        if (Auth::user()->branch_id) {
            $broadcastFailed_query->whereHas('customer', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            });
        }
        $broadcastFailed = $broadcastFailed_query->count();

        $sentPercent = $totalBroadcast > 0 ? round(($broadcastSent / $totalBroadcast) * 100) : 0;

        $deliveredPercent = $totalBroadcast > 0 ? round(($broadcastDelivered / $totalBroadcast) * 100) : 0;

        $readPercent = $totalBroadcast > 0 ? round(($broadcastRead / $totalBroadcast) * 100) : 0;

        $failedPercent = $totalBroadcast > 0 ? round(($broadcastFailed / $totalBroadcast) * 100) : 0;

        return view('crm.dashboard', compact('view', 'totalLeads', 'newLeadsToday', 'activeCustomers', 'newCustomersThisMonth', 'conversionRate', 'todayChats', 'incomingChats', 'outgoingChats', 'unreadChats', 'broadcastToday', 'dates', 'incomingData', 'outgoingData', 'months', 'leadData', 'customerData', 'totalBroadcast', 'broadcastSent', 'broadcastDelivered', 'broadcastRead', 'broadcastFailed', 'sentPercent', 'deliveredPercent', 'readPercent', 'failedPercent'));
    }

    public function hearbeat(Request $request)
    {
        User::where('id', Auth::user()->id)->update([
            'last_seen' => now(),
        ]);
    }
}
