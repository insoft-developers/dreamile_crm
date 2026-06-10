 <div wire:poll.5s>
     <div class="table-box table-responsive">
         <table class="table table-hover text-nowrap">
             <thead class="table-light border-0">
                 <tr>
                     <th>Title</th>
                     <th>Location</th>
                     <th>Branch</th>
                     <th>Date</th>
                     <th>Audience</th>
                     <th>TR</th>
                     <th>ST</th>
                     <th>KT</th>
                     <th>Leads</th>
                     <th>Deal</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($data as $key)
                     <tr>
                         <td>{{ $key->title }}</td>
                         <td>{{ $key->location }}</td>
                         <td>{{ optional($key->branch)->branch_name ?? '' }}</td>
                         <td>{{ $key->date }}</td>
                         <td>{{ $key->audience ?? 0 }}</td>
                         <td>{{ $key->tertarik ?? 0 }}</td>
                         <td>{{ $key->sangat_tertarik ?? 0 }}</td>
                         <td>{{ $key->kurang_tertarik ?? 0 }}</td>
                         <td>{{ optional($key->leads)->count() ?? 0 }}</td>
                         <td>{{ optional($key->deals)->count() ?? 0 }}</td>
                         
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
