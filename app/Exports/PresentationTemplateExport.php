<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PresentationTemplateExport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
        return [
            new PresentationUploadSheet(),
            new ConsultantSheet(),
            new BranchSheet(),
        ];
    }
}
