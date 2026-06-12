<div class="modal fade" id="modal-import-presentation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-lg" role="document">

        <form id="form-import-presentation" action="{{ route('presentation.import') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Import Presentation
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>File Excel</label>

                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".xlsx,.xls"
                               required>

                        <small class="text-muted">
                            Format yang didukung: .xlsx dan .xls
                        </small>
                    </div>

                    <hr>

                    <h6>
                        <i class="fa fa-info-circle"></i>
                        Aturan Upload
                    </h6>

                    <div class="alert alert-info mb-0">

                        <ol class="mb-0 pl-3">
                            <li>Download template terlebih dahulu.</li>

                            <li>
                                Jangan mengubah nama sheet:
                                <b>Presentation Upload</b>,
                                <b>Consultants</b>,
                                <b>Branches</b>.
                            </li>

                            <li>
                                Isi data pada sheet
                                <b>Presentation Upload</b>.
                            </li>

                            <li>
                                Pilih Consultant dan Branch dari dropdown yang tersedia.
                            </li>

                            <li>
                                Format tanggal harus:
                                <b>YYYY-MM-DD</b>.
                            </li>

                            <li>
                                Jangan mengubah nama kolom pada template.
                            </li>

                            <li>
                                Pastikan file disimpan dalam format
                                <b>.xlsx</b>.
                            </li>
                        </ol>

                        <hr>

                        <a href="{{ route('presentation.template') }}"
                           class="btn btn-success btn-sm"
                           target="_blank">

                            <i class="fa fa-download"></i>
                            Download Template
                        </a>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button id="btn-submit-import" type="submit"
                            class="btn btn-primary">
                        <i class="fa fa-upload"></i>
                        Import Data
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>