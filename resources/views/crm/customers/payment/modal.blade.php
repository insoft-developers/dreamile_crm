<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-add" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="id">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" name="payment_date" id="payment_date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Student</label>
                            <select class="form-select" name="customer_id" id="customer_id" required>
                                <option value="">-- Pilih Student --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah Pembayaran</label>
                            <input type="text" class="form-control text-end uang"
                                   name="payment_amount"
                                   id="payment_amount"
                                   placeholder="0"
                                   required>
                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Outstanding</label>
                            <input type="text" class="form-control text-end uang"
                                   name="outstanding_amount"
                                   id="outstanding_amount"
                                   readonly>
                        </div>

                       
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Sisa Outstanding</label>
                            <input type="text" class="form-control text-end uang"
                                   name="outstanding_payment"
                                   id="outstanding_payment"
                                   readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control"
                                      name="keterangan"
                                      id="keterangan"
                                      rows="3"
                                      placeholder="Masukkan keterangan (opsional)"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>