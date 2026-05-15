<div class="modal fade"
    id="modal-add"
    tabindex="-1"
    aria-labelledby="modalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <form id="form-add"
                method="POST"
                enctype="multipart/form-data">

                {{ csrf_field() }}
                {{ method_field('POST') }}

                <!-- HEADER -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>

                        <h4 class="modal-title fw-bold mb-1"
                            id="modalLabel">

                            WhatsApp Template

                        </h4>

                        <p class="text-muted small mb-0">
                            Create and manage WhatsApp message templates
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

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-4">

                            <!-- ICON HEADER -->
                            <div class="d-flex align-items-center mb-4">

                                <div class="template-icon-box me-3">

                                    <i class="ri-whatsapp-line"></i>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-0">
                                        Template Information
                                    </h6>

                                    <small class="text-muted">
                                        Configure WhatsApp template details
                                    </small>

                                </div>

                            </div>

                            <input type="hidden"
                                id="id"
                                name="id">

                            <div class="row">

                                <!-- DISPLAY NAME -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="display_name"
                                            class="form-label fw-semibold">

                                            Display Name

                                        </label>

                                        <input type="text"
                                            class="form-control modern-input"
                                            id="display_name"
                                            name="display_name"
                                            placeholder="Ex: Promo Juni 2026"
                                            required>

                                        <small class="text-muted">
                                            Friendly name shown in CRM
                                        </small>

                                    </div>

                                </div>

                                <!-- TEMPLATE NAME -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="template_name"
                                            class="form-label fw-semibold">

                                            Template Name

                                        </label>

                                        <input type="text"
                                            class="form-control modern-input"
                                            id="template_name"
                                            name="template_name"
                                            placeholder="Ex: promo_juni_2026"
                                            required>

                                        <small class="text-muted">
                                            Must match template name in Meta
                                        </small>

                                    </div>

                                </div>

                                <!-- CATEGORY -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="category"
                                            class="form-label fw-semibold">

                                            Category

                                        </label>

                                        <select class="form-select modern-input"
                                            id="category"
                                            name="category"
                                            required>

                                            <option value="">
                                                - Select Category -
                                            </option>

                                            <option value="MARKETING">
                                                Marketing
                                            </option>

                                            <option value="UTILITY">
                                                Utility
                                            </option>

                                            <option value="AUTHENTICATION">
                                                Authentication
                                            </option>

                                        </select>

                                    </div>

                                </div>

                                <!-- LANGUAGE -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="language"
                                            class="form-label fw-semibold">

                                            Language

                                        </label>

                                        <select class="form-select modern-input"
                                            id="language"
                                            name="language"
                                            required>

                                            <option value="id">
                                                🇮🇩 Indonesia
                                            </option>

                                            <option value="en_US">
                                                🇺🇸 English (US)
                                            </option>

                                        </select>

                                    </div>

                                </div>

                                <!-- TOTAL VARIABLE -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="total_variable"
                                            class="form-label fw-semibold">

                                            Total Variable

                                        </label>

                                        <input type="number"
                                            min="0"
                                            class="form-control modern-input"
                                            id="total_variable"
                                            name="total_variable"
                                            placeholder="Ex: 2"
                                            value="0"
                                            required>

                                        <small class="text-muted">
                                            Example: {{1}}, {{2}}
                                        </small>

                                    </div>

                                </div>

                                <!-- STATUS -->
                                <div class="col-md-6">

                                    <div class="mb-3">

                                        <label for="status"
                                            class="form-label fw-semibold">

                                            Status

                                        </label>

                                        <select class="form-select modern-input"
                                            id="status"
                                            name="status"
                                            required>

                                            <option value="active">
                                                Active
                                            </option>

                                            <option value="inactive">
                                                Inactive
                                            </option>

                                        </select>

                                    </div>

                                </div>

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

                    <button id="btn-save-data"
                        type="submit"
                        class="btn btn-success rounded-pill px-4 shadow-sm">

                        <i class="ri-save-line me-1"></i>

                        Save Template

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
        border-color:#22c55e;
        box-shadow:0 0 0 4px rgba(34,197,94,.08);
    }

    .template-icon-box{
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

    .bg-light-subtle{
        background:#f8fafc !important;
    }

    .card{
        transition:all .2s ease;
    }

    .card:hover{
        transform:translateY(-2px);
    }

    .btn-success{
        box-shadow:0 2px 10px rgba(34,197,94,.18);
    }

</style>