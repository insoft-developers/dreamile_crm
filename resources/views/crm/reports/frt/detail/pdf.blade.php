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
            FIRST RESPONSE DETAIL REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Consultant Name</th>
                <th>Branch</th>
                <th>Chat Masuk</th>
                <th>Dibalas</th>
                <th>First Response Time</th>
                
                
               
            </tr>
        </thead>

        <tbody>

            @foreach($data as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->fullname ?? '-' }}
                </td>
                <td>
                    {{ $item->agent_name ?? '-' }}
                </td>

                <td>
                    {{ $item->branch_name ?? 'All Branch' }}
                </td>

                

               <td>
                    {{ $item->first_customer_message ? $item->first_customer_message : '-' }}
                </td>

               <td>
                    {{ $item->first_agent_message ? $item->first_agent_message : '-' }}
                </td>
                <td>
                    {{ $item->frt_seconds ? formatDuration($item->frt_seconds) : 0 }}
                </td>
               

            </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>