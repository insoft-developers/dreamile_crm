<div class="modal fade" id="modal-follow" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-follow" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Modal Title
                    </h5>
                    <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-large-line fw-semibold"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="customer_follow_id" name="customer_follow_id">
                    <input type="hidden" id="step" name="step">
                    <div class="mb-3">
                        <label class="form-label required">Followup Date</label>
                        <input type="datetime-local" name="followup_date" id="followup_date" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="followup_note" class="form-label required">Followup Note</label>
                        <textarea class="form-control" id="followup_note" name="followup_note" placeholder="Make your note after following up"
                            required></textarea>
                    </div>
                   

                    <div class="form-group mb-3">
                        <label for="followup_image" class="form-label">Followup Image</label>
                        <input accept=".jpg,.jpeg,.png" type="file" class="form-control" id="followup_image"
                            name="followup_image">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn-save-follow" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!--End modal-->
