<div class="modal fade" id="modal-follow-list" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">
                    Modal Title

                </h5>

                <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-large-line fw-semibold"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="followup-list-id">
                <button style="float:right;" onclick="addFollowup()" title="Add Followup"
                    class="me-0 mb-3 btn btn-success btn-sm"><i class="bi bi-plus"></i></button>
                <div id="table-follow-container"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div><!--End modal-->
