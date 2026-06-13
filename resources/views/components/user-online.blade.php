<div wire:poll.2s>

    <div class="user-online-list">

        @foreach ($users as $user)
            <div class="user-online-item">

                <div class="d-flex align-items-center">

                    {{-- Avatar --}}
                    <div class="user-avatar">

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                        @if ($user->isOnline())
                            <span class="status-dot online"></span>
                        @else
                            <span class="status-dot offline"></span>
                        @endif

                    </div>

                    {{-- User Info --}}
                    <div class="ms-3 flex-grow-1">

                        <div class="user-name">
                            {{ $user->name }}
                        </div>

                        <small class="text-muted">
                            {{ $user->branch?->branch_name ?? 'All Branch' }}
                        </small>

                    </div>

                    {{-- Status --}}
                    <div>

                        @if ($user->isOnline())
                            <span class="online-badge">
                                Online
                            </span>
                        @else
                            <span class="offline-badge">
                                Offline
                            </span>
                        @endif

                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>

<style>
    .user-online-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .user-online-item {
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 14px;
        padding: 14px 16px;
        transition: .2s;
    }

    .user-online-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        position: absolute;
        bottom: -1px;
        right: -1px;
    }

    .status-dot.online {
        background: #22c55e;
    }

    .status-dot.offline {
        background: #94a3b8;
    }

    .user-name {
        font-weight: 600;
        color: #0f172a;
    }

    .online-badge {
        background: #dcfce7;
        color: #15803d;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .offline-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }
</style>
