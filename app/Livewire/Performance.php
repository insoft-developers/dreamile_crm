<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Performance extends Component
{
    public function render()
    {
        $data = User::query()
            ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
            ->leftJoin('customers', function ($join) {
                $join->on('customers.created_by', '=', 'users.id')
                    ->whereMonth('customers.created_at', now()->month)
                    ->whereYear('customers.created_at', now()->year);
            })
            ->select(
                'users.id',
                'users.name',
                DB::raw("COALESCE(branches.branch_name, '') as branch_name"),

                DB::raw("COUNT(DISTINCT customers.id) as total_visit"),

                DB::raw("COUNT(DISTINCT CASE WHEN customers.status='deal' THEN customers.id END) as total_deal"),

                DB::raw("COUNT(DISTINCT CASE WHEN customers.status='nok' THEN customers.id END) as total_nok"),
                DB::raw("COUNT(DISTINCT CASE WHEN customers.status='confirm' THEN customers.id END) as total_confirm"),

                DB::raw("
            (
                SELECT COALESCE(SUM(p.payment_amount),0)
                FROM payments p
                INNER JOIN customers c ON c.id = p.customer_id
                WHERE c.created_by = users.id
                AND MONTH(p.payment_date) = MONTH(CURDATE())
                AND YEAR(p.payment_date) = YEAR(CURDATE())
            ) as total_payment
        ")
            )
            ->groupBy(
                'users.id',
                'users.name',
                'branches.branch_name'
            )
            ->orderByDesc('total_visit')
            ->get();


        return view('components.performance', compact('data'));
    }
}
