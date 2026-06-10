 <div wire:poll.5s>
     <div class="table-box table-responsive">
         <table class="table table-hover text-nowrap">
             <thead class="table-light border-0">
                 <tr>
                     <th>Branch Name</th>
                     <th>New</th>
                     <th>Visit</th>
                     <th>Deal</th>
                     <th>NOK</th>
                     <th>Confirm</th>
                     <th>Conversion</th>
                     
             </thead>
             <tbody>
                 @foreach ($branches as $key)
                     <tr>
                         <td>{{ $key->branch_name }}</td>
                         <td>{{ $key->new_count }}</td>
                         <td>{{ $key->visit_count }}</td>
                         <td>{{ $key->confirm_count }}</td>
                         <td>{{ $key->deal_count }}</td>
                         <td>{{$key->nok_count }}</td>
                          <td>{{$key->nok_count }}</td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
