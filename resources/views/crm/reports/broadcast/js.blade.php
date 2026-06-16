<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/broadcast_report/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/broadcast_report/export/pdf?' + params, '_blank');
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


    var table = $('#list-table').DataTable({
        language: {
            paginate: {
                previous: '&laquo;',
                next: '&raquo;'
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('broadcast.report.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_branch = $('#filter_branch').val();
                d.filter_status = $('#filter_status').val();
                d.filter_created_by = $('#filter_created_by').val();
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
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'name',
                name: 'name',
            },

            {
                data: 'message',
                name: 'message',
            },

            {
                data: 'template',
                name: 'template',
            },
            {
                data: 'total',
                name: 'total',
            },
            {
                data: 'sent',
                name: 'sent',
            },
            {
                data: 'failed',
                name: 'failed',
            },
            {
                data: 'percent_sent',
                name: 'percent_sent',
            },
            {
                data: 'percent_failed',
                name: 'percent_failed',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'branch_id',
                name: 'branch_id',
            },
            {
                data: 'user_id',
                name: 'user_id',
            },
            {
                data: 'action',
                name: 'action',
            },
            

            // <
            // th > ID < /th> <
            // th class = "text-center"
            // width = "5%" > No < /th> <
            // th > Date < /th> <
            // th > Broadcast Name < /th> <
            // th > Message < /th> <
            // th > Template < /th> <
            // th > Total < /th> <
            // th > Sent < /th> <
            // th > Failed < /th> <
            // th > Status < /th> <
            // th > Branch < /th> <
            // th > Created By < /th> <
            // th > Action < /th>


        ]
    });

    function addData() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add Event Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/event') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Event Data");
                $('#id').val(data.id);
                $("#event_name").val(data.event_name);
                $("#event_date").val(data.event_date);
                $("#image").val(null);
                $("#event_location").val(data.event_location);
                $("#branch_id").val(data.branch_id);

            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('event') }}";
        else url = "{{ url('event') . '/' }}" + id;
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
                    url: "{{ url('event') }}" + "/" + id,
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


    function activate(id, stat) {
        Swal.fire({
            title: 'Are sure?',
            text: stat == 1 ? "This account will be activated..?" : "This account will be disactivated..?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: stat == 1 ? 'Yes, Activate!' : 'Yes, Disactivate!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('user_activate') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        stat: stat,
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
