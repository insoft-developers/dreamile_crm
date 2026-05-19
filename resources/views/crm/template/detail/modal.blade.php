<div class="modal fade"
    id="modal-add"
    tabindex="-1"
    aria-labelledby="modalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

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

                            Broadcast Template Detail

                        </h4>

                        <p class="text-muted small mb-0">
                            Manage WhatsApp Broadcast message templates
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
                            <input type="hidden"
                                id="id"
                                name="id">

                            <input type="hidden" id="template_id" name="template_id" value="{{ $data->id }}">
                            <div class="row">

                                <!-- CATEGORY -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="content_type" class="form-label fw-semibold">
                                            Content Type
                                        </label>
                                        <select class="form-select modern-input"
                                            id="content_type"
                                            name="content_type"
                                            required>
                                            <option value="">- Select -</option>
                                            <option value="header">Header</option>
                                            <option value="body">Body</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field_type" class="form-label fw-semibold">
                                            Field Type
                                        </label>
                                        <select class="form-select modern-input"
                                            id="field_type"
                                            name="field_type"
                                            required>
                                            <option value="">- Select -</option>
                                            <option value="text">Text</option>
                                            <option value="image">Image</option>
                                            <option value="name">Name</option>
                                            <option value="school">School</option>
                                            <option value="phone_number">Phone Number</option>
                                            <option value="address">Address</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="field_value" class="form-label fw-semibold">
                                            Field Value
                                        </label>
                                        <input type="text" class="form-select modern-input"
                                            id="field_value"
                                            name="field_value"
                                            required>
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