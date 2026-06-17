<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-size: 11px;
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background: #198754;
            color: white;
        }

        .photo {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body>

    <h2>{{ $company->company_name }}</h2>
    <p>{{ $company->address }}</p>

    <h3>FOLLOWUP DATA REPORT</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Consultant</th>
                <th>Step</th>
                <th>Branch</th>
                <th>Note</th>
                <th>Image</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $row)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($row->date)) }}</td>
                    <td>{{ $row->customer?->fullname }}</td>
                    <td>{{ $row->customer?->consultant?->name }}</td>
                    <td>{{ $row->step }}</td>
                    <td>{{ $row->customer?->branch?->branch_name }}</td>
                    <td>{{ $row->note }}</td>
                    <td>
                        @if ($row->image)
                            <img class="photo" src="{{ public_path('storage/' . $row->image) }}">
                        @endif
                    </td>
                    <td>{{ $row->customer?->createdBy?->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
