 <div wire:poll.5s>
     <div class="table-box table-responsive">
         <table class="table table-hover text-nowrap">
             <thead class="table-light border-0">
                 <tr>
                     <th>Event</th>
                     <th>Location</th>
                     <th>Branch</th>
                     <th>Date</th>
                     <th>Leads</th>
                     <th>Deal</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($data as $key)
                     <tr>
                         <td>{{ $key->event_name }}</td>
                         <td>{{ $key->event_location }}</td>
                         <td>{{ optional($key->branch)->branch_name ?? '' }}</td>
                         <td>{{ date('d-m-Y', strtotime($key->event_date)) }}</td>
                         <td>{{ optional($key->leads)->count() ?? 0 }}</td>
                         <td>{{ optional($key->deals)->count() ?? 0 }}</td>
                         
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
