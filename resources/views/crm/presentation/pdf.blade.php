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
            PRESENTATION DATA REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Location</th>
                <th>Date</th>
                <th>Consultant</th>
                <th>Audience</th>
                <th>Tertarik</th>
                <th>Sangat Tertarik</th>
                <th>Kurang Tertarik</th>
                <th>Leads</th>
                <th>Deals</th>
                <th class="note">Description</th>
                <th>Branch</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>

            @foreach($customers as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->title ?? '-' }}
                </td>

                <td>
                    {{ $item->location ?? '-' }}
                </td>

                <td>
                    {{ $item->date ?? '-' }}
                </td>

                <td>
                    {{ optional($item->consultant)->name ?? '' }}
                </td>

                <td>
                    {{ $item->audience ?? '-' }}
                </td>

                <td>
                    {{ $item->tertarik ?? '-' }}
                </td>

                <td>
                    {{ $item->sangat_tertarik ?? '-' }}
                </td>

                <td>
                    {{ $item->kurang_tertarik ?? '-' }}
                </td>

                <td>
                    {{ optional($item->leads)->count() ?? '-' }}
                </td>

                <td>
                    {{ optional($item->deals)->count() ?? '-' }}
                </td>
                 <td class="note">
                    {{ $item->note ?? '' }}
                </td>

                <td>
                    {{ optional($item->branch)->branch_name ?? '-' }}
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