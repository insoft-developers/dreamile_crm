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
            BROADCAST REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Broadcast Name</th>
                <th>Message</th>
                <th>Template</th>
                <th>Total</th>
                <th>Sent</th>
                <th>Failed</th>
                <th>% Sent</th>
                <th>% Failed</th>
                <th>Status</th>
                <th>Branch</th>
                <th>Created By</th>
               
            </tr>
        </thead>

        <tbody>

            @foreach($data as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ date('d-m-Y', strtotime($item->created_at)) }}
                </td>

                <td>
                    {{ $item->name }}
                </td>

                <td>
                    {{ $item->message ?? '-' }}
                </td>

                <td>
                    {{ $item->template_name ?? '-' }}
                </td>

               <td>
                    {{ $item->total ?? '0' }}
                </td>
                <td>
                    {{ $item->sent ?? '0' }}
                </td>
                <td>
                    {{ $item->failed ?? '0' }}
                </td>
                <td>
                    {{ number_format($item->sent/$item->total*100) }}
                </td>
                <td>
                    {{ number_format($item->failed/$item->total*100) }}
                </td>
                <td>
                    {{ $item->status }}
                </td>
                <td>
                    {{ $item->branch?->branch_name ?? '' }}
                </td>
                <td>
                    {{ $item->user?->name ?? '' }}
                </td>
                
               

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>