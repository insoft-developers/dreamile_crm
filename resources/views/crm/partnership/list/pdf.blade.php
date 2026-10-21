<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Partnership List</title>

    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #222;
        }

        h2 {
            text-align: center;
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 15px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        table th,
        table td {
            border: 1px solid #777;
            padding: 4px;
        }

        table td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nowrap {
            white-space: nowrap;
        }

        .footer {
            margin-top: 10px;
            font-size: 7px;
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>PARTNERSHIP LIST</h2>

    <div class="subtitle">
        Daftar Partnership
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Tanggal</th>
                <th>Instance Name</th>
                <th>Partnership Type</th>
                <th>Province</th>
                <th>City</th>
                <th>PIC Name</th>
                <th>PIC Title</th>
                <th>WhatsApp</th>
                <th>Email</th>
                <th>PIC Dreamile</th>
                <th>Partnership Type Name</th>
                <th>Start Date</th>
                <th>Expired Date</th>
            </tr>
        </thead>

        <tbody>

            @forelse($partnerships as $index => $row)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="nowrap">
                        {{ $row->created_at
                            ? date('d-m-Y', strtotime($row->created_at))
                            : '-' }}
                    </td>

                    <td>
                        {{ $row->instance_name }}
                    </td>

                    <td>
                        {{ $row->partnerType->name ?? '-' }}
                    </td>

                    <td>
                        {{ $row->province_name ?? '-' }}
                    </td>

                    <td>
                        {{ $row->city_name ?? '-' }}
                    </td>

                    <td>
                        {{ $row->pic_name }}
                    </td>

                    <td>
                        {{ $row->pic_title ?? '-' }}
                    </td>

                    <td>
                        {{ $row->whatsapp ?? '-' }}
                    </td>

                    <td>
                        {{ $row->email ?? '-' }}
                    </td>

                    <td>
                        {{ $row->picDreamile->name ?? '-' }}
                    </td>

                    <td>
                        {{ $row->partnership_type_name ?? '-' }}
                    </td>

                    <td class="nowrap">
                        {{ $row->start_date
                            ? date('d-m-Y', strtotime($row->start_date))
                            : '-' }}
                    </td>
                    <td class="nowrap">
                        {{ $row->expired_date
                            ? date('d-m-Y', strtotime($row->expired_date))
                            : '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="13" class="text-center">
                        Tidak ada data partnership.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ date('d-m-Y H:i') }}
    </div>

</body>
</html>