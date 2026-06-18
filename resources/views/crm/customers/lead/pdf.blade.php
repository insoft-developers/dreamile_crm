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
            LEAD DATA REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>School</th>
                <th>Class/Major</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Status</th>
                <th>Consultant</th>
                <th>Lead Source</th>
                <th>Presentation/Event</th>
                <th>Visit</th>
                <th>Followup</th>
                <th>Branch</th>
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

                    $prevent = '';
                    if ($item->lead_source_id == 'presentation') {
                        $prevent .= '<ul>';
                        if ($item->presentation && $item->presentation->date) {
                            $prevent .= '<li>' . date('d F Y', strtotime($item->presentation?->date)) . '</li>';
                        } else {
                            $prevent .= '';
                        }

                        $audience = $item->presentation?->audience ?? 0;
                        $tr = $item->presentation?->tertarik ?? 0;
                        $st = $item->presentation?->sangat_tertarik ?? 0;
                        $kt = $item->presentation?->kurang_tertarik ?? 0;

                        $prevent .= '<li>' . $item->presentation?->title . '</li>';
                        $prevent .= '<li>' . $item->presentation?->location . '</li>';
                        $prevent .= '<li>' . $audience . '/' . $tr . '/' . $st . '/' . $kt . '</li>';

                        $prevent .= '</ul>';
                    } elseif ($item->lead_source_id == 'event') {
                        $prevent .= '<ul>';
                        if ($item->events && $item->events->event_date) {
                            $prevent .= '<li>' . date('d F Y', strtotime($item->events?->event_date)) . '</li>';
                        } else {
                            $prevent .= '';
                        }

                        $prevent .= '<li>' . $item->events?->event_name . '</li>';
                        $prevent .= '<li>' . $item->events?->event_location . '</li>';

                        $prevent .= '</ul>';
                    } else {
                        $prevent .= '<center>-</center>';
                    }

                    $visite = '';

                    if ($item->visit_date && $item->visit_location) {
                        $visite .= '<ul>';
                        $visite .= '<li>' . date('d F Y', strtotime($item->visit_date)) . '</li>';
                        $visite .= '<li>' . $item->visit_location . '</li>';
                        $visite .= '<li>' . $item->visit_note . '</li>';
                        $visite .= '</ul>';
                    } else {
                        $visite .= '<center>-</center>';
                    }

                    $followup = '';

                    if ($item->followup && $item->followup->count() > 0) {
                        foreach ($item->followup as $f) {
                            $followup .= '<div style="margin-bottom:15px;">';

                            $followup .= '<strong>(' . $f->step . ')</strong> ';
                            $followup .= date('d-m-Y H:i', strtotime($f->date));

                            $followup .= '<br>';
                            $followup .= nl2br($f->note);

                            if ($f->image) {
                                $path = public_path('storage/' . $f->image);

                                if (file_exists($path)) {
                                    $followup .=
                                        '<br><img src="' . $path . '" style="max-width:80px;max-height:80px;">';
                                }
                            }

                            $followup .= '</div>';
                        }
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
                        {{ $address }}
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
                        <?= $prevent ?>
                    </td>
                    <td>
                        <?= $visite ?>
                    </td>
                    <td>
                        <?= $followup ?>
                    </td>


                    <td>
                        {{ optional($item->branch)->branch_name ?? '-' }}
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
