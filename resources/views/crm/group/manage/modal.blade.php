<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="form-add" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>

                        <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                            Group Contact
                        </h4>

                        <p class="text-muted small mb-0">
                            Manage group contact for your Broadcast
                        </p>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>
                <div class="modal-body px-4 py-4 bg-light-subtle">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="contact_group_id" name="contact_group_id" value="{{ $contact_group_id }}">

                    <div class="form-group mb-3">
                        <label for="customer_id" class="form-label fw-semibold">Contacts</label>
                        <select style="width: 100%" id="customer_id" name="customer_id[]" multiple class="select2 form-control modern-input"
                            required>
                            <option value="">- Select Contact -</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->fullname }} ({{ $contact->phone_number }})</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">

                    <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">

                        Close

                    </button>

                    <button id="btn-save-data" type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">

                        <i class="ri-save-line me-1"></i>
                        Save Contact Group

                    </button>

                </div>
            </form>
        </div>
    </div>
</div><!--End modal-->

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

    /* =========================================================
| SELECT2 MODERN STYLE
|========================================================= */

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
        overflow: hidden;
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

    /* TAG */
    /* .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: #eef2ff !important;
        border: none !important;
        border-radius: 999px !important;
        padding: 4px 10px !important;
        color: #4338ca !important;
        font-size: 12px;
    } */

    /* PLACEHOLDER */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #94a3b8 !important;
    }
</style>
