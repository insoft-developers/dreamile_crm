 <div wire:poll.2s>
     <div class="table-box table-responsive">
         <table class="table table-hover text-nowrap">
             <thead class="table-light border-0">
                 <tr>
                     <th>Customer</th>
                     <th>Last Message</th>
                     <th>Unread</th>
                     <th>Status</th>
                     <th>Branch</th>
                     <th>Time</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($recents as $recent)
                     <tr>
                         <td>
                             <div class="form-check">
                                 @if ($recent->customer->photo)
                                     <img src="{{ asset('storage') }}/{{ $recent->customer->photo }}"
                                         class="avatar-sm rounded-2 mx-2" alt="Avatar Image">
                                 @endif
                                 {{ $recent->customer?->fullname ?? '' }}
                             </div>
                         </td>
                         <td>{{ optional($recent->latestMessage)->message }}</td>
                         <td>{{ $recent->unread_count }}</td>
                         <td>
                             @if ($recent->status == 'resolved')
                                 <span
                                     class="badge bg-success-subtle text-success py-1 rounded-3 border border-success">Resolved</span>
                             @else
                                 @if (empty($recent->assigned_to))
                                     <span
                                         class="badge bg-danger-subtle text-danger py-1 rounded-3 border border-danger">Unassigned</span>
                                 @else
                                     <span
                                         class="badge bg-warning-subtle text-warning py-1 rounded-3 border border-warning">Assigned</span>
                                 @endif
                             @endif
                         </td>
                         <td>{{ $recent->customer?->branch?->branch_name ?? '' }}</td>
                         <td>
                             {{ date('d-m-Y H:i', strtotime($recent->last_message_at)) }}
                         </td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
