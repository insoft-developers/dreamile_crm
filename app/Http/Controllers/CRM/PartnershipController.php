<?php

namespace App\Http\Controllers\CRM;

use App\Exports\PartnershipExport;
use App\Http\Controllers\Controller;
use App\Models\Partnership;
use App\Models\PartnershipType;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PartnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function table(Request $request)
    {
        if ($request->ajax()) {

            $data = Partnership::with('partnerType')
                ->orderBy('id', 'desc');

            if ($request->filter_start_date && $request->filter_end_date) {

                $startDate = date('Y-m-d', strtotime($request->filter_start_date));
                $endDate   = date('Y-m-d', strtotime($request->filter_end_date));

                $data->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            }

            if ($request->filter_jenis_partner) {
                $data->where('partner_type_id', $request->filter_jenis_partner);
            }

            if ($request->filter_pic_dreamile) {
                $data->where('pic_dreamile', $request->filter_pic_dreamile);
            }

            if ($request->filter_provinsi) {
                $data->where('province_id', $request->filter_provinsi);
            }

            if ($request->filter_city) {
                $data->where('city_id', $request->filter_city);
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('file', function ($row) {
                    $html = '';
                    if (!empty($row->image)) {
                        $html .= '<a target="_blank" href="' . asset('/storage/' . $row->image) . '">Lihat Foto</a>';
                    }

                    return $html;
                })
                ->addColumn('mou_file', function ($row) {
                    $html = '';
                    if (!empty($row->mou_file)) {
                        $html .= '<a target="_blank" href="' . asset('/storage/' . $row->mou_file) . '">File Mou</a>';
                    }

                    return $html;
                })
                ->addColumn('partner_type_id', function ($row) {
                    return $row->partnerType->name ?? '-';
                })

                ->filterColumn('partner_type_id', function ($query, $keyword) {
                    $query->whereHas('partnerType', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
                })


                ->addColumn('pic_dreamile', function ($row) {
                    return $row->picDreamile->name ?? '-';
                })

                ->filterColumn('pic_dreamile', function ($query, $keyword) {
                    $query->whereHas('picDreamile', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
                })


                ->addColumn('start_date', function ($row) {
                    if (!$row->start_date) {
                        return '-';
                    }

                    return date('d-m-Y', strtotime($row->start_date));
                })

                ->addColumn('expired_date', function ($row) {
                    if (!$row->expired_date) {
                        return '-';
                    }

                    return date('d-m-Y', strtotime($row->expired_date));
                })

                ->filterColumn('expired_date', function ($query, $keyword) {

                    $query->whereRaw(
                        "DATE_FORMAT(expired_date, '%d-%m-%Y') LIKE ?",
                        ['%' . $keyword . '%']
                    );
                })

                ->addColumn('action', function ($row) {

                    $button = '';
                    $button .= '<center>';

                    $button .= '<button onclick="editData(' . $row->id . ')" 
                        title="Edit Data" 
                        class="me-0 btn btn-insoft btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </button>';

                    $button .= '<button onclick="deleteData(' . $row->id . ')" 
                        style="margin-left:3px;" 
                        title="Delete Data" 
                        class="btn btn-insoft btn-danger">
                        <i class="bi bi-trash3"></i>
                    </button>';

                    $button .= '</center>';

                    return $button;
                })

                ->rawColumns([
                    'action',
                    'file',
                    'mou_file'
                ])

                ->make(true);
        }
    }

    /**
     * Display the resource.
     */
    public function index()
    {
        $view = 'partnership';
        $type = PartnershipType::orderBy('name')->get();
        $users = User::where('is_active', 1)->get();

        return view('crm.partnership.list.index', compact('view', 'type', 'users'));
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
        $validated = $request->validate([
            'partner_type_id'       => 'required|integer',
            'instance_name'         => 'required|string|max:255',
            'province_id'           => 'required|string',
            'city_id'               => 'required|string',
            'address'               => 'required|string|max:255',
            'pic_name'              => 'required|string|max:255',
            'pic_title'             => 'nullable|string|max:255',
            'whatsapp'              => 'nullable|string|max:255',
            'email'                 => 'nullable|email|max:255',
            'pic_dreamile'          => 'nullable|integer',
            'partnership_type_name' => 'nullable|string|max:255',
            'start_date'            => 'nullable|date',
            'expired_date'          => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'mou_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'province_name'         => 'nullable|string',
            'city_name'             => 'nullable|string'

        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('mous', 'public');
        }

        $validated['image'] = $path;


        $path2 = null;

        if ($request->hasFile('mou_file')) {
            $path2 = $request->file('mou_file')->store('perjanjian', 'public');
        }

        $validated['mou_file'] = $path2;

        Partnership::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
        ]);
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
        $data = Partnership::find($id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Partnership::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'partner_type_id'        => 'required|integer',
            'instance_name'          => 'required|string|max:255',
            'province_id'            => 'required|string',
            'city_id'                => 'required|string',
            'address'                => 'required|string|max:255',
            'pic_name'               => 'required|string|max:255',
            'pic_title'              => 'nullable|string|max:255',
            'whatsapp'               => 'nullable|string|max:255',
            'email'                  => 'nullable|email|max:255',
            'pic_dreamile'           => 'nullable|integer',
            'partnership_type_name'  => 'nullable|string|max:255',
            'start_date'             => 'nullable|date',
            'expired_date'           => 'nullable|date',
            'province_name'          => 'nullable|string',
            'city_name'              => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'mou_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);


        if ($request->hasFile('image')) {


            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }


            $path = $request->file('image')->store('mous', 'public');

            $validated['image'] = $path;
        } else {

            $validated['image'] = $data->image;
        }


        if ($request->hasFile('mou_file')) {


            if ($data->mou_file && Storage::disk('public')->exists($data->mou_file)) {
                Storage::disk('public')->delete($data->mou_file);
            }


            $path = $request->file('mou_file')->store('perjanjian', 'public');

            $validated['mou_file'] = $path;
        } else {

            $validated['mou_file'] = $data->mou_file;
        }


        $data->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diubah.',
        ]);
    }


    public function destroy(string $id)
    {
        $data = Partnership::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        // Hapus file jika ada
        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        // Hapus data dari database
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }


    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PartnershipExport($request),
            'partnership-' . date('Y-m-d-His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $data = Partnership::with([
            'partnerType',
            'picDreamile'
        ])->orderBy('id', 'desc');

        // Filter tanggal
        if ($request->filter_start_date && $request->filter_end_date) {

            $startDate = date(
                'Y-m-d',
                strtotime($request->filter_start_date)
            );

            $endDate = date(
                'Y-m-d',
                strtotime($request->filter_end_date)
            );

            $data->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // Filter jenis partner
        if ($request->filter_jenis_partner) {
            $data->where(
                'partner_type_id',
                $request->filter_jenis_partner
            );
        }

        // Filter PIC Dreamile
        if ($request->filter_pic_dreamile) {
            $data->where(
                'pic_dreamile',
                $request->filter_pic_dreamile
            );
        }

        // Filter provinsi
        if ($request->filter_provinsi) {
            $data->where(
                'province_id',
                $request->filter_provinsi
            );
        }

        // Filter kota
        if ($request->filter_city) {
            $data->where(
                'city_id',
                $request->filter_city
            );
        }

        $partnerships = $data->get();

        $pdf = Pdf::loadView(
            'crm.partnership.list.pdf',
            compact('partnerships')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream(
            'partnership-' . date('Y-m-d-His') . '.pdf'
        );
    }
}
