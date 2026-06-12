<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ConsultantSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return User::selectRaw("
                CONCAT(id,' - ',name) as value
            ")
            ->where('position', 'consultant')
            ->get();
    }

    public function headings(): array
    {
         return ['Consultant'];
    }

    public function title(): string
    {
        return 'Consultants';
    }
}
