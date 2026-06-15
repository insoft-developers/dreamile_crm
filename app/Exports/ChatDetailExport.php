<?php

namespace App\Exports;

use App\Models\WhatsappMessage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ChatDetailExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths
{
    protected $request;
    protected $company;
    protected $messages;

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
        $data = WhatsappMessage::with([
            'customer',
            'user'
        ])->where(
            'conversation_id',
            $this->request->filter_id
        );

        if (
            $this->request->filter_start_date &&
            $this->request->filter_end_date
        ) {
            $data->whereBetween('created_at', [
                $this->request->filter_start_date . ' 00:00:00',
                $this->request->filter_end_date . ' 23:59:59'
            ]);
        }

        $this->messages = $data
            ->orderBy('id', 'asc')
            ->get();

        return $this->messages;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE HEADER
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'No',
            'Date Time',
            'Sender',
            'Conversation',
            'Status',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | DATA MAPPING
    |--------------------------------------------------------------------------
    */

    public function map($row): array
    {
        static $no = 1;

        $sender = $row->sender == 'customer'
            ? ($row->customer?->fullname ?? 'Customer')
            : (($row->user?->name ?? '-') . ' (Agent)');

        if ($row->type == 'image') {

            $message = '[IMAGE]';

            if ($row->message) {
                $message .= "\n" . $row->message;
            }
        } elseif ($row->type == 'file') {

            $message = '[FILE] ' . ($row->file_name ?? '');

            if ($row->message) {
                $message .= "\n" . $row->message;
            }
        } else {

            $message = $row->message ?? '';
        }

        return [
            $no++,
            date('d-m-Y H:i', strtotime($row->created_at)),
            $sender,
            $message,
            strtoupper($row->status ?? '-')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | COLUMN WIDTH
    |--------------------------------------------------------------------------
    */

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 30,
            'D' => 120,
            'E' => 15,
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

            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
            ],

            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
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

    /*
    |--------------------------------------------------------------------------
    | AFTER SHEET
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        $company_name = $this->company->company_name;
        $address = $this->company->address;
        $reportTitle = "CHAT HISTORY DETAIL REPORT";

        return [
            AfterSheet::class => function (AfterSheet $event) use (
                $company_name,
                $address,
                $reportTitle
            ) {

                $sheet = $event->sheet;

                /*
                |--------------------------------------------------------------------------
                | TITLE
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', $company_name);

                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', $address);

                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A3', $reportTitle);

                $sheet->getStyle('A1:E3')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    );

                /*
                |--------------------------------------------------------------------------
                | ROW HEIGHT
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(22);

                $lastRow = $sheet->getHighestRow();


                $rowExcel = 6;

                foreach ($this->messages as $message) {

                    if (
                        $message->type == 'image'
                        && !empty($message->attachment)
                    ) {

                        $imagePath = storage_path(
                            'app/public/' . $message->attachment
                        );

                        if (file_exists($imagePath)) {

                            $drawing = new Drawing();

                            $drawing->setName('Chat Image');
                            $drawing->setDescription('Chat Image');
                            $drawing->setPath($imagePath);

                            $drawing->setHeight(120);

                            $drawing->setCoordinates(
                                'D' . $rowExcel
                            );

                            $drawing->setWorksheet(
                                $sheet->getDelegate()
                            );

                            $sheet->getRowDimension(
                                $rowExcel
                            )->setRowHeight(100);
                        }
                    }

                    if ($message->type == 'file') {

                        $sheet->setCellValue(
                            'D' . $rowExcel,
                            '[FILE] ' . ($message->file_name ?? '-')
                        );
                    }

                    $rowExcel++;
                }

                /*
                |--------------------------------------------------------------------------
                | BORDER
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:E' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                |--------------------------------------------------------------------------
                | WRAP TEXT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:E' . $lastRow)
                    ->getAlignment()
                    ->setWrapText(true);

                $sheet
                    ->getStyle('A5:E' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                /*
                |--------------------------------------------------------------------------
                | CHAT COLORING
                |--------------------------------------------------------------------------
                */

                for ($i = 6; $i <= $lastRow; $i++) {

                    $sender = $sheet
                        ->getCell('C' . $i)
                        ->getValue();

                    if (str_contains($sender, '(Agent)')) {

                        $sheet
                            ->getStyle('D' . $i)
                            ->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => [
                                        'rgb' => 'DCF8C6',
                                    ],
                                ],
                            ]);
                    } else {

                        $sheet
                            ->getStyle('D' . $i)
                            ->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => [
                                        'rgb' => 'F8F9FA',
                                    ],
                                ],
                            ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | ALIGN CHAT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('D6:D' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    );

                $sheet
                    ->getStyle('D6:D' . $lastRow)
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_TOP
                    );

                /*
                |--------------------------------------------------------------------------
                | FILTER
                |--------------------------------------------------------------------------
                */

                for ($i = 6; $i <= $lastRow; $i++) {

                    $sheet->getStyle('D' . $i)
                        ->getAlignment()
                        ->setWrapText(true);

                    $sheet->getStyle('D' . $i)
                        ->getAlignment()
                        ->setVertical(
                            Alignment::VERTICAL_TOP
                        );
                }

                $sheet->setAutoFilter('A5:E5');
            },
        ];
    }
}
