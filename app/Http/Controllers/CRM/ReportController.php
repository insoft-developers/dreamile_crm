<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function lead()
    {
        $view = 'report';
        $branches = Branch::all();
        return view('crm.reports.lead.index', compact('view', 'branches'));
    }

    public function leadReportData(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');

        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $query = Customer::query();

        if (Auth::user()->branch_id) {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->branch_id) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->search . '%')->orWhere('phone_number', 'like', '%' . $request->search . '%');
            });
        }

        $summary = (clone $query)
            ->selectRaw(
                '
            COUNT(*) as total,
            SUM(status = "new-lead") as new_leads,
            SUM(status = "visit") as visit,
            SUM(status = "confirm") as confirm
        ',
            )
            ->first();

        $daily = (clone $query)
            ->selectRaw(
                '
            DATE(created_at) as date,
            COUNT(*) as total
        ',
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $statusData = (clone $query)

            ->selectRaw(
                '
        status,
        COUNT(*) as total
    ',
            )
            ->groupBy('status')
            ->get();

        $sources = (clone $query)->selectRaw('lead_source_id,COUNT(*) as total')->groupBy('lead_source_id')->orderByDesc('total')->take(5)->get();

        $topAdmins = (clone $query)->selectRaw('created_by,COUNT(*) as total')->with('createdBy')->groupBy('created_by')->orderByDesc('total')->take(5)->get();

        $recentLeads = (clone $query)->with('branch', 'createdBy')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'summary' => $summary,
            'daily' => $daily,
            'chart' => [
                'labels' => $daily->pluck('date'),
                'data' => $daily->pluck('total'),
            ],
            'status_chart' => [
                'labels' => $statusData->pluck('status'),
                'data' => $statusData->pluck('total'),
            ],
            'source_chart' => [
                'labels' => $sources->pluck('lead_source_id'),
                'data' => $sources->pluck('total'),
            ],
            'top_admins' => $topAdmins,
            'recent_leads' => $recentLeads,
        ]);
    }

    public function chat() {}

    public function broadcast() {}

    public function followup() {}

    public function conversion() {}

    public function admin_performance() {}
}
