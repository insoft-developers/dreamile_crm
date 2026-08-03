<div wire:poll.60s>

    <div class="lead-status-list">

        <div class="lead-status-item">
            <div class="status-icon bg-success-subtle text-success">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <div class="flex-grow-1 ms-3">
                <div class="status-title">
                    New Lead
                </div>

                <small class="text-muted">
                    New incoming prospects
                </small>
            </div>

            <div class="status-total">
                {{ number_format($data['new-lead'] ?? 0) }}
            </div>
        </div>

        <div class="lead-status-item">
            <div class="status-icon bg-warning-subtle text-warning">
                <i class="bi bi-calendar-check-fill"></i>
            </div>

            <div class="flex-grow-1 ms-3">
                <div class="status-title">
                    Visit
                </div>

                <small class="text-muted">
                    Scheduled visits
                </small>
            </div>

            <div class="status-total">
                {{ number_format($data['visit'] ?? 0) }}
            </div>
        </div>

        <div class="lead-status-item">
            <div class="status-icon bg-primary-subtle text-primary">
                <i class="bi bi-patch-check-fill"></i>
            </div>

            <div class="flex-grow-1 ms-3">
                <div class="status-title">
                    Confirmation
                </div>

                <small class="text-muted">
                    Awaiting confirmation
                </small>
            </div>

            <div class="status-total">
                {{ number_format($data['confirm'] ?? 0) }}
            </div>
        </div>

        <div class="lead-status-item">
            <div class="status-icon bg-info-subtle text-info">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="flex-grow-1 ms-3">
                <div class="status-title">
                    Deal
                </div>

                <small class="text-muted">
                    Successful conversion
                </small>
            </div>

            <div class="status-total">
                {{ number_format($data['deal'] ?? 0) }}
            </div>
        </div>

        <div class="lead-status-item">
            <div class="status-icon bg-danger-subtle text-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div class="flex-grow-1 ms-3">
                <div class="status-title">
                    NOK
                </div>

                <small class="text-muted">
                    Not interested
                </small>
            </div>

            <div class="status-total">
                {{ number_format($data['nok'] ?? 0) }}
            </div>
        </div>

    </div>

</div>

<style>
    .lead-status-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .lead-status-item {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 14px;
        padding: 14px 16px;
        transition: .2s;
    }

    .lead-status-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
    }

    .status-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .status-title {
        font-weight: 600;
        color: #0f172a;
    }

    .status-total {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        min-width: 60px;
        text-align: right;
    }
</style>
