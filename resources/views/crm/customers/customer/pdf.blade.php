<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        .title {
            text-align: center;
            margin-bottom: 10px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
        }

        .address {
            font-size: 11px;
        }

        .report-title {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #198754;
            color: white;
            font-size: 10px;
            padding: 6px;
            border: 1px solid #000;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .note {
            width: 180px;
            word-break: break-word;
        }
    </style>

</head>

<body>

    <div class="title">
        <div class="company">
            {{ $company->company_name ?? '' }}
        </div>

        <div class="address">
            {{ $company->address ?? '' }}
        </div>

        <div class="report-title">
            CUSTOMER DATA REPORT
        </div>
    </div>

   <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>P/D of Birth</th>
                <th>Address</th>
                <th>School</th>
                <th>Class/Major</th>
                <th>Phone</th>
                <th>Ayah</th>
                <th>Ibu</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Consultant</th>
                <th>Lead Source</th>
                <th>Branch</th>
                <th>Reg Cost</th>
                <th>Payment</th>
                <th>Outstand</th>
                <th>Province</th>
                <th>Regency</th>
                <th>District</th>
                <th>Village</th>
                <th class="note">Note</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($customers as $item)
                @php

                    if ($item->lead_source_id == 'event') {
                        $lead_source = 'Event';
                    } elseif ($item->lead_source_id == 'presentation') {
                        $lead_source = 'Presentation';
                    } else {
                        $lead_source = optional($item->leadsource)->source_name ?? '-';
                    }

                   
                
                    $rt = $item->rt ?? '';
                    $rw = $item->rw ?? '';
                    $address = $item->full_address.' RT '.$rt.'/ RW '.$item->rw;

                @endphp

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->fullname ?? '-' }}
                    </td>
                    <td>
                        {{ $item->tempat_lahir && $item->tanggal_lahir ? $item->tempat_lahir.', '. date('d-m-Y', strtotime($item->tanggal_lahir)) : '' }}
                    </td>

                    <td style="white-space: normal;width:180px;">
                        {{ $address }} - {{ $item->kode_pos }}
                    </td>

                    <td>
                        {{ $item->school_from ?? '-' }}
                    </td>

                    <td>
                        {{ $item->class }}/{{ $item->major }}
                    </td>

                    <td>
                        {{ $item->phone_number ?? '-' }}
                    </td>
                    <td>
                        {{ $item->nama_ayah ?? '-' }}
                    </td>
                    <td>
                        {{ $item->nama_ibu ?? '-' }}
                    </td>

                    <td>
                        {{ $item->email ?? '-' }}
                    </td>

                    <td>
                        {{ $item->gender ?? '-' }}
                    </td>

                    <td>
                        {{ $item->status ?? '-' }}
                    </td>

                    <td>
                        {{ optional($item->consultant)->name ?? '-' }}
                    </td>

                    <td>
                        {{ $lead_source }}
                    </td>
                    

                    <td>
                        {{ optional($item->branch)->branch_name ?? '-' }}
                    </td>
                    <td>
                        {{ $item->register_cost ? number_format($item->register_cost) : '-' }}
                    </td>
                    <td>
                        {{ $item->payment ? number_format($item->payment) : '-' }}
                    </td>
                    <td>
                        {{ $item->out_payment ? number_format($item->out_payment) : '-' }}
                    </td>

                    <td>
                        {{ $item->province_name ?? '' }}
                    </td>

                    <td>
                        {{ $item->regency_name ?? '' }}
                    </td>

                    <td>
                        {{ $item->district_name ?? '' }}
                    </td>

                    <td>
                        {{ $item->village_name ?? '' }}
                    </td>

                    <td class="note">
                        {{ $item->note ?? '' }}
                    </td>

                    <td>
                        {{ optional($item->createdBy)->name ?? '' }}
                    </td>

                    <td>
                        {{ date('d M Y H:i', strtotime($item->created_at)) }}
                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>