<div class="modal fade"
    id="modal-follow-list"
    tabindex="-1"
    aria-labelledby="modalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- HEADER -->
            <div class="modal-header border-0 pb-0 px-4 pt-4">

                <div>

                    <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                        Followup History
                    </h4>

                    <p class="text-muted small mb-0">
                        View and manage all customer followup activities
                    </p>

                </div>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <!-- BODY -->
            <div class="modal-body px-4 py-4 bg-light-subtle">

                <input type="hidden" id="followup-list-id">
                <input type="hidden" id="followup-step">

                <!-- TOP ACTION -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="follow-list-icon">

                            <i class="ri-history-line"></i>

                        </div>

                        <div>

                            <h6 class="fw-bold mb-0">
                                Customer Followup Timeline
                            </h6>

                            <small class="text-muted">
                                Track customer interactions and progress
                            </small>

                        </div>

                    </div>

                    <button id="add-followup-btn"
                        onclick="addFollowup()"
                        class="btn btn-success rounded-pill px-4 shadow-sm">

                        <i class="bi bi-plus-lg me-1"></i>

                        Add Followup

                    </button>

                </div>

                <!-- TABLE CONTAINER -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                    <div class="card-body p-0">

                        <div id="table-follow-container"
                            class="follow-table-wrapper">
                        </div>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 px-4 pb-4 pt-0">

                <button type="button"
                    class="btn btn-light border rounded-pill px-4"
                    data-bs-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>

<style>

    .follow-list-icon{
        width:54px;
        height:54px;
        border-radius:18px;
        background:#ecfdf5;
        color:#16a34a;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:24px;
        flex-shrink:0;
    }

    .follow-table-wrapper{
        min-height:200px;
        background:#fff;
    }

    .follow-table-wrapper table{
        margin-bottom:0;
    }

    .follow-table-wrapper table thead{
        background:#f8fafc;
    }

    .follow-table-wrapper table thead th{
        border:none;
        padding:18px 20px;
        font-size:13px;
        font-weight:700;
        color:#475569;
        white-space:nowrap;
    }

    .follow-table-wrapper table tbody td{
        padding:18px 20px;
        vertical-align:middle;
        border-color:#f1f5f9;
    }

    .follow-table-wrapper table tbody tr{
        transition:all .2s ease;
    }

    .follow-table-wrapper table tbody tr:hover{
        background:#f8fafc;
    }

    .card{
        transition:all .2s ease;
    }

    .card:hover{
        transform:translateY(-2px);
    }

    .bg-light-subtle{
        background:#f8fafc !important;
    }

    .btn-success{
        box-shadow:0 2px 10px rgba(34,197,94,.18);
    }

</style>