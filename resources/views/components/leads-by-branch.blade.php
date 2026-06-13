<div wire:poll.5s>
    <div class="table-responsive">
        <table class="table branch-performance-table align-middle mb-0">

            <thead>
                <tr>
                    <th width="250">Branch</th>
                    <th class="text-center">New</th>
                    <th class="text-center">Visit</th>
                    <th class="text-center">Deal</th>
                    <th class="text-center">NOK</th>
                    <th class="text-center">Confirm</th>
                    <th width="250">Conversion</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($branches as $index => $key)
                    @php
                        $conversion = $key->new_count > 0 ? round(($key->student_count / $key->new_count) * 100, 1) : 0;
                    @endphp

                    <tr>

                        {{-- Branch --}}
                        <td>
                            <div class="d-flex align-items-center">

                                <div class="branch-rank">
                                    {{ $index + 1 }}
                                </div>

                                <div>
                                    <div class="branch-name">
                                        {{ $key->branch_name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ number_format($key->new_count) }} Leads
                                    </small>
                                </div>

                            </div>
                        </td>

                        {{-- New --}}
                        <td class="text-center">
                            <span class="metric-badge bg-primary-subtle text-primary">
                                {{ $key->new_count }}
                            </span>
                        </td>

                        {{-- Visit --}}
                        <td class="text-center">
                            <span class="metric-badge bg-info-subtle text-info">
                                {{ $key->visit_count }}
                            </span>
                        </td>

                        {{-- Deal --}}
                        <td class="text-center">
                            <span class="metric-badge bg-success-subtle text-success">
                                {{ $key->deal_count }}
                            </span>
                        </td>

                        {{-- NOK --}}
                        <td class="text-center">
                            <span class="metric-badge bg-danger-subtle text-danger">
                                {{ $key->nok_count }}
                            </span>
                        </td>

                        {{-- Confirm --}}
                        <td class="text-center">
                            <span class="metric-badge bg-warning-subtle text-warning">
                                {{ $key->confirm_count }}
                            </span>
                        </td>

                        {{-- Conversion --}}
                        <td>

                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-semibold">
                                    {{ $key->student_count }} Students
                                </small>

                                <small class="fw-bold text-success">
                                    {{ $conversion }}%
                                </small>
                            </div>

                            <div class="progress branch-progress">
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
    .branch-performance-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .branch-performance-table thead th {
        border: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #64748b;
        font-weight: 600;
    }

    .branch-performance-table tbody tr {
        background: #fff;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        transition: .2s;
    }

    .branch-performance-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .branch-performance-table td {
        border: none;
        padding: 18px;
        vertical-align: middle;
    }

    .branch-rank {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: white;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .branch-name {
        font-weight: 600;
        color: #0f172a;
    }

    .metric-badge {
        min-width: 60px;
        display: inline-block;
        text-align: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-weight: 600;
    }

    .branch-progress {
        height: 10px;
        border-radius: 999px;
        background: #e2e8f0;
    }

    .branch-progress .progress-bar {
        border-radius: 999px;
    }
</style>
