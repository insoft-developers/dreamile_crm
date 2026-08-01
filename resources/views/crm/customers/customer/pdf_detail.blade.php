<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: sans-serif;
            font-size:11px;
        }

        h3{
            margin-top:20px;
            margin-bottom:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table td{
            border:1px solid #000;
            padding:5px;
            vertical-align:top;
        }

        .text-center{
            text-align:center;
        }

        .photo{
            max-width:200px;
            max-height:200px;
            border:1px solid #ccc;
            padding:3px;
            margin:5px;
        }

    </style>

</head>

<body>

    <div class="text-center">
        <h2>{{ $company->company_name }}</h2>
        <p>{{ $company->address }}</p>
        <h3>STUDENT DETAIL REPORT</h3>
    </div>

    {{-- FOTO PROFIL LEAD --}}

    @if($data->image)

        @php
            $profilePhoto = public_path('storage/'.$data->image);
        @endphp

        @if(file_exists($profilePhoto))

            <div class="text-center">
                <img src="{{ $profilePhoto }}" class="photo">
            </div>

        @endif

    @endif


    {{-- INFORMASI LEAD --}}

    <h3>Lead Information</h3>

    <table>

        <tr>
            <td width="30%"><b>Full Name</b></td>
            <td>{{ $data->fullname }}</td>
        </tr>

        <tr>
            <td><b>Phone</b></td>
            <td>{{ $data->phone_number }}</td>
        </tr>

        <tr>
            <td><b>Email</b></td>
            <td>{{ $data->email }}</td>
        </tr>

        <tr>
            <td><b>Gender</b></td>
            <td>{{ $data->gender }}</td>
        </tr>

        <tr>
            <td><b>School</b></td>
            <td>{{ $data->school_from }}</td>
        </tr>

        <tr>
            <td><b>Class / Major</b></td>
            <td>{{ $data->class }} / {{ $data->major }}</td>
        </tr>

        <tr>
            <td><b>Status</b></td>
            <td>{{ $data->status }}</td>
        </tr>

        <tr>
            <td><b>Consultant</b></td>
            <td>{{ $data->consultant?->name }}</td>
        </tr>

        <tr>
            <td><b>Branch</b></td>
            <td>{{ $data->branch?->branch_name }}</td>
        </tr>

        <tr>
            <td><b>Created By</b></td>
            <td>{{ $data->createdBy?->name }}</td>
        </tr>

    </table>


    {{-- WILAYAH --}}

    <h3>Area Information</h3>

    <table>

        <tr>
            <td width="30%"><b>Province</b></td>
            <td>{{ $data->province_name }}</td>
        </tr>

        <tr>
            <td><b>Regency</b></td>
            <td>{{ $data->regency_name }}</td>
        </tr>

        <tr>
            <td><b>District</b></td>
            <td>{{ $data->district_name }}</td>
        </tr>

        <tr>
            <td><b>Village</b></td>
            <td>{{ $data->village_name }}</td>
        </tr>

        <tr>
            <td><b>Address</b></td>
            <td>{{ $data->full_address }}</td>
        </tr>

    </table>


    {{-- PRESENTATION --}}

    @if($data->presentation)

        <h3>Presentation Information</h3>

        <table>

            <tr>
                <td width="30%">Date</td>
                <td>{{ date('d F Y', strtotime($data->presentation->date)) }}</td>
            </tr>

            <tr>
                <td>Title</td>
                <td>{{ $data->presentation->title }}</td>
            </tr>

            <tr>
                <td>Location</td>
                <td>{{ $data->presentation->location }}</td>
            </tr>

            <tr>
                <td>Audience</td>
                <td>{{ $data->presentation->audience }}</td>
            </tr>

            <tr>
                <td>Interested</td>
                <td>{{ $data->presentation->tertarik }}</td>
            </tr>

            <tr>
                <td>Very Interested</td>
                <td>{{ $data->presentation->sangat_tertarik }}</td>
            </tr>

            <tr>
                <td>Less Interested</td>
                <td>{{ $data->presentation->kurang_tertarik }}</td>
            </tr>

        </table>

    @endif


    {{-- EVENT --}}

    @if($data->events)

        <h3>Event Information</h3>

        <table>

            <tr>
                <td width="30%">Event Date</td>
                <td>{{ date('d F Y', strtotime($data->events->event_date)) }}</td>
            </tr>

            <tr>
                <td>Event Name</td>
                <td>{{ $data->events->event_name }}</td>
            </tr>

            <tr>
                <td>Location</td>
                <td>{{ $data->events->event_location }}</td>
            </tr>

        </table>

    @endif


    {{-- VISIT --}}

    @if($data->visit_date)

        <h3>Visit Information</h3>

        <table>

            <tr>
                <td width="30%">Visit Date</td>
                <td>{{ $data->visit_date }}</td>
            </tr>

            <tr>
                <td>Location</td>
                <td>{{ $data->visit_location }}</td>
            </tr>

            <tr>
                <td>Note</td>
                <td>{{ $data->visit_note }}</td>
            </tr>

        </table>

    @endif


    {{-- FOTO VISIT --}}

    @if($data->visitImages && $data->visitImages->count())

        <h3>Visit Photos</h3>

        @foreach($data->visitImages as $photo)

            @php
                $visitImage = public_path('storage/'.$photo->image);
            @endphp

            @if(file_exists($visitImage))
                <img src="{{ $visitImage }}" class="photo">
            @endif

        @endforeach

    @endif


    {{-- FOLLOWUP --}}

    <h3>Followup History</h3>

    @forelse($data->followup as $f)

        <table style="margin-bottom:15px;">

            <tr>
                <td width="25%">
                    Step {{ $f->step }}
                </td>

                <td>
                    {{ date('d F Y H:i', strtotime($f->date)) }}
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    {!! nl2br(e($f->note)) !!}
                </td>
            </tr>

            @if($f->image)

                @php
                    $followupImage = public_path('storage/'.$f->image);
                @endphp

                @if(file_exists($followupImage))

                    <tr>
                        <td colspan="2">

                            <img src="{{ $followupImage }}"
                                 class="photo">

                        </td>
                    </tr>

                @endif

            @endif

        </table>

    @empty

        <p>No followup history.</p>

    @endforelse

</body>

</html>