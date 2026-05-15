<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <form id="form-add" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}

                <!-- Modal Header -->
                <div class="modal-header border-0 pb-0 px-4 pt-4">

                    <div>
                        <h4 class="modal-title fw-bold mb-1" id="modalLabel">
                            Create Student Lead
                        </h4>

                        <p class="text-muted mb-0 small">
                            Add new student lead information into CRM system
                        </p>
                    </div>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>

                <!-- Modal Body -->
                <div class="modal-body px-4 py-4 bg-light-subtle">

                    <input type="hidden" id="id" name="id">

                    <div class="row g-4">

                        <!-- LEFT COLUMN -->
                        <div class="col-md-4">

                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">

                                    <!-- Section Title -->
                                    <div class="d-flex align-items-center mb-4">

                                        <div class="avatar-sm bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width:50px;height:50px;">

                                            <i class="ri-user-line text-primary fs-5"></i>

                                        </div>

                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                Personal Information
                                            </h6>

                                            <small class="text-muted">
                                                Basic student information
                                            </small>
                                        </div>

                                    </div>

                                    <!-- Full Name -->
                                    <div class="form-group mb-3">
                                        <label for="fullname" class="form-label fw-semibold">
                                            Full Name
                                        </label>

                                        <input type="text"
                                            class="form-control"
                                            id="fullname"
                                            name="fullname"
                                            placeholder="Ex: John Doe"
                                            required>
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group mb-3">

                                        <label for="full_address" class="form-label fw-semibold">
                                            Full Address
                                        </label>

                                        <textarea
                                            class="form-control"
                                            id="full_address"
                                            name="full_address"
                                            rows="4"
                                            style="resize:none;"
                                            placeholder="Input full address..."
                                            required></textarea>

                                    </div>

                                    <!-- School -->
                                    <div class="form-group mb-3">

                                        <label for="school_from" class="form-label fw-semibold">
                                            School From
                                        </label>

                                        <input type="text"
                                            class="form-control"
                                            id="school_from"
                                            name="school_from"
                                            placeholder="Ex: SMA 1 Medan"
                                            required>
                                    </div>

                                    <!-- Class & Major -->
                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="form-group mb-3">

                                                <label for="class" class="form-label fw-semibold">
                                                    Class
                                                </label>

                                                <input type="text"
                                                    class="form-control"
                                                    id="class"
                                                    name="class"
                                                    placeholder="Ex: 12"
                                                    required>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group mb-3">

                                                <label for="major" class="form-label fw-semibold">
                                                    Major
                                                </label>

                                                <input type="text"
                                                    class="form-control"
                                                    id="major"
                                                    name="major"
                                                    placeholder="IPA / IPS"
                                                    required>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group mb-3">

                                        <label for="phone_number" class="form-label fw-semibold">
                                            Phone Number
                                        </label>

                                        <input type="text"
                                            class="form-control"
                                            id="phone_number"
                                            name="phone_number"
                                            placeholder="628123456789"
                                            required>

                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group">

                                        <label for="gender" class="form-label fw-semibold">
                                            Gender
                                        </label>

                                        <select class="form-control"
                                            id="gender"
                                            name="gender"
                                            required>

                                            <option value="">- Select Gender -</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>

                                        </select>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- CENTER COLUMN -->
                        <div class="col-md-4">

                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">

                                    <!-- Section Title -->
                                    <div class="d-flex align-items-center mb-4">

                                        <div class="avatar-sm bg-success-subtle rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width:50px;height:50px;">

                                            <i class="ri-briefcase-line text-success fs-5"></i>

                                        </div>

                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                Lead Information
                                            </h6>

                                            <small class="text-muted">
                                                CRM and consultant information
                                            </small>
                                        </div>

                                    </div>

                                    <!-- Photo -->
                                    <div class="form-group mb-3">

                                        <label for="photo" class="form-label fw-semibold">
                                            Photo (Optional)
                                        </label>

                                        <input accept=".jpg,.jpeg,.png"
                                            type="file"
                                            class="form-control"
                                            id="photo"
                                            name="photo">

                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-3">

                                        <label for="email" class="form-label fw-semibold">
                                            Email (Optional)
                                        </label>

                                        <input type="email"
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="user@mail.com">

                                    </div>

                                    <!-- Lead Source -->
                                    <div class="form-group mb-3">

                                        <label for="lead_source_id" class="form-label fw-semibold">
                                            Lead Source
                                        </label>

                                        <select class="form-control"
                                            id="lead_source_id"
                                            name="lead_source_id">

                                            <option value="">- Select Source -</option>

                                            @foreach ($sources as $source)
                                                <option value="{{ $source->slug }}">
                                                    {{ $source->source_name }}
                                                </option>
                                            @endforeach

                                            <option value="presentation">Presentation</option>
                                            <option value="event">Event</option>

                                        </select>

                                    </div>

                                    <div id="event-container"></div>

                                    <!-- Status -->
                                    <div class="form-group mb-3">

                                        <label for="status" class="form-label fw-semibold">
                                            Status
                                        </label>

                                        <select class="form-control"
                                            id="status"
                                            name="status">

                                            <option value="new-lead">New Lead</option>
                                            <option value="visit">Visit</option>
                                            <option value="deal">Deal</option>
                                            <option value="nok">NOK</option>
                                            <option value="confirm">Confirmation</option>

                                        </select>

                                    </div>

                                    <!-- Consultant -->
                                    <div class="form-group mb-3">

                                        <label for="consultant_id" class="form-label fw-semibold">
                                            Consultant
                                        </label>

                                        <select class="form-control"
                                            id="consultant_id"
                                            name="consultant_id">

                                            <option value="">- Select Consultant -</option>

                                            @foreach ($consultants as $consult)
                                                <option value="{{ $consult->id }}">
                                                    {{ $consult->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <!-- Note -->
                                    <div class="form-group">

                                        <label for="note" class="form-label fw-semibold">
                                            Note
                                        </label>

                                        <textarea
                                            class="form-control"
                                            id="note"
                                            name="note"
                                            rows="4"
                                            style="resize:none;"
                                            placeholder="Write additional notes..."></textarea>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-4">

                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">

                                    <!-- Section Title -->
                                    <div class="d-flex align-items-center mb-4">

                                        <div class="avatar-sm bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center me-3"
                                            style="width:50px;height:50px;">

                                            <i class="ri-map-pin-line text-warning fs-5"></i>

                                        </div>

                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                Location Information
                                            </h6>

                                            <small class="text-muted">
                                                Branch and regional data
                                            </small>
                                        </div>

                                    </div>

                                    <!-- Branch -->
                                    <div class="form-group mb-3">

                                        <label for="branch_id" class="form-label fw-semibold">
                                            Branch
                                        </label>

                                        <select class="form-control"
                                            id="branch_id"
                                            name="branch_id">

                                            <option value="">- Select Branch -</option>

                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">
                                                    {{ $branch->branch_name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <!-- Province -->
                                    <div class="form-group mb-3">

                                        <label for="province_code" class="form-label fw-semibold">
                                            Province
                                        </label>

                                        <select class="form-control select2"
                                            id="province_code"
                                            name="province_code"
                                            style="width:100%;">

                                            <option value="">- Select Province -</option>

                                        </select>

                                    </div>

                                    <!-- Regency -->
                                    <div class="form-group mb-3">

                                        <label for="regency_code" class="form-label fw-semibold">
                                            Regency / City
                                        </label>

                                        <select class="form-control select2"
                                            id="regency_code"
                                            name="regency_code"
                                            style="width:100%;">

                                            <option value="">- Select Regency -</option>

                                        </select>

                                    </div>

                                    <!-- District -->
                                    <div class="form-group mb-3">

                                        <label for="district_code" class="form-label fw-semibold">
                                            District
                                        </label>

                                        <select class="form-control select2"
                                            id="district_code"
                                            name="district_code"
                                            style="width:100%;">

                                            <option value="">- Select District -</option>

                                        </select>

                                    </div>

                                    <!-- Village -->
                                    <div class="form-group">

                                        <label for="village_code" class="form-label fw-semibold">
                                            Village
                                        </label>

                                        <select class="form-control select2"
                                            id="village_code"
                                            name="village_code"
                                            style="width:100%;">

                                            <option value="">- Select Village -</option>

                                        </select>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 px-4 pb-4 pt-0">

                    <button type="button"
                        class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button id="btn-save-data"
                        type="submit"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">

                        <i class="ri-save-line me-1"></i>
                        Save Data

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

{{-- <style>
    .form-control,
    .select2-container .select2-selection--single {
        min-height: 48px;
        border-radius: 12px !important;
    }

    .form-control:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        box-shadow: none;
        border-color: #6366f1;
    }

    .card {
        transition: all 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    textarea.form-control {
        min-height: auto;
    }

    .modal-content {
        background: #fff;
    }
</style> --}}