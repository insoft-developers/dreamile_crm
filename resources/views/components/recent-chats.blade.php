<div wire:poll.2s>
    <div class="table-responsive">
        <table class="table recent-chat-table align-middle mb-0">
            <thead>
                <tr>
                    <th width="280">Customer</th>
                    <th>Last Message</th>
                    <th width="100" class="text-center">Unread</th>
                    <th width="130">Status</th>
                    <th width="150">Branch</th>
                    <th width="140">Time</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($recents as $recent)
                    <tr>

                        {{-- CUSTOMER --}}
                        <td>
                            <div class="d-flex align-items-center">

                                @if ($recent->customer?->photo)
                                    <img src="{{ asset('storage/' . $recent->customer->photo) }}"
                                        class="customer-avatar me-3">
                                @else
                                    <div class="customer-avatar-placeholder me-3">
                                        {{ strtoupper(substr($recent->customer?->fullname ?? 'U', 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <div class="customer-name">
                                        {{ $recent->customer?->fullname }}
                                    </div>

                                    <small class="text-muted">
                                        Conversation #{{ $recent->id }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        {{-- MESSAGE --}}
                        <td>
                            <div class="message-preview">
                                {{ optional($recent->latestMessage)->message ?? '-' }}
                            </div>
                        </td>

                        {{-- UNREAD --}}
                        <td class="text-center">
                            @if ($recent->unread_count > 0)
                                <span class="badge rounded-pill bg-danger">
                                    {{ $recent->unread_count }}
                                </span>
                            @else
                                <span class="badge rounded-pill bg-light text-muted">
                                    0
                                </span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if ($recent->status == 'resolved')
                                <span class="status-badge status-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Resolved
                                </span>
                            @elseif(empty($recent->assigned_to))
                                <span class="status-badge status-danger">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    Unassigned
                                </span>
                            @else
                                <span class="status-badge status-warning">
                                    <i class="bi bi-person-check-fill"></i>
                                    Assigned
                                </span>
                            @endif

                        </td>

                        {{-- BRANCH --}}
                        <td>
                            <span class="branch-badge">
                                {{ $recent->customer?->branch?->branch_name ?? '-' }}
                            </span>
                        </td>

                        {{-- TIME --}}
                        <td>
                            <div class="time-text">
                                {{ \Carbon\Carbon::parse($recent->last_message_at)->diffForHumans() }}
                            </div>

                            <small class="text-muted">
                                {{ date('d M Y H:i', strtotime($recent->last_message_at)) }}
                            </small>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

<style>
    .recent-chat-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .recent-chat-table thead th {
        border: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        font-weight: 600;
    }

    .recent-chat-table tbody tr {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
        transition: .2s;
    }

    .recent-chat-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    }

    .recent-chat-table td {
        border: none;
        padding: 16px;
        vertical-align: middle;
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        object-fit: cover;
    }

    .customer-avatar-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .customer-name {
        font-weight: 600;
        color: #0f172a;
    }

    .message-preview {
        max-width: 350px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #475569;
    }

    .status-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-success {
        background: #dcfce7;
        color: #15803d;
    }

    .status-warning {
        background: #fef3c7;
        color: #b45309;
    }

    .status-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    .branch-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .time-text {
        font-weight: 600;
        color: #0f172a;
    }
</style>
