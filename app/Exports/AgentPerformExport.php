<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Presentation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class AgentPerformExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell, WithColumnWidths
{
    protected $request;
    protected $company;

    public function __construct($request, $company)
    {
        $this->request = $request;
        $this->company = $company;
    }

    /*
    |--------------------------------------------------------------------------
    | START CELL
    |--------------------------------------------------------------------------
    */
    public function startCell(): string
    {
        return 'A5';
    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */
    public function collection()
    {
        $customerSub = DB::table('customers')
            ->select(
                'consultant_id',
                DB::raw('COUNT(*) as total_leads'),
                DB::raw("SUM(CASE WHEN status = 'deal' THEN 1 ELSE 0 END) as total_deals"),
                DB::raw("SUM(CASE WHEN status = 'nok' THEN 1 ELSE 0 END) as total_nok"),
                DB::raw("SUM(CASE WHEN status = 'confirm' THEN 1 ELSE 0 END) as total_confirm")
            );

        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $customerSub->whereBetween('created_at', [
                $this->request->filter_start_date . ' 00:00:00',
                $this->request->filter_end_date . ' 23:59:59'
            ]);
        }

        $customerSub->groupBy('consultant_id');

        $paymentSub = DB::table('payments as p')
            ->join('customers as c', 'c.id', '=', 'p.customer_id')
            ->select(
                'c.consultant_id',

                DB::raw('COUNT(DISTINCT p.id) as total_payment_transactions'),

                DB::raw('COALESCE(SUM(p.payment_amount), 0) as total_payment')
            );

        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $paymentSub->whereBetween('p.payment_date', [
                $this->request->filter_start_date . ' 00:00:00',
                $this->request->filter_end_date . ' 23:59:59'
            ]);
        }



        $paymentSub->groupBy('c.consultant_id');


        $query = DB::table('users as u')

            ->leftJoin('whatsapp_conversations as wc', function ($join) {

                $join->on('wc.assigned_to', '=', 'u.id');

                // FILTER TANGGAL CHAT
                if ($this->request->filter_start_date && $this->request->filter_end_date) {
                    $join->whereBetween('wc.created_at', [
                        $this->request->filter_start_date . ' 00:00:00',
                        $this->request->filter_end_date . ' 23:59:59'
                    ]);
                }
            })

            ->leftJoin('whatsapp_messages as wm', 'wm.conversation_id', '=', 'wc.id')
            ->leftJoin('branches as br', 'u.branch_id', '=', 'br.id')

            ->leftJoinSub($customerSub, 'cs', function ($join) {
                $join->on('cs.consultant_id', '=', 'u.id');
            })
            ->leftJoinSub($paymentSub, 'ps', function ($join) {
                $join->on('ps.consultant_id', '=', 'u.id');
            });


        // HAPUS filter tanggal yang sebelumnya ada di sini
        // karena sudah dipindahkan ke LEFT JOIN

        if ($this->request->filter_consultant) {
            $query->where('u.id', $this->request->filter_consultant);
        }

        if ($this->request->filter_branch) {
            $query->where('u.branch_id', $this->request->filter_branch);
        }

        $data = $query
            ->select(
                'u.id',
                'u.name',
                'u.branch_id',
                'br.branch_name',

                DB::raw('COUNT(DISTINCT wc.id) as assigned_chat'),

                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN wc.status = 'open'
                    THEN wc.id
                END
            ) as open_chat
        "),

                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN wc.status = 'resolve'
                    THEN wc.id
                END
            ) as closed_chat
        "),

                DB::raw("
            COUNT(
                CASE
                    WHEN wm.sender = 'customer'
                    THEN wm.id
                END
            ) as incoming_message
        "),

                DB::raw("
            COUNT(
                CASE
                    WHEN wm.sender = 'agent'
                    THEN wm.id
                END
            ) as outgoing_message
        "),

                DB::raw('COALESCE(MAX(cs.total_leads),0) as total_leads'),
                DB::raw('COALESCE(MAX(cs.total_deals),0) as total_deals'),
                DB::raw('COALESCE(MAX(cs.total_nok),0) as total_nok'),
                DB::raw('COALESCE(MAX(cs.total_confirm),0) as total_confirm'),
                DB::raw("
                            COALESCE(
                                MAX(ps.total_payment_transactions),
                                0
                            ) as total_payment_transactions
                        "),

                DB::raw("
                            COALESCE(
                                MAX(ps.total_payment),
                                0
                            ) as total_payment
                        ")
            )
            ->groupBy(
                'u.id',
                'u.name',
                'u.branch_id',
                'br.branch_name'
            )
            ->get();

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER TABLE
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return ['No', 'Consultant Name', 'Branch', 'Leads', 'Deal', 'NOK','Confirm','Omset', 'Assigned Chat', 'Open Chat', 'Closed Chat', 'Incoming Message', 'Outgoing Message'];
    }

    /*
    |--------------------------------------------------------------------------
    | MAPPING DATA
    |--------------------------------------------------------------------------
    */
    public function map($row): array
    {

        static $no = 1;

        return [
            $no++,
            $row->name ?? '-',
            $row->branch_name ?? '-',
            $row->total_leads ?? 0,
            $row->total_deals ?? 0,
            $row->total_nok ?? 0,
            $row->total_confirm ?? 0,
            $row->total_payment ?? 0,
            $row->assigned_chat ?? '',
            $row->open_chat ?? '',
            $row->closed_chat ?? '',
            $row->incoming_message ?? '',
            $row->outgoing_message ?? ''
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // COMPANY NAME
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
            ],

            // BRANCH
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            // REPORT TITLE
            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],

            // TABLE HEADER
            5 => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '198754',
                    ],
                ],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | AFTER SHEET
    |--------------------------------------------------------------------------
    */
    public function registerEvents(): array
    {
        $company_name = $this->company->company_name;
        $address = $this->company->address;
        $reportTitle = "AGENT PERFORMANCE REPORT";

        return [
            AfterSheet::class => function (AfterSheet $event) use ($company_name, $address, $reportTitle) {
                $sheet = $event->sheet;

                /*
                |--------------------------------------------------------------------------
                | HEADER TITLE
                |--------------------------------------------------------------------------
                */
                // $sheet->getStyle('Q:Q')->getAlignment()->setWrapText(true);

                // COMPANY
                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', $company_name);

                // BRANCH
                $sheet->mergeCells('A2:M2');
                $sheet->setCellValue('A2', $address);

                // REPORT TITLE
                $sheet->mergeCells('A3:M3');
                $sheet->setCellValue('A3', $reportTitle);

                /*
                |--------------------------------------------------------------------------
                | TITLE ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:M3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                /*
                |--------------------------------------------------------------------------
                | ROW HEIGHT
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(22);

                /*
                |--------------------------------------------------------------------------
                | BORDER TABLE
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();

                $sheet
                    ->getStyle('A5:M' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | VERTICAL ALIGN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:M' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | TEXT WRAP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:M' . $lastRow)
                    ->getAlignment()

                    ->setWrapText(true);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            // 'Q' => 50,
        ];
    }
}
