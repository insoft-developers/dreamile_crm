<script>
    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('company.table') }}',
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
                data: 'company_name',
                name: 'company_name'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
            },
            {
                data: 'email',
                name: 'email'
            },

            {
                data: 'pic',
                name: 'pic'
            },
            
            {
                data: 'updated_at',
                name: 'updated_at'
            },
            

        ]
    });


    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/company') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Company Data");
                $('#id').val(data.id);
                $("#company_name").val(data.company_name);
                $("#address").val(data.address);
                $("#phone_number").val(data.phone_number);
                $("#email").val(data.email);
                $("#pic").val(data.pic);
                
            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('company') }}";
        else url = "{{ url('company') . '/' }}" + id;
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-add form')[0]),
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

    function reloadTable() {
        table.ajax.reload(null, false);
    }

    function resetForm() {
        $('#form-add')[0].reset();
    }

    
</script>
