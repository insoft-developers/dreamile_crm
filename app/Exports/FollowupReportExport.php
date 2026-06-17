<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Followup;
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
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class FollowupReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithCustomStartCell, WithColumnWidths, WithDrawings
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
        $data = Followup::query();

        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $data->whereBetween(
                'date',
                [
                    $this->request->filter_start_date . ' 00:00:00',
                    $this->request->filter_end_date . ' 23:59:59'
                ]
            );
        }

        if ($this->request->filter_consultant) {
            $data->whereHas('customer', function ($query) {
                $query->where('consultant_id', $this->request->filter_consultant);
            });
        }

        if ($this->request->filter_branch) {
            $data->whereHas('customer', function ($query) {
                $query->where('branch_id', $this->request->filter_branch);
            });
        }

        if ($this->request->filter_created_by) {
            $data->whereHas('customer', function ($query) {
                $query->where('created_by', $this->request->filter_created_by);
            });
        }


        $data->orderBy('date', 'desc');
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
            "No",
            "Date",
            "customer",
            "Consultant",
            "step",
            "Branch",
            "Note",
            "Image",
            "Created By",

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
            $row->date ? date('d-m-Y H:i:s', strtotime($row->date)) : '',
            $row->customer?->fullname ?? '',
            $row->customer?->consultant?->name ?? '',
            $row->step,
            $row->customer?->branch?->branch_name ?? '',
            $row->note ?? '-',
            '',
            $row->customer?->createdBy?->name ?? ''
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE DATA
    |--------------------------------------------------------------------------
    */


    public function drawings()
    {
        $drawings = [];

        $data = $this->collection();

        foreach ($data as $index => $row) {

            if (!$row->image) {
                continue;
            }

            $path = public_path('storage/' . $row->image);

            if (!file_exists($path)) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('Photo');
            $drawing->setDescription('Photo');
            $drawing->setPath($path);
            $drawing->setHeight(120);

            // Header di row 5, data mulai row 6
            $drawing->setCoordinates('H' . ($index + 6));

            $drawings[] = $drawing;
        }

        return $drawings;
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
        $reportTitle = "FOLLOWUP DATA REPORT";

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
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', $company_name);

                // BRANCH
                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', $address);

                // REPORT TITLE
                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', $reportTitle);

                /*
                |--------------------------------------------------------------------------
                | TITLE ALIGNMENT
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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

                for ($i = 6; $i <= $lastRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(90);
                }

                $sheet
                    ->getStyle('A5:I' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | VERTICAL ALIGN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:I' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | TEXT WRAP
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:I' . $lastRow)
                    ->getAlignment()

                    ->setWrapText(true);


                $sheet->getStyle('G6:G' . $lastRow)
                    ->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(Alignment::VERTICAL_TOP);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'G' => 50,
            'H' => 25
        ];
    }
}
