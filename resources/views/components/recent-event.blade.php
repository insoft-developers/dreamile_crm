<div wire:poll.5s>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0">

            <thead>
                <tr>
                    <th width="320">Event</th>
                    <th>Branch</th>
                    <th>Date</th>
                    <th class="text-center">Leads</th>
                    <th class="text-center">Deals</th>
                    <th width="220">Performance</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($data as $key)
                    @php
                        $leads = optional($key->leads)->count() ?? 0;
                        $deals = optional($key->deals)->count() ?? 0;

                        $conversion = $leads > 0 ? round(($deals / $leads) * 100, 1) : 0;
                    @endphp

                    <tr>

                        {{-- EVENT --}}
                        <td>

                            <div class="d-flex align-items-center">

                                <div class="event-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div class="ms-3">

                                    <div class="event-title">
                                        {{ $key->event_name }}
                                    </div>

                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $key->event_location }}
                                    </small>

                                </div>

                            </div>

                        </td>

                        {{-- BRANCH --}}
                        <td>
                            <span class="branch-chip">
                                {{ optional($key->branch)->branch_name }}
                            </span>
                        </td>

                        {{-- DATE --}}
                        <td>
                            <div class="fw-semibold">
                                {{ date('d M Y', strtotime($key->event_date)) }}
                            </div>

                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($key->event_date)->diffForHumans() }}
                            </small>
                        </td>

                        {{-- LEADS --}}
                        <td class="text-center">
                            <span class="metric-pill bg-primary-subtle text-primary">
                                {{ $leads }}
                            </span>
                        </td>

                        {{-- DEALS --}}
                        <td class="text-center">
                            <span class="metric-pill bg-success-subtle text-success">
                                {{ $deals }}
                            </span>
                        </td>

                        {{-- PERFORMANCE --}}
                        <td>

                            <div class="d-flex justify-content-between mb-1">
                                <small>Conversion</small>

                                <small class="fw-bold text-success">
                                    {{ $conversion }}%
                                </small>
                            </div>

                            <div class="progress performance-progress">
                                <div class="progress-bar bg-success" style="width: {{ $conversion }}%">
                                </div>
                            </div>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>

<style>
    .event-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .event-table thead th {
        border: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        font-weight: 600;
    }

    .event-table tbody tr {
        background: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        transition: .2s;
    }

    .event-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .event-table td {
        border: none;
        padding: 18px;
        vertical-align: middle;
    }

    .event-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .event-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .branch-chip {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .metric-pill {
        min-width: 60px;
        display: inline-block;
        text-align: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-weight: 600;
    }

    .performance-progress {
        height: 10px;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .performance-progress .progress-bar {
        border-radius: 999px;
    }
</style>
