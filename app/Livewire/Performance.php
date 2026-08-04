<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Performance extends Component
{
    public function render()
    {

        $startDate = Carbon::now()
            ->subMonthNoOverflow()
            ->startOfMonth()
            ->day(29)
            ->startOfDay();

        $endDate = Carbon::now()
            ->startOfMonth()
            ->day(28)
            ->endOfDay();

        $paymentSub = DB::table('payments as p')
            ->join('customers as c', 'c.id', '=', 'p.customer_id')
            ->whereColumn('c.consultant_id', 'users.id')
            ->whereBetween('p.payment_date', [
                $startDate,
                $endDate
            ])
            ->selectRaw('COALESCE(SUM(p.payment_amount), 0)');

        $data = User::query()
            ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')

            ->leftJoin('customers', function ($join) use ($startDate, $endDate) {
                $join->on('customers.created_by', '=', 'users.id')
                    ->whereBetween('customers.created_at', [
                        $startDate,
                        $endDate
                    ]);
            })

            ->select(
                'users.id',
                'users.name',

                DB::raw("
            COALESCE(branches.branch_name, '') as branch_name
        "),

                DB::raw("
            COUNT(DISTINCT customers.id) as total_visit
        "),

                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN customers.status = 'deal'
                    THEN customers.id
                END
            ) as total_deal
        "),

                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN customers.status = 'nok'
                    THEN customers.id
                END
            ) as total_nok
        "),

                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN customers.status = 'confirm'
                    THEN customers.id
                END
            ) as total_confirm
        ")
            )

            ->selectSub($paymentSub, 'total_payment')

            ->groupBy(
                'users.id',
                'users.name',
                'branches.branch_name'
            )

            ->orderByDesc('total_payment')
            ->orderByDesc('total_visit')
            ->get();


        return view('components.performance', compact('data'));
    }
}
