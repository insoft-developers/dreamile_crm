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
            CHAT HISTORY REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Consultant</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Last Message</th>
                <th>Assign At</th>
                
               
            </tr>
        </thead>

        <tbody>
            {{-- $row->created_at,
            $row->customer?->fullname ?? '',
            $row->phone ?? '',
            $row->agent?->name ??'',
            $row->agent?->branch?->branch_name ?? '',
            $row->status ?? '',
            $row->last_message_at,
            $row->assign_at --}}

            @foreach($data as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->created_at ?? '-' }}
                </td>

                <td>
                    {{ $item->customer?->fullname ?? '' }}
                </td>

                <td>
                    {{ $item->phone ?? '' }}
                </td>
                <td>
                    {{ $item->agent?->name ?? '' }}
                </td>

                <td>
                    {{ $item->agent?->branch?->branch_name ?? '' }}
                </td>

               <td>
                    {{ $item->status }}
                </td>

               <td>
                    {{ $item->last_message_at ?? '' }}
                </td>
               

                <td>
                    {{ $item->assign_at ?? '' }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>