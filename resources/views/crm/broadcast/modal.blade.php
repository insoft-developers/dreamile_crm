
<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

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

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Ex: Promo Ramadhan 2026"
                                required>

                            <small class="text-muted">
                                Internal campaign name for reporting.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="template_name" class="form-label fw-semibold">
                                Template Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="template_name"
                                name="template_name"
                                placeholder="Ex: promo_ramadhan"
                                required>

                            <small class="text-muted">
                                WhatsApp approved template name.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="message" class="form-label fw-semibold">
                                Message Preview
                            </label>

                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Write your broadcast message preview here..."></textarea>

                            <small class="text-muted">
                                This is only for preview/history in CRM.
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold d-block mb-2">
                                Select Contacts
                            </label>

                            <div class="border rounded-3 p-3 bg-light-subtle">

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="all" id="all-customers" name="contact_type[]">

                                    <label class="form-check-label" for="all-customers">
                                        All Customers
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="leads" id="leads" name="contact_type[]">

                                    <label class="form-check-label" for="leads">
                                        Leads
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="active" id="active-customers" name="contact_type[]">

                                    <label class="form-check-label" for="active-customers">
                                        Active Customers
                                    </label>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light px-4"
                        data-bs-dismiss="modal">
                        Close
                    </button>

                    <button
                        id="btn-save-data"
                        type="submit"
                        class="btn btn-success px-4 shadow-sm">
                        <i class="ri-send-plane-fill me-1"></i>
                        Start Broadcast
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
