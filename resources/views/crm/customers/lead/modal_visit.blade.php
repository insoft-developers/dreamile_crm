<div class="modal fade" id="modal-visit" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-visit" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">
                        Modal Visit
                    </h5>
                    <button type="button" class="btn-close icon-btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-large-line fw-semibold"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Visit Date -->


                    <div class="card">
                        <div class="card-body card-color">

                            <input type="hidden" id="visit_customer_id" name="visit_customer_id">
                            <div class="mb-3">
                                <label class="form-label required">Visit Date</label>
                                <input type="datetime-local" name="visit_date" id="visit_date" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Location</label>
                                <textarea placeholder="Alamat/Lokasi visit anda" name="visit_location" id="visit_location" class="form-control"
                                    required></textarea>
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select name="visit_status" id="visit_status" class="form-control" required>
                                    <option value="">- Select -</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            <!-- Upload Foto -->
                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photos[]" id="photos" accept=".jpg,.jpeg,.png" multiple
                                    class="form-control">
                            </div>
                            <div id="preview" class="d-flex flex-wrap gap-3 mb-3"></div>
                            <!-- Preview -->

                            <div class="mb-8">
                                <label class="form-label">Note</label>
                                <textarea placeholder="Tuliskan keterangan visit anda" style="height: 140px;" name="visit_note" id="visit_note"
                                    class="form-control"></textarea>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn-save-visit" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div><!--End modal-->
