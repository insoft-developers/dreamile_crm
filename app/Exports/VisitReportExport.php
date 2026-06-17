<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths,
    WithDrawings
{


    protected $request;
    protected $company;

    public function __construct($request, $company)
    {
        $this->request = $request;
        $this->company = $company;
    }


    public function startCell(): string
    {
        return 'A5';
    }


    public function headings(): array
    {
        return [
            'No',
            'Date',
            'Customer',
            'Consultant',
            'Location',
            'Branch',
            'Status',
            'Note',
            'Images',
            'Created By',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
            ],

            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 13,
                ],
            ],

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

    public function drawings()
    {
        $drawings = [];

        $customers = $this->collection();

        foreach ($customers as $index => $customer) {

            $excelRow = $index + 6;

            foreach ($customer->visitImages as $key => $image) {

                $path = public_path('storage/' . $image->image);

                if (!file_exists($path)) {
                    continue;
                }

                $drawing = new Drawing();

                $drawing->setName('Visit Image');
                $drawing->setDescription('Visit Image');
                $drawing->setPath($path);

                $drawing->setHeight(80);

                $drawing->setCoordinates('I' . $excelRow);

                $drawing->setOffsetY($key * 85);

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        $company_name = $this->company->company_name;
        $address = $this->company->address;
        $reportTitle = "VISIT REPORT";

        return [
            AfterSheet::class => function (AfterSheet $event) use (
                $company_name,
                $address,
                $reportTitle
            ) {

                $sheet = $event->sheet;

                $sheet->mergeCells('A1:J1');
                $sheet->setCellValue('A1', $company_name);

                $sheet->mergeCells('A2:J2');
                $sheet->setCellValue('A2', $address);

                $sheet->mergeCells('A3:J3');
                $sheet->setCellValue('A3', $reportTitle);

                $sheet->getStyle('A1:J3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(22);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle('A5:J' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle('A5:J' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // wrap note
                $sheet->getStyle('H6:H' . $lastRow)
                    ->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(Alignment::VERTICAL_TOP);

                $customers = $this->collection();

                foreach ($customers as $index => $customer) {

                    $row = $index + 6;

                    $imageCount = max(
                        $customer->visitImages->count(),
                        1
                    );

                    $sheet->getRowDimension($row)
                        ->setRowHeight(max(80, $imageCount * 65));
                }
            }
        ];
    }

    public function collection()
    {
       
        $data = Customer::with([
            'consultant',
            'branch',
            'createdBy',
            'visitImages'
        ])->whereNotNull('visit_date')->whereNotNull('visit_location');

        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $data->whereBetween(
                'visit_date',
                [
                    $this->request->filter_start_date . ' 00:00:00',
                    $this->request->filter_end_date . ' 23:59:59'
                ]
            );
        }


        if (Auth::user()->branch_id) {
            $data->where('branch_id', Auth::user()->branch_id);
        }

        if ($this->request->filter_consultant) {
            $data->where('consultant_id', $this->request->filter_consultant);
        }

        if ($this->request->filter_branch) {
            $data->where('branch_id', $this->request->filter_branch);
        }

        if ($this->request->filter_status) {
            $data->where('visit_status', $this->request->filter_status);
        }

        if ($this->request->filter_created_by) {
            $data->where('created_by', $this->request->filter_created_by);
        }

        return $data->get();
    }


    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            date('d-m-Y H:i:s', strtotime($row->visit_date)),
            $row->fullname,
            $row->consultant?->name,
            $row->visit_location,
            $row->branch?->branch_name,
            $row->visit_status,
            $row->visit_note,
            '',
            $row->createdBy?->name,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'E' => 35,
            'H' => 50,
            'I' => 25,
        ];
    }
}
