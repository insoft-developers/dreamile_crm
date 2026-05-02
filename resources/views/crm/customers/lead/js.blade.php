<script>
    getProvince();


    $('#modal-add').on('shown.bs.modal', function() {
        $(this).find('.select2').select2({
            dropdownParent: $('#modal-add'),
            width: '100%'
        });
    });

    $("#province_code").change(function() {
        var provinceCode = $(this).val();
        getRegency(provinceCode);
        $("#district_code").val(null).trigger('change');
        $("#village_code").val(null).trigger('change');
    })

    $("#regency_code").change(function() {
        var regencyCode = $(this).val();
        getDisctrict(regencyCode);
        $("#village_code").val(null).trigger('change');
    })

    $("#district_code").change(function() {
        var districtCode = $(this).val();
        getVillage(districtCode);
    })

    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('lead.table') }}',
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
                data: 'photo',
                name: 'photo'
            },
            {
                data: 'fullname',
                name: 'fullname'
            },
            {
                data: 'school_from',
                name: 'school_from'
            },
            {
                data: 'class',
                name: 'class'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'consultant_id',
                name: 'consultant_id'
            },
            {
                data: 'branch_id',
                name: 'branch_id'
            },

            {
                data: 'updated_at',
                name: 'updated_at'
            },


        ]
    });

    function addData() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $(".modal-title").text("Add User Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/user') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit User Data");
                $('#id').val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#password").val("");
                $("#branch_id").val(data.branch_id);
                $("#level").val(data.level);
                $("#position").val(data.position);

            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('user') }}";
        else url = "{{ url('user') . '/' }}" + id;
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
                    url: "{{ url('user') }}" + "/" + id,
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


    function getProvince() {
        fetch("{{ url('/api/province') }}")
            .then(res => res.json())
            .then(data => {
                const provinces = data.data;
                let select = document.getElementById('province_code');

                provinces.forEach(item => {
                    let option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                });

                // console.log(data.data);
            });
    }


    function getProvince() {
        fetch("{{ url('/api/province') }}")
            .then(res => res.json())
            .then(data => {
                const provinces = data.data;
                let select = document.getElementById('province_code');

                let option = '';
                provinces.forEach(item => {

                    option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                });

                // console.log(data.data);
            });
    }

    function getRegency(provinceCode) {
        fetch("{{ url('/api/regency') }}" + '/' + provinceCode)
            .then(res => res.json())
            .then(data => {
                const regencies = data.data;
                let select = document.getElementById('regency_code');

                // 🔥 RESET DULU
                select.innerHTML = '<option value="">- Select Regency-</option>';

                regencies.forEach(item => {
                    let option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                });

                // console.log(data.data);
            });
    }


    function getDisctrict(regencyCode) {
        fetch("{{ url('/api/district') }}" + '/' + regencyCode)
            .then(res => res.json())
            .then(data => {
                const districts = data.data;
                let select = document.getElementById('district_code');

                // 🔥 RESET DULU
                select.innerHTML = '<option value="">- Select District-</option>';

                districts.forEach(item => {
                    let option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                });

                // console.log(data.data);
            });
    }


    function getVillage(districtCode) {
        fetch("{{ url('/api/village') }}" + '/' + districtCode)
            .then(res => res.json())
            .then(data => {
                const villages = data.data;
                let select = document.getElementById('village_code');

                // 🔥 RESET DULU
                select.innerHTML = '<option value="">- Select Village-</option>';

                villages.forEach(item => {
                    let option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                });

                // console.log(data.data);
            });
    }
</script>
