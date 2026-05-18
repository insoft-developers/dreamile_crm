<script>
    function initContactSelect() {

        $('#contact_target').select2({
            width: '100%',
            dropdownParent: $('#modal-add .modal-content'),
            placeholder: 'Select Contacts',
            closeOnSelect: false
        });

    }

    function initGroupSelect() {

        $('#group_target').select2({
            width: '100%',
            dropdownParent: $('#modal-add .modal-content'),
            placeholder: 'Select Groups',
            closeOnSelect: false
        });

    }

    /*
    |--------------------------------------------------------------------------
    | FIRST LOAD
    |--------------------------------------------------------------------------
    */

    initContactSelect();

    /*
    |--------------------------------------------------------------------------
    | CHANGE TYPE
    |--------------------------------------------------------------------------
    */

    $('#contact_type').on('change', function() {

        let type = $(this).val();

        /*
        |--------------------------------------------------------------------------
        | CONTACT
        |--------------------------------------------------------------------------
        */

        if (type == 'contact') {

            /*
            |--------------------------------------------------------------------------
            | DESTROY GROUP
            |--------------------------------------------------------------------------
            */

            if ($('#group_target').hasClass("select2-hidden-accessible")) {
                $('#group_target').select2('destroy');
            }

            /*
            |--------------------------------------------------------------------------
            | SHOW HIDE
            |--------------------------------------------------------------------------
            */

            $('#contact-container').removeClass('d-none');

            $('#group-container').addClass('d-none');

            /*
            |--------------------------------------------------------------------------
            | INIT CONTACT
            |--------------------------------------------------------------------------
            */

            initContactSelect();

        }

        /*
        |--------------------------------------------------------------------------
        | GROUP
        |--------------------------------------------------------------------------
        */
        else if (type == 'group') {

            /*
            |--------------------------------------------------------------------------
            | DESTROY CONTACT
            |--------------------------------------------------------------------------
            */

            if ($('#contact_target').hasClass("select2-hidden-accessible")) {
                $('#contact_target').select2('destroy');
            }

            /*
            |--------------------------------------------------------------------------
            | SHOW HIDE
            |--------------------------------------------------------------------------
            */

            $('#contact-container').addClass('d-none');

            $('#group-container').removeClass('d-none');

            /*
            |--------------------------------------------------------------------------
            | INIT GROUP
            |--------------------------------------------------------------------------
            */

            initGroupSelect();

        }

    });


    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('broadcast.table') }}',
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
                data: 'name',
                name: 'name'
            },
            {
                data: 'recipients',
                name: 'recipients'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: 'sent',
                name: 'sent'
            },
            {
                data: 'failed',
                name: 'failed'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'progress',
                name: 'progress'
            },
            {
                data: 'branch_id',
                name: 'branch_id'
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
        $(".modal-title").text("Add New Broadcast");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/lead_source') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Lead Source Data");
                $('#id').val(data.id);
                $("#source_name").val(data.source_name);
                $("#slug").val(data.slug);

            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('broadcast') }}";
        else url = "{{ url('broadcast') . '/' }}" + id;
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
                    url: "{{ url('lead_source') }}" + "/" + id,
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

    $("#contact_type").change(function() {
        var contactType = $(this).val();

    });


    function startBroadcast(id) {
        $.post(
            "{{ url('broadcast/start') }}/" + id, {
                _token: '{{ csrf_token() }}'
            },
            function(response) {
                if (response.success) {
                    reloadTable();
                }
            }
        );
    }

    function retryBroadcast(id) {
        $.post(
            "{{ url('broadcast/retry') }}/" + id,
            {
                _token: '{{ csrf_token() }}'
            },
            function(response) {
                if (response.success) {
                   reloadTable();
                }
            }
        );
    }
</script>
