<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .company {
            font-size: 20px;
            font-weight: bold;
        }

        .address {
            font-size: 11px;
            margin-top: 3px;
        }

        .title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #198754;
            color: #fff;
            border: 1px solid #000;
            padding: 7px;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
            background: #f2f2f2;
        }
    </style>

</head>

<body>

    <div class="header">

        <div class="company">
            {{ $company->company_name }}
        </div>

        <div class="address">
            {{ $company->address }}
        </div>

        <div class="title">
            PAYMENT REPORT
        </div>

    </div>

    <table class="info">
        <tr>
            <td width="15%"><b>Tanggal Cetak</b></td>
            <td>: {{ date('d-m-Y H:i') }}</td>
        </tr>

        <tr>
            <td><b>Total Data</b></td>
            <td>: {{ $payments->count() }}</td>
        </tr>
    </table>

    <table>

        <thead>

            <tr>

                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="16%">Invoice</th>
                <th width="20%">Customer</th>
                <th width="12%">Tagihan</th>
                <th width="12%">Bayar</th>
                <th width="12%">Sisa</th>
                <th>Keterangan</th>

            </tr>

        </thead>

        <tbody>

            @php
                $totalTagihan = 0;
                $totalBayar = 0;
                $totalSisa = 0;
            @endphp

            @foreach ($payments as $item)
                @php
                    $totalTagihan += $item->outstanding_amount;
                    $totalBayar += $item->payment_amount;
                    $totalSisa += $item->outstanding_payment;
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="text-center">
                        {{ date('d-m-Y', strtotime($item->payment_date)) }}
                    </td>

                    <td>
                        {{ $item->payment_invoice }}
                    </td>

                    <td>
                        {{ optional($item->customer)->fullname }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->outstanding_amount, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->payment_amount, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->outstanding_payment, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->keterangan }}
                    </td>

                </tr>
            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <td colspan="4" class="text-right">
                    TOTAL
                </td>

                <td class="text-right">
                    {{ number_format($totalTagihan, 0, ',', '.') }}
                </td>

                <td class="text-right">
                    {{ number_format($totalBayar, 0, ',', '.') }}
                </td>

                <td class="text-right">
                    {{ number_format($totalSisa, 0, ',', '.') }}
                </td>

                <td></td>

            </tr>

        </tfoot>

    </table>

    <br><br>

    <table width="100%" style="border:none;">

        <tr style="border:none;">

            <td style="border:none;"></td>

            <td style="border:none; text-align:center;" width="250">

                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

                <br><br><br><br>

                _____________________________

                <br>

                <b>{{ Auth::user()->name }}</b>

            </td>

        </tr>

    </table>

</body>

</html>
