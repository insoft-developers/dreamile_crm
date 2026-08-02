<script>

    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/payment/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/payment/export/pdf?' + params, '_blank');
    }

    function filterData() {
        $('#list-table').DataTable().ajax.reload(null, false);
    }

    function resetFilter() {
        // reset form
        document.getElementById('filterForm').reset();



        // reload datatable
        $('#list-table').DataTable().ajax.reload(null, false);
    }


    const paymentAmount = new AutoNumeric('#payment_amount', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 0
    });

    const outstandingAmount = new AutoNumeric('#outstanding_amount', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 0
    });

    const outstandingPayment = new AutoNumeric('#outstanding_payment', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 0
    });


    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('payment.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_student = $('#filter_student').val();
            }
        },
        order: [
            [0, 'desc']
        ],
        columns: [{
                data: 'id',
                name: 'id',
                orderable: true,
                visible: false
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'payment_date',
                name: 'payment_date'
            },
            {
                data: 'invoice',
                name: 'invoice'
            },

            {
                data: 'student_name',
                name: 'student_name'
            },
            {
                data: 'whatsapp',
                name: 'whatsapp'
            },
            {
                data: 'branch_id',
                name: 'branch_id'
            },
            {
                data: 'consultant_id',
                name: 'consultant_id'
            },
            {
                data: 'outstanding_amount',
                name: 'outstanding_amount'
            },
            {
                data: 'payment_amount',
                name: 'payment_amount'
            },
            {
                data: 'outstanding_payment',
                name: 'outstanding_payment'
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },


        ]
    });

    function addData() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Payment Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    

    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('payment') }}";
        else url = "{{ url('payment') . '/' }}" + id;

        var form = new FormData($('#modal-add form')[0]);
        let payment = Number(paymentAmount.getNumericString());
        let outAmount = Number(outstandingAmount.getNumericString());
        let outPayment = Number(outstandingPayment.getNumericString());
        form.append("payment_amount", payment);
        form.append("outstanding_amount", outAmount);
        form.append("outstanding_payment", outPayment);

        $.ajax({
            url: url,
            type: "POST",
            data: form,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success) {
                    $('#modal-add').modal('hide');
                    reloadTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        scrollbarPadding: false,
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = Object.values(errors).map(e => e[0]).join('<br>');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        html: msg
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + xhr.responseJSON?.message
                    });
                }
            },
            complete: function() {
                $('#btn-save-data').prop('disabled', false).text('Save');
            }

        });
    });

    function deleteData(id) {
        Swal.fire({
            title: 'Are sure?',
            text: "This data will be deleted permanently",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('payment') }}" + "/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        reloadTable();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON.message || 'Terjadi kesalahan.',
                            'error');
                    }
                });
            }
        });
    }

    function reloadTable() {
        table.ajax.reload(null, false);
    }

    function resetForm() {
        $('#form-add')[0].reset();
    }


    $("#customer_id").change(function() {
        var selectedId = $(this).val();
        $.ajax({
            url: "{{ url('select_student?id=') }}" + selectedId,
            type: "GET",
            success: function(data) {
                if (data.success) {
                    outstandingAmount.set(data.data.out_payment);
                    outstandingPayment.set(data.data.out_payment);
                } else {
                    Swal.fire('Warning!', data.message, 'error');
                        
                }

            }
        });
    });

    $('#payment_amount').on('keyup change', function() {

        let outstanding = Number(outstandingAmount.getNumericString());
        let payment = Number(paymentAmount.getNumericString());

        let sisa = outstanding - payment;

        if (sisa < 0) {
            sisa = 0;
        }

        outstandingPayment.set(sisa);

    });
</script>
