<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Pembayaran</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            font-size: 13px;
            color: #333;
            margin: 30px;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            width: 90px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #0d6efd;
        }

        .company-address {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            text-align: right;
            color: #444;
        }

        .badge {
            display: inline-block;
            background: #198754;
            color: #fff;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 5px;
        }

        .info {
            width: 100%;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .info td {
            vertical-align: top;
            padding: 3px;
        }

        .table-payment {
            width: 100%;
            border-collapse: collapse;
        }

        .table-payment th {
            background: #0d6efd;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table-payment td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            width: 320px;
            float: right;
            margin-top: 20px;
        }

        .summary td {
            padding: 8px;
        }

        .grand-total {
            background: #0d6efd;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            clear: both;
            margin-top: 100px;
        }

        .signature {
            width: 220px;
            text-align: center;
            float: right;
        }

        @media print {

            body {
                margin: 20px;
            }

            @page {
                margin: 15mm;
            }

        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">

        <table>
            <tr>

                <td width="100">

                    <img src="{{ asset('images/logo_trans.png') }}" class="logo">

                </td>

                <td>

                    <div class="company-name">
                        {{$com->company_name ?? ''}}
                    </div>

                    <div class="company-address">
                        {{ $com->address }}<br>
                        Telp : {{ $com->phone_number }}<br>
                        Email : {{ $com->email }}
                    </div>

                </td>

                <td align="right">

                    <div class="invoice-title">
                        INVOICE
                    </div>
                            
                    <div class="badge">
                        {{ $payment->outstanding_payment > 0 ? "CICIL" : "LUNAS" }}
                    </div>

                </td>

            </tr>
        </table>

    </div>

    <table class="info">

        <tr>

            <td width="50%">

                <b>Customer</b><br>

                {{ $payment->fullname }}<br>

                {{ $payment->phone_number }}<br>

                {{ $payment->full_address }}

            </td>

            <td width="50%">

                <table>

                    <tr>
                        <td>No Invoice</td>
                        <td>: <b>{{ $payment->payment_invoice }}</b></td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td>: {{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                    </tr>

                    <tr>
                        <td>Petugas</td>
                        <td>: {{ Auth::user()->name }}</td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>


    <table class="table-payment">

        <thead>

            <tr>

                <th>Keterangan</th>

                <th width="180" class="text-right">Nominal</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>Total Tagihan</td>

                <td class="text-right">

                    Rp {{ number_format($payment->outstanding_amount, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <td>Pembayaran</td>

                <td class="text-right">

                    Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <td>Sisa Tagihan</td>

                <td class="text-right">

                    Rp {{ number_format($payment->outstanding_payment, 0, ',', '.') }}

                </td>

            </tr>

        </tbody>

    </table>


    <table class="summary">

        <tr>

            <td>Total Pembayaran</td>

            <td class="text-right">

                Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}

            </td>

        </tr>

        <tr class="grand-total">

            <td>DITERIMA</td>

            <td class="text-right">

                Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}

            </td>

        </tr>

    </table>

    <div class="footer">

        @if ($payment->keterangan)
            <b>Keterangan :</b>

            {{ $payment->keterangan }}
        @endif

        <div class="signature">

            <br><br><br><br>

            _________________________

            <br>

            <b>Finance</b>

        </div>

    </div>

</body>

</html>
