<div wire:poll.2s>
    <table class="table table-stripped">
        <tr>
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Branch</th>
            </thead>
            <tbody>
                @foreach ($users as $nomor => $user)
                    <tr>
                        <td>{{ $nomor + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->isOnline())
                                <span class="text-success">

                                    <i class="bi bi-circle-fill fs-10"></i>

                                    <strong>Online</strong>

                                </span>
                            @else
                                <span class="text-secondary">

                                    <i class="bi bi-circle-fill fs-10"></i>

                                    Offline

                                </span>
                            @endif
                        </td>
                        <td>{{ $user->branch?->branch_name ?? 'All branch' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </tr>
    </table>
</div>
