<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form id="form-add" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header border-0 bg-light py-3 px-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="modalLabel">
                            Modal Title
                        </h5>
                        <p class="text-muted mb-0 small">
                            Manage Presentation data
                        </p>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label fw-semibold d-block mb-2">Title</label>
                        <input type="text" class="form-control modern-input" id="title" name="title"
                            placeholder="Presentation Title" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="location" class="form-label fw-semibold d-block mb-2">Location</label>
                        <textarea class="form-control modern-input" id="location" name="location" placeholder="ex: Prime One School"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for=date class="form-label fw-semibold d-block mb-2">Date</label>
                        <input type=date class="form-control modern-input" id=date name=date placeholder="Presentation Date"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for=consultant_id class="form-label fw-semibold d-block mb-2">Consultant</label>
                        <select class="form-control modern-input" id=consultant_id name=consultant_id required>
                            <option value="">- Select -</option>
                            @foreach($consultants as $consult)
                                <option value="{{ $consult->id }}">{{ $consult->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="audience" class="form-label fw-semibold d-block mb-2">Total Audience</label>
                        <input type="number" class="form-control modern-input" id="audience" name="audience"
                            placeholder="Audience attended presentation">
                    </div>

                    <div class="row">

                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="tertarik" class="form-label fw-semibold d-block mb-2">Tertarik</label>
                                <input type="number" class="form-control modern-input" id="tertarik" name="tertarik"
                                    placeholder="ex 10">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="sangat_tertarik" class="form-label fw-semibold d-block mb-2">Sangat Tertarik</label>
                                <input type="number" class="form-control modern-input" id="sangat_tertarik" name="sangat_tertarik"
                                    placeholder="ex 14">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="kurang_tertarik" class="form-label fw-semibold d-block mb-2">Kurang Tertarik</label>
                                <input type="number" class="form-control modern-input" id="kurang_tertarik" name="kurang_tertarik"
                                    placeholder="ex 10">
                            </div>
                        </div>
                    </div>

                     <div class="form-group mb-3">
                        <label for="description" class="form-label fw-semibold d-block mb-2">Description</label>
                        <textarea style="height: 150px;" class="form-control modern-input" id="description" name="description" placeholder="ex: Make your note here..."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for=branch_id class="form-label fw-semibold d-block mb-2">Branch</label>
                        <select class="form-control modern-input" id=branch_id name=branch_id required>
                            <option value="">- Select -</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group mb-3">
                        <label for="image" class="form-label fw-semibold d-block mb-2">Image</label>
                        <input accept=".jpg,.jpeg,.png" type="file" class="form-control modern-input" id="image"
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
</style>