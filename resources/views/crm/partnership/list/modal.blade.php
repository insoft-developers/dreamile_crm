<div class="modal fade" id="modal-add" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form id="form-add" method="POST" enctype="multipart/form-data">

                {{ csrf_field() }}
                {{ method_field('POST') }}

                <div class="modal-header">

                    <h5 class="modal-title" id="modalLabel">
                        Modal Title
                    </h5>

                    <button type="button"
                        class="btn-close icon-btn-sm"
                        data-bs-dismiss="modal"
                        aria-label="Close">

                        <i class="ri-close-large-line fw-semibold"></i>

                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="id" name="id">

                    <div class="row">

                        {{-- Partner Type --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="partner_type_id" class="form-label">
                                    Jenis Partnership
                                </label>

                                <select style="width: 100%;" class="form-select select2"
                                    id="partner_type_id"
                                    name="partner_type_id"
                                    required>

                                    <option value="">
                                        -- Pilih Jenis Partnership --
                                    </option>

                                    @foreach($type as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->name }}
                                    </option>
                                    @endforeach

                                </select>

                            </div>
                        </div>


                        {{-- Instance Name --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="instance_name" class="form-label">
                                    Nama Instansi
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="instance_name"
                                    name="instance_name"
                                    placeholder="Masukkan nama instansi.."
                                    required>

                            </div>
                        </div>


                        {{-- Province --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="province_id" class="form-label">
                                    Provinsi
                                </label>

                                <select class="form-select select2" style="width: 100%;"
                                    id="province_id"
                                    name="province_id"
                                    required>

                                    <option value="">
                                        -- Pilih Provinsi --
                                    </option>

                                </select>

                            </div>
                        </div>


                        {{-- City --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="city_id" class="form-label">
                                    Kabupaten/Kota
                                </label>

                                <select style="width: 100%;" class="form-select select2"
                                    id="city_id"
                                    name="city_id"
                                    required>

                                    <option value="">
                                        -- Pilih Kabupaten/Kota --
                                    </option>



                                </select>

                            </div>
                        </div>


                        {{-- Address --}}
                        <div class="col-md-12">
                            <div class="form-group mb-3">

                                <label for="address" class="form-label">
                                    Alamat Lengkap
                                </label>

                                <textarea class="form-control"
                                    id="address"
                                    name="address"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap.."
                                    required></textarea>

                            </div>
                        </div>


                        {{-- PIC Name --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="pic_name" class="form-label">
                                    Nama PIC
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="pic_name"
                                    name="pic_name"
                                    placeholder="Masukkan nama PIC.."
                                    required>

                            </div>
                        </div>


                        {{-- PIC Title --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="pic_title" class="form-label">
                                    Jabatan PIC
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="pic_title"
                                    name="pic_title"
                                    placeholder="Contoh: HR Manager">

                            </div>
                        </div>


                        {{-- WhatsApp --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="whatsapp" class="form-label">
                                    WhatsApp
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="whatsapp"
                                    name="whatsapp"
                                    placeholder="08xxxxxxxxxx">

                            </div>
                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="email@example.com">

                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="pic_dreamile" class="form-label">
                                    PIC Dreamile
                                </label>

                                <select style="width: 100%;"
                                    class="form-control select2"
                                    id="pic_dreamile"
                                    name="pic_dreamile">
                                    <option value=""> -- Pilih PIC Dreamile -- </option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>

                                    @endforeach
                                </select>


                            </div>
                        </div>


                        {{-- Partnership Type Name --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="partnership_type_name" class="form-label">
                                    Partnership Type Name
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="partnership_type_name"
                                    name="partnership_type_name"
                                    placeholder="Masukkan tipe partnership">

                            </div>
                        </div>


                        {{-- Expired Date --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="expired_date" class="form-label">
                                    Expired Date
                                </label>

                                <input type="date"
                                    class="form-control"
                                    id="expired_date"
                                    name="expired_date">

                            </div>
                        </div>


                        {{-- Image --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label for="image" class="form-label">
                                    Image
                                </label>

                                <input type="file"
                                    class="form-control"
                                    id="image"
                                    name="image">

                            </div>
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button id="btn-save-data"
                        type="submit"
                        class="btn btn-primary">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>