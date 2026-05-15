<div class="modal fade" id="modal-visit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <form id="form-visit" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>

                        <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                            Visit Management
                        </h4>

                        <p class="text-muted small mb-0">
                            Schedule and manage customer visit information
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

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                        <div class="card-body p-4">

                            <!-- SECTION TITLE -->
                            <div class="d-flex align-items-center mb-4">

                                <div class="visit-icon-box me-3">

                                    <i class="ri-map-pin-time-line"></i>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-0">
                                        Visit Information
                                    </h6>

                                    <small class="text-muted">
                                        Complete customer visit details
                                    </small>

                                </div>

                            </div>

                            <input type="hidden"
                                id="visit_customer_id"
                                name="visit_customer_id">

                            <!-- VISIT DATE -->
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Visit Date
                                </label>

                                <input type="datetime-local"
                                    name="visit_date"
                                    id="visit_date"
                                    class="form-control modern-input"
                                    required>

                            </div>

                            <!-- LOCATION -->
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Location
                                </label>

                                <textarea
                                    placeholder="Input visit location/address..."
                                    name="visit_location"
                                    id="visit_location"
                                    class="form-control modern-input"
                                    rows="3"
                                    style="resize:none;"
                                    required></textarea>

                            </div>

                            <!-- STATUS -->
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <select name="visit_status"
                                    id="visit_status"
                                    class="form-control modern-input"
                                    required>

                                    <option value="">- Select Status -</option>

                                    <option value="scheduled">
                                        Scheduled
                                    </option>

                                    <option value="done">
                                        Done
                                    </option>

                                </select>

                            </div>

                            <!-- PHOTO -->
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Upload Photos
                                </label>

                                <input type="file"
                                    name="photos[]"
                                    id="photos"
                                    accept=".jpg,.jpeg,.png"
                                    multiple
                                    class="form-control modern-input">

                                <small class="text-muted">
                                    You can upload multiple visit photos
                                </small>

                            </div>

                            <!-- PREVIEW -->
                            <div id="preview"
                                class="d-flex flex-wrap gap-3 mb-4">
                            </div>

                            <!-- NOTE -->
                            <div>

                                <label class="form-label fw-semibold">
                                    Visit Note
                                </label>

                                <textarea
                                    placeholder="Write your visit notes here..."
                                    name="visit_note"
                                    id="visit_note"
                                    class="form-control modern-input"
                                    rows="6"
                                    style="resize:none;"></textarea>

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

                    <button id="btn-save-visit"
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">

                        <i class="ri-save-line me-1"></i>
                        Save Visit

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<style>

    .modern-input{
        min-height:48px;
        border-radius:14px;
        border:1px solid #e2e8f0;
        background:#fff;
        transition:all .2s ease;
    }

    .modern-input:focus{
        border-color:#6366f1;
        box-shadow:0 0 0 4px rgba(99,102,241,.08);
    }

    textarea.modern-input{
        min-height:auto;
        padding-top:14px;
    }

    .visit-icon-box{
        width:52px;
        height:52px;
        border-radius:16px;
        background:#eef2ff;
        color:#6366f1;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
        flex-shrink:0;
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

    #preview img{
        width:90px;
        height:90px;
        object-fit:cover;
        border-radius:16px;
        padding:4px;
        border:2px solid #22c55e;
        box-shadow:0 2px 10px rgba(0,0,0,.06);
    }

</style>