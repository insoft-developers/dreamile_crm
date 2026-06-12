<?php

namespace App\Exports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BranchSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Branch::selectRaw("
        CONCAT(id,' - ',branch_name) as value
    ")->get();
    }

    public function headings(): array
    {
        return ['Branch'];
    }

    public function title(): string
    {
        return 'Branches';
    }
}
