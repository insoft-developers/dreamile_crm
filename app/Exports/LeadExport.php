<?php

namespace App\Exports;

use App\Models\Customer;
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


class LeadExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell, WithColumnWidths
{
    protected $request;
    protected $company;
    protected $isCustomer;

    public function __construct($request, $company, $isCustomer = null)
    {
        $this->request = $request;
        $this->company = $company;
        $this->isCustomer = $isCustomer;
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
        $data = Customer::query()->with(['leadsource', 'consultant', 'branch', 'followup', 'events', 'presentation']);
        if ($this->isCustomer) {
            $data->where('is_customer', 1);
        } else {
            $data->whereNull('is_customer');
        }

        if (Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }

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
        return [
            'No',
            'Full Name',
            'Address',
            'School',
            'Class / Major',
            'Phone Number',
            'Email',
            'Gender',
            'Status',
            'Consultant',
            'Lead Source',
            'Presentation/Event',
            'Visit',
            'Followup',
            'Branch',
            'Province',
            'Regency',
            'District',
            'Village',
            'Note',
            'Created By',
            'Created At'
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
        if ($row->lead_source_id == 'event') {
            $lead_source = 'Event';
        } elseif ($row->lead_source_id == 'presentation') {
            $lead_source = 'Presentation';
        } else {
            $lead_source = optional($row->leadsource)->source_name ?? '-';
        }

        $prevent = '-';

        if ($row->lead_source_id == 'presentation' && $row->presentation) {

            $audience = $row->presentation->audience ?? 0;
            $tr = $row->presentation->tertarik ?? 0;
            $st = $row->presentation->sangat_tertarik ?? 0;
            $kt = $row->presentation->kurang_tertarik ?? 0;

            $prevent =
                "• " . date('d F Y', strtotime($row->presentation->date)) . "\n" .
                "• " . ($row->presentation->title ?? '-') . "\n" .
                "• " . ($row->presentation->location ?? '-') . "\n" .
                "• " . $audience . '/' . $tr . '/' . $st . '/' . $kt;
        } elseif ($row->lead_source_id == 'event' && $row->events) {

            $prevent =
                "• " . date('d F Y', strtotime($row->events->event_date)) . "\n" .
                "• " . ($row->events->event_name ?? '-') . "\n" .
                "• " . ($row->events->event_location ?? '-');
        }

        $presentation = $prevent;

        $visit = '-';

        if ($row->visit_date && $row->visit_location) {

            $visit =
                "• " . date('d F Y', strtotime($row->visit_date))
                . "\n" .
                "• " . $row->visit_location
                . "\n" .
                "• " . ($row->visit_note ?? '-');
        }

        
        $followupHistory = '-';

        if ($row->followup && $row->followup->count() > 0) {

            $followupHistory = $row->followup
                ->map(function ($f) {

                    $text =
                        '( ' . $f->step . ' ) '
                        . date('d-m-Y H:i', strtotime($f->date))
                        . "\n"
                        . ($f->note ?? '');

                    if ($f->image) {
                        $text .= "\n[IMAGE ATTACHED]";
                    }

                    return $text;
                })
                ->implode("\n\n--------------------\n\n");
        }

        return [
            $no++,
            $row->fullname ?? '-',
            $row->full_address ?? '-',
            $row->school_from ?? '-',
            $row->class . '/' . $row->major,
            $row->phone_number ?? '-',
            $row->email ?? '-',
            $row->gender ?? '-',
            $row->status ?? '-',
            optional($row->consultant)->name ?? '-',
            $lead_source,
            $presentation,
            $visit,
            $followupHistory,
            optional($row->branch)->branch_name ?? '-',
            $row->province_name ?? '',
            $row->regency_name ?? '',
            $row->district_name ?? '',
            $row->village_name ?? '',
            $row->note ?? '',
            optional($row->createdBy)->name ?? '',
            $row->created_at ? date(
                'd M Y H:i',
                strtotime($row->created_at)
            ) : '-'
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
        $reportTitle = $this->isCustomer ? "CUSTOMER DATA REPORT" : "LEAD DATA REPORT";

        return [
            AfterSheet::class => function (AfterSheet $event) use ($company_name, $address, $reportTitle) {
                $sheet = $event->sheet;

                /*
                |--------------------------------------------------------------------------
                | HEADER TITLE
                |--------------------------------------------------------------------------
                */
                $sheet->getStyle('Q:Q')->getAlignment()->setWrapText(true);

                // COMPANY
                $sheet->mergeCells('A1:V1');
                $sheet->setCellValue('A1', $company_name);

                // BRANCH
                $sheet->mergeCells('A2:V2');
                $sheet->setCellValue('A2', $address);

                // REPORT TITLE
                $sheet->mergeCells('A3:V3');
                $sheet->setCellValue('A3', $reportTitle);

                /*
                |--------------------------------------------------------------------------
                | TITLE ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:V3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
                    ->getStyle('A5:V' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | VERTICAL ALIGN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:V' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | TEXT WRAP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:V' . $lastRow)
                    ->getAlignment()

                    ->setWrapText(true);

                $sheet->getStyle('L:L')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_TOP);

                $sheet->getStyle('M:M')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_TOP);


                $sheet->getStyle('N:N')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_TOP);


                for ($row = 6; $row <= $lastRow; $row++) {

                    $maxLines = 1;

                    foreach (['L', 'M', 'N'] as $column) {

                        $value = $sheet->getCell($column . $row)->getValue();

                        $lines = substr_count((string)$value, "\n") + 1;

                        $maxLines = max($maxLines, $lines);
                    }

                    $sheet->getRowDimension($row)
                        ->setRowHeight($maxLines * 15);
                }
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'Q' => 40,
            'L' => 40,
            'M' => 40,
            'N' => 40,
            'T' => 40
        ];
    }
}
