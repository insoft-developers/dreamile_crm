<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-add" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Modal Title
                    </h5>
                    <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-large-line fw-semibold"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name"
                            placeholder="Event Name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for=event_date class="form-label">Event Date</label>
                        <input type=date class="form-control" id=event_date name=event_date placeholder="Event Date"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="event_location" class="form-label">Event Location</label>
                        <textarea class="form-control" id="event_location" name="event_location" placeholder="Event_Location"></textarea>
                    </div>


                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Event Image</label>
                        <input accept=".jpg,.jpeg,.png" type="file" class="form-control" id="image"
                            name="image">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn-save-data" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!--End modal-->
