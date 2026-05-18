<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <form id="form-add" method="POST">
                {{ csrf_field() }}
                {{ method_field('POST') }}

                <div class="modal-header border-0 bg-light py-3 px-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="modalLabel">
                            Create Broadcast Campaign
                        </h5>
                        <p class="text-muted mb-0 small">
                            Send WhatsApp broadcast messages to selected contacts.
                        </p>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">

                    <input type="hidden" id="id" name="id">

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Campaign Name
                            </label>

                            <input type="text" class="form-control modern-input" id="name" name="name"
                                placeholder="Ex: Promo Ramadhan 2026" required>

                            <small class="text-muted">
                                Internal campaign name for reporting.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="template_name" class="form-label fw-semibold">
                                Template Name
                            </label>

                            <input type="text" class="form-control modern-input" id="template_name"
                                name="template_name" placeholder="Ex: promo_ramadhan" required>

                            <small class="text-muted">
                                WhatsApp approved template name.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="message" class="form-label fw-semibold">
                                Message Preview
                            </label>

                            <textarea class="form-control modern-input" id="message" name="message" rows="5"
                                placeholder="Write your broadcast message preview here..."></textarea>

                            <small class="text-muted">
                                This is only for preview/history in CRM.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold d-block mb-2">
                                Select Contacts
                            </label>

                            <select class="form-control modern-input" id="contact_type" name="contact_type" required>
                                <option value="">- Select -</option>
                                <option value="contact">Contact</option>
                                <option value="group">Group</option>
                            </select>
                        </div>

                        <div id="contact-container" class="col-md-12 mb-3">

                            <div class="form-group">

                                <label class="form-label fw-semibold d-block mb-2">
                                    Select Contacts
                                </label>

                                <select style="width:100%" class="form-control modern-input" id="contact_target"
                                    name="contact_target[]" multiple>

                                    @foreach ($dataContact as $contact)
                                        <option value="{{ $contact->id }}">
                                            {{ $contact->fullname }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div id="group-container" class="col-md-12 mb-3 d-none">

                            <div class="form-group">

                                <label class="form-label fw-semibold d-block mb-2">
                                    Select Group
                                </label>

                                <select style="width:100%" class="form-control modern-input" id="group_target"
                                    name="group_target[]" multiple>

                                    @foreach ($dataGroup as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->group_name }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button id="btn-save-data" type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="ri-send-plane-fill me-1"></i>
                        Start Broadcast
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>


<style>
    .modern-input {
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #fff;
        transition: all .2s ease;
    }

    .modern-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .08);
    }

    textarea.modern-input {
        min-height: auto;
        padding-top: 14px;
    }



    .card {
        transition: all .2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .bg-light-subtle {
        background: #f8fafc !important;
    }

    .select2-container--default .select2-selection--single {
        min-height: 48px;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        transition: all .2s ease;
        display: flex !important;
        align-items: center;
        padding-left: 6px;
    }

    /* TEXT */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 48px !important;
        color: #0f172a;
        padding-left: 8px !important;
    }

    /* ARROW */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 10px !important;
    }

    /* FOCUS */
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, .08);
    }

    /* DROPDOWN */
    .select2-dropdown {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    /* SEARCH INPUT */
    .select2-search__field {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 10px 14px 17px 9px !important;
        width: 100% !important;

    }

    /* RESULT ITEM */
    .select2-results__option {
        padding: 10px 14px !important;
    }

    /* HOVER */
    .select2-results__option--highlighted {
        background: #6366f1 !important;
        color: #fff !important;
    }

    /* MULTIPLE SELECT */
    .select2-container--default .select2-selection--multiple {
        min-height: 48px;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 6px;
    }


    /* PLACEHOLDER */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }

    .select2-container {
        z-index: 999999 !important;
    }

    .select2-dropdown {
        z-index: 999999 !important;
    }
</style>
