<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class PresentationUploadSheet implements FromArray, WithTitle, WithEvents
{
    public function array(): array
    {
        return [
            [
                'title',
                'location',
                'date',
                'consultant_id',
                'branch_id',
                'audience',
                'tertarik',
                'sangat_tertarik',
                'kurang_tertarik',
                'description'
            ]
        ];
    }

    public function title(): string
    {
        return 'Presentation Upload';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $consultantCount = User::where('position', 'consultant')->count() + 1;
                $branchCount = Branch::count() + 1;

                for ($row = 2; $row <= 1000; $row++) {

                    // consultant_id (D)
                    $validation = $event->sheet
                        ->getCell("D{$row}")
                        ->getDataValidation();

                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setShowDropDown(true);
                    $validation->setAllowBlank(true);
                    $validation->setFormula1(
                        '=Consultants!$A$2:$A$' . $consultantCount
                    );

                    // branch_id (E)
                    $validation = $event->sheet
                        ->getCell("E{$row}")
                        ->getDataValidation();

                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setShowDropDown(true);
                    $validation->setAllowBlank(true);
                    $validation->setFormula1(
                        '=Branches!$A$2:$A$' . $branchCount
                    );
                }
            }
        ];
    }
}
