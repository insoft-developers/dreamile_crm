<?php

namespace App\Exports;

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


class PresentationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell, WithColumnWidths
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
        $data = Presentation::query()->with(['consultant', 'branch']);
        if(Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }

        // FILTER TANGGAL
        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $data->whereBetween('date', [$this->request->filter_start_date, $this->request->filter_end_date ]);
        }

        // FILTER CONSULTANT
        if ($this->request->filter_consultant) {
            $data->where('consultant_id', $this->request->filter_consultant);
        }

        // FILTER BRANCH
        if ($this->request->filter_branch) {
            $data->where('branch_id', $this->request->filter_branch);
        }

        return $data->orderBy('id', 'desc')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER TABLE
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return ['No', 'Title', 'Location', 'Date', 'Consultant', 'Audience', 'Tertarik', 'Sangat Tertarik', 'Kurang Tertarik', 'Leads', 'Deals', 'Description', 'Branch', 'Created By', 'Created At'];
    }

    /*
    |--------------------------------------------------------------------------
    | MAPPING DATA
    |--------------------------------------------------------------------------
    */
    public function map($row): array
    {
        static $no = 1;

        return [$no++, $row->title ?? '-', $row->location ?? '-', $row->date ?? '-',optional( $row->consultant)->name ?? '', $row->audience ?? '-', $row->tertarik ?? '-', $row->sangat_tertarik ?? '-', $row->kurang_tertarik ?? '-', optional($row->leads)->count() ?? '-', optional($row->deals)->count(), $row->description ?? '', optional($row->branch)->branch_name ?? '-', optional($row->createdBy)->name ?? '', $row->created_at ? date('d M Y H:i', strtotime($row->created_at)) : '-'];
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
        $reportTitle = "PRESENTATION REPORT";

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
                $sheet->mergeCells('A1:O1');
                $sheet->setCellValue('A1', $company_name);

                // BRANCH
                $sheet->mergeCells('A2:O2');
                $sheet->setCellValue('A2', $address);

                // REPORT TITLE
                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', $reportTitle);

                /*
                |--------------------------------------------------------------------------
                | TITLE ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:O3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
                    ->getStyle('A5:O' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | VERTICAL ALIGN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:O' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | TEXT WRAP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:O' . $lastRow)
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
