<?php

namespace App\Http\Controllers\CRM;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{



    public function table(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::query();
            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween('payment_date', [$request->filter_start_date, $request->filter_end_date]);
            }


            if ($request->filter_student) {
                $data->where('customer_id', $request->filter_student);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('payment_date', function ($row) {
                    return date('d F Y', strtotime($row->payment_date));
                })
                ->addColumn('invoice', function ($row) {
                    return $row->payment_invoice;
                })
                ->addColumn('student_name', function ($row) {
                    return optional($row->customer)->fullname ?? '';
                })
                ->addColumn('whatsapp', function ($row) {
                    return optional($row->customer)->phone_number ?? '';
                })
                ->addColumn('branch_id', function ($row) {
                    return optional(optional($row->customer)->branch)->branch_name ?? '';
                })
                ->addColumn('consultant_id', function ($row) {
                    return optional(optional($row->customer)->consultant)->name ?? '';
                })
                ->addColumn('outstanding_amount', function ($row) {
                    return number_format($row->outstanding_amount);
                })
                ->addColumn('payment_amount', function ($row) {
                    return number_format($row->payment_amount);
                })
                ->addColumn('outstanding_payment', function ($row) {
                    return number_format($row->outstanding_payment);
                })
                ->addColumn('created_by', function ($row) {
                    return optional(optional($row->customer)->createdBy)->name ?? '';
                })
                ->addColumn('keterangan', function ($row) {
                    return '<div style="white-space:normal;width:100px;">' . $row->keterangan . '</div>';
                })

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->updated_at));
                })
                ->addColumn('action', function ($row) {
                    $button = '';
                    $button .= '<center>';

                    $disabled = "";
                    if(Auth::user()->position === 'supervisor') {
                        $disabled="";
                    } else {
                        $disabled = "disabled";
                    }

                    $button .= '<a href="' . route('payment.print', $row->id) . '" target="_blank"><button '.$disabled.' title="Print Data" class="me-0 btn btn-insoft btn-success"><i class="bi bi-printer"></i></button></a>';


                    $button .= '<button '.$disabled.' onclick="deleteData(' . $row->id . ')" style="margin-left:3px;" title="Delete Data" class="btn btn-insoft btn-danger"><i class="bi bi-trash3"></i></button>';

                    $button .= '</center>';
                    return $button;
                })
                ->rawColumns(['action', 'keterangan'])
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = 'payment';
        $c_query = Customer::where('status', 'deal');
        if (Auth::user()->branch_id) {
            $c_query->where('branch_id', Auth::user()->branch_id);
        }
        $customers = $c_query->get();
        return view('crm.customers.payment.index', compact('view', 'customers'));
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
        $input = $request->all();

        $validated = $request->validate([
            'payment_date' => 'required',
            'customer_id' => 'required',
            'payment_amount' => 'required'

        ]);

        $pembayaran = (int)$request->payment_amount;
        $sisa = (int)$request->outstanding_amount;

        if ($pembayaran > $sisa) {
            return response()->json([
                "success" => false,
                "message" => "Pembayaran lebih besar dari sisa tagihan"
            ]);
        }


        DB::beginTransaction();
        try {
            $input['payment_invoice'] = $this->generateInvoice();
            $input['created_by'] = Auth::user()->id;

            Payment::create($input);



            DB::table('customers')
                ->where('id', $request->customer_id)
                ->update([
                    'out_payment' => DB::raw("IFNULL(out_payment, 0) - {$pembayaran}"),
                    'payment'     => DB::raw("IFNULL(payment, 0) + {$pembayaran}"),
                ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
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
        DB::beginTransaction();
        try {
            $payment = Payment::find($id);
            $pembayaran = $payment->payment_amount;
            DB::table('customers')
                ->where('id', $payment->customer_id)
                ->update([
                    'out_payment' => DB::raw("IFNULL(out_payment, 0) + {$pembayaran}"),
                    'payment'     => DB::raw("IFNULL(payment, 0) - {$pembayaran}"),
                ]);

            $payment->delete();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Berhasil"

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()

            ]);
        }
    }

    public function selectStudent(Request $request)
    {
        $input = $request->all();



        $customer = Customer::find($input['id']);
        if ($customer->register_cost == null) {
            return response()->json([
                "success" => false,
                "message" => "Biaya Pendaftaran belum diisi, Masuk Ke Menu Student Data, Edit data student dan masukkan nilai Register Cost"
            ]);
        } else {
            return response()->json([
                "success" => true,
                "data" => $customer
            ]);
        }
    }

    public function generateInvoice()
    {
        $prefix = 'PAY-' . date('Ymd') . '-';

        $last = DB::table('payments')
            ->where('payment_invoice', 'like', $prefix . '%')
            ->orderByDesc('payment_invoice')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->payment_invoice, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function printData($id)
    {
        $payment = Payment::select(
            'payments.*',
            'customers.fullname',
            'customers.phone_number',
            'customers.full_address'
        )
            ->join('customers', 'customers.id', '=', 'payments.customer_id')
            ->where('payments.id', $id)
            ->firstOrFail();

        $com = Company::first();

        return view('crm.customers.payment.print', compact('payment', 'com'));
    }

    public function exportExcel(Request $request)
    {
        $company = Company::find(1);
        return Excel::download(new PaymentExport($request, $company), 'payment_report.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $company = Company::first();

        $data = Payment::query()->with(['customer', 'createdBy']);


        if ($request->filter_start_date && $request->filter_end_date) {
            $data->whereBetween('payment_date', [$request->filter_start_date, $request->filter_end_date]);
        }


        if ($request->filter_student) {
            $data->where('customer_id', $request->filter_student);
        }

        $payments = $data->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('crm.customers.payment.pdf', compact('payments', 'company'));

        // LANDSCAPE
        $pdf->setPaper('legal', 'landscape');

        return $pdf->stream('payment_report.pdf');
    }
}
