<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
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

class PaymentExport implements
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
            'Tanggal',
            'No Invoice',
            'Customer',
            'Total Tagihan',
            'Pembayaran',
            'Sisa Tagihan',
            'Keterangan',
            'Petugas',
        ];
    }

    public function collection()
    {
        $data = Payment::with([
            'customer',
            'createdBy'
        ]);

        if ($this->request->filter_start_date && $this->request->filter_end_date) {
            $data->whereBetween('payment_date', [
                $this->request->filter_start_date,
                $this->request->filter_end_date
            ]);
        }

        if ($this->request->filter_customer) {
            $data->where('customer_id', $this->request->filter_customer);
        }

        return $data->latest('payment_date')->get();
    }

    public function map($row): array
    {
        static $no = 1;

        return [
            $no++,
            date('d-m-Y', strtotime($row->payment_date)),
            $row->payment_invoice,
            $row->customer?->fullname,
            $row->outstanding_amount,
            $row->payment_amount,
            $row->outstanding_payment,
            $row->keterangan,
            $row->createdBy?->name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ]
            ],

            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 11
                ]
            ],

            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 13
                ]
            ],

            5 => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '198754'
                    ]
                ]
            ]
        ];
    }

    public function registerEvents(): array
    {
        $company_name = $this->company->company_name;
        $address = $this->company->address;
        $reportTitle = 'PAYMENT REPORT';

        return [

            AfterSheet::class => function (AfterSheet $event) use ($company_name, $address, $reportTitle) {

                $sheet = $event->sheet;

                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', $company_name);

                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', $address);

                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', $reportTitle);

                $sheet->getStyle('A1:I3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(5)->setRowHeight(22);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle('A5:I' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle('A5:I' . $lastRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('H6:H' . $lastRow)
                    ->getAlignment()
                    ->setWrapText(true);

                // Format Rupiah
                $sheet->getStyle('E6:G' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');
            }

        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 15,
            'C' => 25,
            'D' => 30,
            'E' => 18,
            'F' => 18,
            'G' => 18,
            'H' => 40,
            'I' => 20,
        ];
    }
}