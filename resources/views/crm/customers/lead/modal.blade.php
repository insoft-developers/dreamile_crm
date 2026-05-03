<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">

                                <div class="card-body card-color">
                                    <input type="hidden" id="id" name="id">

                                    <div class="form-group mb-3">
                                        <label for="fullname" class="form-label required">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname"
                                            placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="full_address" class="form-label required">Full Address </label>
                                        <textarea class="form-control" id="full_address" name="full_address" required>
                                           
                                        </textarea>

                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="school_from" class="form-label required">School From</label>
                                        <input type="text" class="form-control" id="school_from" name="school_from"
                                            placeholder="Ex: SMA 1 Medan" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="class" class="form-label required">Class</label>
                                                <input type="text" class="form-control" id="class" name="class"
                                                    placeholder="Ex: Kelas 12" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="major" class="form-label required">Major</label>
                                                <input type="text" class="form-control" id="major" name="major"
                                                    placeholder="Ex: IPA/IPS" required>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="phone_number" class="form-label required">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number"
                                                name="phone_number" placeholder="Ex: 6281332330000" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="gender" class="form-label required">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="">- Select - </option>
                                                <option value="male">Laki-Laki</option>
                                                <option value="female">Female</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body card-color">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Photo (optional)</label>
                                        <input accept=".jpg,.jpeg,.png" type="file" class="form-control"
                                            id="photo" name="photo">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email (Optional)</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Ex: user@mail.com" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lead_source_id" class="form-label required">Lead Source</label>
                                        <select class="form-control" id="lead_source_id" name="lead_source_id">

                                            <option value="">- Select -</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->slug }}">{{ $source->source_name }}</option>
                                            @endforeach
                                            <option value="presentation">Presentation</option>
                                            <option value="event">Event</option>

                                        </select>
                                    </div>
                                    <div id="event-container"></div>
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label required">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="new-lead">New Lead</option>
                                            <option value="visit">Visit</option>
                                            <option value="deal">Deal</option>
                                            <option value="nok">NOK</option>
                                            <option value="confirm">Confirmation</option>
                                        </select>

                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="consultant_id" class="form-label">Consultant (Optional)</label>
                                        <select class="form-control" id="consultant_id" name="consultant_id">
                                            <option value="">- Select -</option>
                                            @foreach ($consultants as $consult)
                                                <option value="{{ $consult->id }}">{{ $consult->name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="note" class="form-label">Note (Optional)</label>
                                        <textarea class="form-control" id="note" name="note">
                                           
                                        </textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body card-color">
                                    <div class="form-group mb-3">
                                        <label for="branch_id" class="form-label">Branch</label>
                                        <select class="form-control" id="branch_id" name="branch_id">
                                            <option value="">- Select - </option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="province_code" class="form-label">Province (Optional)</label>
                                        <select style="width:100px;" class="form-control select2" id="province_code" name="province_code">
                                            <option value="">- Select - </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="regency_code" class="form-label">Regency/City (Optional)</label>
                                        <select style="width:100px;" class="form-control select2" id="regency_code" name="regency_code">
                                            <option value="">- Select - </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="district_code" class="form-label">District (Optional)</label>
                                        <select style="width:100px;" class="form-control select2" id="district_code" name="district_code">
                                            <option value="">- Select - </option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="village_code" class="form-label">Village (Optional)</label>
                                        <select style="width:100px;" class="form-control select2" id="village_code" name="village_code">
                                            <option value="">- Select - </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
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
