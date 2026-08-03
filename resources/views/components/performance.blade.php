<div wire:poll.60s>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0">

            <thead>
                <tr>
                   <th>No</th>
                   <th>Consultant Name</th>
                   <th>Branch</th>
                   <th>Visit/Leads</th>
                   <th>NOKs</th>
                   <th>Deals</th>
                   <th>Confirm</th>
                   <th>Omset</th>

                </tr>
            </thead>

            <tbody>
               
                  @foreach($data as $index => $key)  
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $key->name }}</td>
                        <td>{{ $key->branch_name ?? '' }}</td>
                        <td>{{ number_format($key->total_visit) }}</td>
                        <td>{{ number_format($key->total_nok) }}</td>
                        <td>{{ number_format($key->total_deal) }}</td>
                        <td>{{ number_format($key->total_confirm) }}</td>
                        <td>{{ number_format($key->total_payment) }}</td>
                    </tr>
                  @endforeach

            </tbody>

        </table>
    </div>
</div>

