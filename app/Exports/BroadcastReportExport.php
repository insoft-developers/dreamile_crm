<?php

namespace App\Exports;

use App\Models\Broadcast;
use App\Models\Customer;
use App\Models\Presentation;
use Illuminate\Support\Facades\Auth;
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


class BroadcastReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell, WithColumnWidths
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
        $data = Broadcast::query();
        if (Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }
        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $data->whereBetween('created_at', [
                $this->request->filter_start_date . ' 00:00:00',
                $this->request->filter_end_date . ' 23:59:59'
            ]);
        }

        if ($this->request->filter_branch) {
            $data->where('branch_id', $this->request->filter_branch);
        }
        if ($this->request->filter_status) {
            $data->where('status', $this->request->filter_status);
        }
        if ($this->request->filter_created_by) {
            $data->where('userid', $this->request->filter_created_by);
        }

        return $data->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER TABLE
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
        'No', 
        'Date', 
        'Broadcast Name', 
        'Message', 
        'Template', 
        'Total', 
        'Sent', 
        'Failed', 
        '% Sent', 
        '% Failed', 
        'Status', 
        'Branch',  
        'Created By'
        ];
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
            date('d-m-Y', strtotime($row->created_at)),
            $row->name ?? '',
            $row->message ?? '',
            $row->template_name ?? '',
            $row->total ?? 0,
            $row->sent ?? 0,
            $row->failed ?? 0,
            $this->hitungPercent($row->sent, $row->total),
            $this->hitungPercent($row->failed, $row->total),
            $row->status,
            optional($row->branch)->branch_name ?? '',
            optional($row->user)->name ?? ''

            
        ];
    }

    private function hitungPercent($angka, $total) 
    {
        $hasil = $angka/$total*100;
        return number_format($hasil);
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
        $reportTitle = "BROADCAST REPORT";

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
