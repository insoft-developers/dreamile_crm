<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="form-add" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>

                        <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                            Visit Management
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
                    <div class="form-group mb-3">
                        <label for="group_name" class="form-label fw-semibold">Group Name</label>
                        <input type="text" class="form-control modern-input" id="group_name" name="group_name"
                            placeholder="Ex: Leads From Facebook" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control modern-input" rows="3" style="resize:none;" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="branch_id" class="form-label fw-semibold">Branch</label>
                        <select id="branch_id" name="branch_id" class="form-control modern-input" required>
                            <option value="">- Select -</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">

                    <button type="button"
                        class="btn btn-light border rounded-pill px-4"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button id="btn-save-data"
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">

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
</style>
