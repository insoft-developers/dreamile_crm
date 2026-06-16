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
            BROADCAST DETAIL REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Broadcast Name</th>
                <th>Contact Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Note</th>
                <th>Created At</th>

            </tr>
        </thead>

        <tbody>

            @foreach ($data as $item)
                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->broadcasts?->name ?? '' }}
                    </td>

                    <td>
                        {{ $item->customer?->fullname ?? '' }}
                    </td>

                    <td>
                        {{ $item->phone ?? '-' }}
                    </td>

                    <td>
                        {{ $item->status ?? '-' }}
                    </td>

                    <td style="width: 100px;">
                        <div style="white-space: normal;">{{ $item->error ?? '0' }}</div>
                    </td>
                  
                    <td>
                        {{ date('d-m-Y', strtotime($item->created_at)) }}
                    </td>



                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>
