<?php

namespace App\Exports;

use App\Models\Customer;
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

class LeadExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell,WithColumnWidths
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
        $data = Customer::query()->with(['leadsource', 'consultant', 'branch']);

        // FILTER TANGGAL
        if ($this->request->start_date && $this->request->end_date) {
            $data->whereBetween('created_at', [$this->request->start_date . ' 00:00:00', $this->request->end_date . ' 23:59:59']);
        }

        // FILTER STATUS
        if ($this->request->status) {
            $data->where('status', $this->request->status);
        }

        // FILTER LEAD SOURCE
        if ($this->request->filter_lead_source) {
            $data->where('lead_source_id', $this->request->filter_lead_source);
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
        return ['No', 'Full Name', 'Address', 'School', 'Class / Major', 'Phone Number', 'Email', 'Gender', 'Status', 'Consultant', 'Lead Source', 'Branch', 'Province', 'Regency', 'District', 'Village', 'Note', 'Created By', 'Created At'];
    }

    /*
    |--------------------------------------------------------------------------
    | MAPPING DATA
    |--------------------------------------------------------------------------
    */
    public function map($row): array
    {
        static $no = 1;
        if ($row->lead_source_id == 'event') {
            $lead_source = 'Event';
        } elseif ($row->lead_source_id == 'presentation') {
            $lead_source = 'Presentation';
        } else {
            $lead_source = optional($row->leadsource)->source_name ?? '-';
        }

        return [$no++, $row->fullname ?? '-', $row->full_address ?? '-', $row->school_from ?? '-', $row->class . '/' . $row->major, $row->phone_number ?? '-', $row->email ?? '-', $row->gender ?? '-', $row->status ?? '-', optional($row->consultant)->name ?? '-', $lead_source, optional($row->branch)->branch_name ?? '-', $row->province_name ?? '', $row->regency_name ?? '', $row->district_name ?? '', $row->village_name ?? '', $row->note ?? '', optional($row->createdBy)->name ?? '', $row->created_at ? date('d M Y H:i', strtotime($row->created_at)) : '-'];
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

        return [
            AfterSheet::class => function (AfterSheet $event) use ($company_name, $address) {
                $sheet = $event->sheet;

                /*
                |--------------------------------------------------------------------------
                | HEADER TITLE
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('Q:Q')->getAlignment()->setWrapText(true);

                // COMPANY
                $sheet->mergeCells('A1:S1');
                $sheet->setCellValue('A1', $company_name);

                // BRANCH
                $sheet->mergeCells('A2:S2');
                $sheet->setCellValue('A2', $address);

                // REPORT TITLE
                $sheet->mergeCells('A3:S3');
                $sheet->setCellValue('A3', 'LEAD DATA REPORT');

                /*
                |--------------------------------------------------------------------------
                | TITLE ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:S3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
                    ->getStyle('A5:S' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | VERTICAL ALIGN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:J' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | TEXT WRAP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:J' . $lastRow)
                    ->getAlignment()

                    ->setWrapText(true);
            },
        ];
    }

    public function columnWidths(): array
{
    return [
        'Q' => 50,
    ];
}
}
