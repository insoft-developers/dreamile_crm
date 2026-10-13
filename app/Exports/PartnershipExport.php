<?php

namespace App\Exports;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PartnershipExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;

        $data = Partnership::with([
            'partnerType',
            'picDreamile'
        ])->orderBy('id', 'desc');

        // Filter tanggal dibuat
        if ($request->filter_start_date && $request->filter_end_date) {

            $startDate = date(
                'Y-m-d',
                strtotime($request->filter_start_date)
            );

            $endDate = date(
                'Y-m-d',
                strtotime($request->filter_end_date)
            );

            $data->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // Filter jenis partner
        if ($request->filter_jenis_partner) {
            $data->where(
                'partner_type_id',
                $request->filter_jenis_partner
            );
        }

        // Filter PIC Dreamile
        if ($request->filter_pic_dreamile) {
            $data->where(
                'pic_dreamile',
                $request->filter_pic_dreamile
            );
        }

        // Filter provinsi
        if ($request->filter_provinsi) {
            $data->where(
                'province_id',
                $request->filter_provinsi
            );
        }

        // Filter kota
        if ($request->filter_city) {
            $data->where(
                'city_id',
                $request->filter_city
            );
        }

        return $data->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Instance Name',
            'Partnership Type',
            'Province',
            'City',
            'PIC Name',
            'PIC Title',
            'WhatsApp',
            'Email',
            'PIC Dreamile',
            'Partnership Type Name',
            'Expired Date',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,

            $row->created_at
                ? date('d-m-Y', strtotime($row->created_at))
                : '-',

            $row->instance_name,

            $row->partnerType->name ?? '-',

            $row->province_name ?? '-',

            $row->city_name ?? '-',

            $row->pic_name,

            $row->pic_title ?? '-',

            $row->whatsapp ?? '-',

            $row->email ?? '-',

            $row->picDreamile->name ?? '-',

            $row->partnership_type_name ?? '-',

            $row->expired_date
                ? date('d-m-Y', strtotime($row->expired_date))
                : '-',
        ];
    }
}