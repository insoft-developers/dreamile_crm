<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        th {
            background: #198754;
            color: white;
        }

        .header {
            margin-bottom: 15px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
        }

        .note {
            white-space: pre-wrap;
        }

        .image-grid {
            width: 100%;
        }

        .image-grid img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            margin: 2px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="company">{{ $company->company_name }}</div>
        <div>{{ $company->address }}</div>

        <br>

        <div class="title">
            VISIT REPORT
        </div>
    </div>

    <table>

        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Date</th>
                <th width="12%">Customer</th>
                <th width="10%">Consultant</th>
                <th width="12%">Location</th>
                <th width="10%">Branch</th>
                <th width="8%">Status</th>
                <th width="14%">Note</th>
                <th width="12%">Images</th>
                <th width="8%">Created By</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($customers as $key => $row)
                <tr>

                    <td>{{ $key + 1 }}</td>

                    <td>
                        {{ date('d-m-Y H:i:s', strtotime($row->visit_date)) }}
                    </td>

                    <td>
                        {{ $row->fullname }}
                    </td>

                    <td>
                        {{ $row->consultant?->name }}
                    </td>

                    <td>
                        {{ $row->visit_location }}
                    </td>

                    <td>
                        {{ $row->branch?->branch_name }}
                    </td>

                    <td>
                        {{ $row->visit_status }}
                    </td>

                    <td class="note">
                        {{ $row->visit_note }}
                    </td>

                    <td>

                        <table style="border:none;width:100%;">
                            <tr>

                                @foreach ($row->visitImages as $index => $image)
                                    <td style="border:none;padding:2px;">

                                        @if (file_exists(public_path('storage/' . $image->image)))
                                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $image->image))) }}"
                                                style="
        width:80px;
        height:80px;
        object-fit:cover;
    ">
                                        @endif

                                    </td>

                                    @if (($index + 1) % 2 == 0)
                            </tr>
                            <tr>
            @endif
            @endforeach

            </tr>
    </table>

    </td>

    <td>
        {{ $row->createdBy?->name }}
    </td>

    </tr>
    @endforeach

    </tbody>

    </table>

</body>

</html>
