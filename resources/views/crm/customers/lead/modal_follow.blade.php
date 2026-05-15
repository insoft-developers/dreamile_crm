<div class="modal fade" id="modal-follow" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <form id="form-follow" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>

                        <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                            Followup Management
                        </h4>

                        <p class="text-muted small mb-0">
                            Record customer followup activities and notes
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

                                <div class="follow-icon-box me-3">

                                    <i class="ri-customer-service-2-line"></i>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-0">
                                        Followup Information
                                    </h6>

                                    <small class="text-muted">
                                        Customer communication and activity notes
                                    </small>

                                </div>

                            </div>

                            <!-- HIDDEN -->
                            <input type="hidden" id="aksi" name="aksi">
                            <input type="hidden" id="follow_id" name="follow_id">
                            <input type="hidden" id="customer_follow_id" name="customer_follow_id">
                            <input type="hidden" id="step" name="step">

                            <!-- DATE -->
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Followup Date
                                </label>

                                <input type="datetime-local"
                                    name="followup_date"
                                    id="followup_date"
                                    class="form-control modern-input"
                                    required>

                            </div>

                            <!-- NOTE -->
                            <div class="mb-3">

                                <label for="followup_note"
                                    class="form-label fw-semibold">

                                    Followup Note

                                </label>

                                <textarea
                                    class="form-control modern-input"
                                    id="followup_note"
                                    name="followup_note"
                                    rows="7"
                                    style="resize:none;"
                                    placeholder="Write your followup notes here..."
                                    required></textarea>

                                <small class="text-muted">
                                    Explain customer response, progress, or next action
                                </small>

                            </div>

                            <!-- IMAGE -->
                            <div class="mb-3">

                                <label for="followup_image"
                                    class="form-label fw-semibold">

                                    Followup Image

                                </label>

                                <input accept=".jpg,.jpeg,.png"
                                    type="file"
                                    class="form-control modern-input"
                                    id="followup_image"
                                    name="followup_image">

                                <small class="text-muted">
                                    Optional image/documentation for this followup
                                </small>

                            </div>

                            <!-- PREVIEW -->
                            <div id="follow-preview"
                                class="mt-3 d-none">

                                <img id="preview-follow-image"
                                    src=""
                                    class="preview-image">

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

                    <button id="btn-save-follow"
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">

                        <i class="ri-save-line me-1"></i>
                        Save Followup

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

    .follow-icon-box{
        width:52px;
        height:52px;
        border-radius:16px;
        background:#ecfeff;
        color:#0891b2;
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

    .preview-image{
        width:120px;
        height:120px;
        object-fit:cover;
        border-radius:18px;
        padding:4px;
        border:2px solid #06b6d4;
        box-shadow:0 2px 10px rgba(0,0,0,.06);
    }

</style>

<script>

    $('#followup_image').on('change', function(e){

        const file = e.target.files[0];

        if(file){

            const reader = new FileReader();

            reader.onload = function(event){

                $('#preview-follow-image').attr('src', event.target.result);

                $('#follow-preview').removeClass('d-none');

            }

            reader.readAsDataURL(file);

        }

    });

</script>