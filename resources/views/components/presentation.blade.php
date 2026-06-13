<div wire:poll.5s>
    <div class="table-responsive">
        <table class="table presentation-table align-middle mb-0">

            <thead>
                <tr>
                    <th width="280">Presentation</th>
                    <th>Branch</th>
                    <th>Date</th>
                    <th>EC</th>
                    <th class="text-center">Audience</th>
                    <th class="text-center">Interest</th>
                    <th class="text-center">Leads</th>
                    <th class="text-center">Deals</th>
                    <th width="220">Performance</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($data as $key)
                    @php
                        $audience = $key->audience ?? 0;
                        $leads = optional($key->leads)->count() ?? 0;
                        $deals = optional($key->deals)->count() ?? 0;

                        $conversion = $audience > 0 ? round(($deals / $audience) * 100, 1) : 0;
                    @endphp

                    <tr>

                        {{-- Presentation --}}
                        <td>
                            <div class="presentation-info">

                                <div class="presentation-title">
                                    {{ $key->title }}
                                </div>

                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $key->location }}
                                </small>

                            </div>
                        </td>

                        {{-- Branch --}}
                        <td>
                            <span class="branch-chip">
                                {{ optional($key->branch)->branch_name }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td>
                            <div class="fw-semibold">
                                {{ date('d M Y', strtotime($key->date)) }}
                            </div>
                        </td>

                        {{-- EC --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ec-avatar">
                                    {{ strtoupper(substr(optional($key->consultant)->name ?? 'U', 0, 1)) }}
                                </div>

                                <span class="ms-2">
                                    {{ optional($key->consultant)->name }}
                                </span>
                            </div>
                        </td>

                        {{-- Audience --}}
                        <td class="text-center">
                            <span class="metric-pill bg-primary-subtle text-primary">
                                {{ $audience }}
                            </span>
                        </td>

                        {{-- Interest --}}
                        <td class="text-center">

                            <div class="small text-success fw-semibold">
                                ST {{ $key->sangat_tertarik ?? 0 }}
                            </div>

                            <div class="small text-primary">
                                TR {{ $key->tertarik ?? 0 }}
                            </div>

                            <div class="small text-danger">
                                KT {{ $key->kurang_tertarik ?? 0 }}
                            </div>

                        </td>

                        {{-- Leads --}}
                        <td class="text-center">
                            <span class="metric-pill bg-info-subtle text-info">
                                {{ $leads }}
                            </span>
                        </td>

                        {{-- Deals --}}
                        <td class="text-center">
                            <span class="metric-pill bg-success-subtle text-success">
                                {{ $deals }}
                            </span>
                        </td>

                        {{-- Performance --}}
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
    .presentation-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .presentation-table thead th {
        border: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        font-weight: 600;
    }

    .presentation-table tbody tr {
        background: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        transition: .2s;
    }

    .presentation-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .presentation-table td {
        border: none;
        padding: 18px;
        vertical-align: middle;
    }

    .presentation-title {
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
        min-width: 55px;
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 600;
    }

    .ec-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
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
