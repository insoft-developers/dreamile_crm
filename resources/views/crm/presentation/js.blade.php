<script>
    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("presentation.table") }}',
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
                data: 'image',
                name: 'image'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'location',
                name: 'location'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'consultant_id',
                name: 'consultant_id'
            },
            {
                data: 'audience',
                name: 'audience'
            },
            {
                data: 'tertarik',
                name: 'tertarik'
            },
            {
                data: 'sangat_tertarik',
                name: 'sangat_tertarik'
            },
            {
                data: 'kurang_tertarik',
                name: 'kurang_tertarik'
            },
            {
                data: 'lead',
                name: 'lead'
            },
            {
                data: 'deal',
                name: 'deal'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'branch_id',
                name: 'branch_id'
            },
            {
                data: 'userid',
                name: 'userid'
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
        $(".modal-title").text("Add Presentation Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/presentation') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Presentation Data");
                $('#id').val(data.id);
                $("#title").val(data.title);
                $("#location").val(data.location);
                $("#date").val(data.date);
                $("#consultant_id").val(data.consultant_id);
                $("#audience").val(data.audience);
                $("#kurang_tertarik").val(data.kurang_tertarik);
                $("#sangat_tertarik").val(data.sangat_tertarik);
                $("#tertarik").val(data.tertarik);
                $("#description").val(data.description);
                $("#branch_id").val(data.branch_id);
                $("#image").val(null);
               

            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('presentation') }}";
        else url = "{{ url('presentation') . '/' }}" + id;
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
                    url: "{{ url('presentation') }}" + "/" + id,
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
</script>
