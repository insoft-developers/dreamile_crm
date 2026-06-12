<?php

namespace App\Imports;

use App\Models\Presentation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class PresentationImport implements ToModel, WithHeadingRow
{
    /**
     * Jika header ada di baris ke-2.
     */
    public function headingRow(): int
    {
        return 1;
    }

    public function model(array $row)
    {
        if(empty($row['title'])) {
            return null;
        }

        return new Presentation([
            'title'              => $row['title'] ?? null,
            'location'           => $row['location'] ?? null,
            'date'               => $this->parseDate($row['date'] ?? null),
            'consultant_id'      => $this->extractId($row['consultant_id'] ?? null),
            'branch_id'          => $this->extractId($row['branch_id'] ?? null),
            'audience'           => $row['audience'] ?? 0,
            'tertarik'           => $row['tertarik'] ?? 0,
            'sangat_tertarik'    => $row['sangat_tertarik'] ?? 0,
            'kurang_tertarik'    => $row['kurang_tertarik'] ?? 0,
            'description'        => $row['description'] ?? null,
            'userid'             => Auth::user()->id,
        ]);
    }



   
    private function extractId($value)
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return (int) trim(explode('-', $value)[0]);
    }

    /**
     * Parsing tanggal berbagai format.
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {

            /**
             * Jika user memilih date di Excel
             * biasanya berupa serial number.
             */
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }

            $value = trim($value);

            $formats = [
                'Y-m-d',
                'd-m-Y',
                'd/m/Y',
                'm/d/Y',
                'm-d-Y',
                'd.m.Y',
                'Y/m/d',
            ];

            foreach ($formats as $format) {
                try {
                    return Carbon::createFromFormat(
                        $format,
                        $value
                    )->format('Y-m-d');
                } catch (Exception $e) {
                    // lanjut format berikutnya
                }
            }

            /**
             * Fallback:
             * June 12 2026
             * 12 Jun 2026
             * dll
             */
            return Carbon::parse($value)
                ->format('Y-m-d');
        } catch (Exception $e) {

            throw ValidationException::withMessages([
                'date' => "Format tanggal tidak valid: {$value}"
            ]);
        }
    }

    
}
