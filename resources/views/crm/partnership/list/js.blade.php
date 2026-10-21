<script>
    $(".select2").select2();
    getProvince();


    if ($(window).width() > 768) {
        $('#modal-add').on('shown.bs.modal', function() {
            $(this).find('.select2').select2({
                dropdownParent: $('#modal-add'),
                width: '100%'
            });
        });
    }

    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('partnership.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_jenis_partner = $('#filter_jenis_partner').val();
                d.filter_pic_dreamile = $('#filter_pic_dreamile').val();
                d.filter_provinsi = $('#filter_provinsi').val();
                d.filter_kota = $('#filter_kota').val();
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
                data: 'file',
                name: 'file'
            },
            {
                data: 'mou_file',
                name: 'mou_file'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'instance_name',
                name: 'instance_name'
            },
            {
                data: 'partner_type_id',
                name: 'partner_type_id'
            },
            {
                data: 'province_name',
                name: 'province_name'
            },
            {
                data: 'city_name',
                name: 'city_name'
            },
            {
                data: 'pic_name',
                name: 'pic_name'
            },
            {
                data: 'pic_title',
                name: 'pic_title'
            },
            {
                data: 'whatsapp',
                name: 'whatsapp'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'pic_dreamile',
                name: 'pic_dreamile'
            },
            {
                data: 'partnership_type_name',
                name: 'partnership_type_name'
            },
            {
                data: 'start_date',
                name: 'start_date'
            },
            {
                data: 'expired_date',
                name: 'expired_date'
            }
        ]
    });

    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/partnership/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/partnership/export/pdf?' + params, '_blank');
    }

    function filterData() {
        $('#list-table').DataTable().ajax.reload(null, false);
    }

    function resetFilter() {
        document.getElementById('filterForm').reset();
        $("#filter_jenis_partner").val("").trigger('change');
        4
        $("#filter_pic_dreamile").val("").trigger('change');
        $("#filter_provinsi").val("").trigger('change');
        $("#filter_kota").val("").trigger('change');
        $('#list-table').DataTable().ajax.reload(null, false);
    }


    function addData() {


        save_method = "add";

        $('input[name=_method]').val('POST');

        $(".modal-title").text("Add Partnership Data");

        resetForm();

        $("#modal-add").modal("show");
    }


    function editData(id) {

        save_method = "edit";

        $('input[name=_method]').val('PATCH');

        $.ajax({
            url: "{{ url('/partnership') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",

            success: function(data) {

                $('#modal-add').modal("show");

                $('.modal-title').text("Edit Partnership Data");

                $('#id').val(data.id);

                $('#partner_type_id').val(data.partner_type_id).trigger('change');

                $('#instance_name').val(data.instance_name);

                $('#province_id').val(data.province_id).trigger('change');

                getRegency(data.province_id, data.city_id);

                $('#address').val(data.address);

                $('#pic_name').val(data.pic_name);

                $('#pic_title').val(data.pic_title);

                $('#whatsapp').val(data.whatsapp);

                $('#email').val(data.email);

                $('#pic_dreamile').val(data.pic_dreamile);

                $('#partnership_type_name').val(data.partnership_type_name);

                $('#start_date').val(data.start_date);

                $('#expired_date').val(data.expired_date);

                $('#image').val(null);

                 $('#mou_file').val(null);
            }
        });
    }


    $("#form-add").submit(function(e) {

        e.preventDefault();

        loading("btn-save-data");

        var id = $('#id').val();

        if (save_method == "add") {
            url = "{{ url('partnership') }}";
        } else {
            url = "{{ url('partnership') }}" + "/" + id;
        }

        var provinceName = $('#province_id option:selected').text();
        var cityName = $('#city_id option:selected').text();
        var formData = new FormData($('#modal-add form')[0]);

        formData.append('province_name', provinceName);
        formData.append('city_name', cityName);

        $.ajax({

            url: url,

            type: "POST",

            data: formData,

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

                    let msg = Object.values(errors)
                        .map(e => e[0])
                        .join('<br>');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        html: msg
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' +
                            xhr.responseJSON?.message
                    });
                }
            },

            complete: function() {

                $('#btn-save-data')
                    .prop('disabled', false)
                    .text('Save');

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

                    url: "{{ url('partnership') }}" + "/" + id,

                    type: 'DELETE',

                    data: {
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {

                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        );

                        reloadTable();
                    },

                    error: function(xhr) {

                        Swal.fire(
                            'Gagal!',
                            xhr.responseJSON.message ||
                            'Terjadi kesalahan.',
                            'error'
                        );
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

        $('#id').val('');

        $('#partner_type_id').val('').trigger('change');

        $('#province_id').val('').trigger('change');

        $('#city_id').val('').trigger('change');
    }

    function getProvince() {
        fetch("{{ url('/api/province') }}")
            .then(res => res.json())
            .then(data => {
                const provinces = data.data;
                let select = document.getElementById('province_id');
                let selected = document.getElementById('filter_provinsi');

                let option = '';
                provinces.forEach(item => {

                    option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                    selected.innerHTML += option;
                });

                // console.log(data.data);
            });
    }

    $("#province_id").change(function() {
        var provinceCode = $(this).val();
        getRegency(provinceCode);
    })

    $("#filter_provinsi").change(function() {
        var provinceCode = $(this).val();
        getRegency(provinceCode);
    })

    function getRegency(provinceCode, selectedRegency = null) {
        if (!provinceCode) {
            $('#btn-save-data').prop('disabled', false).text('Save');
        }

        fetch("{{ url('/api/regency') }}" + '/' + provinceCode)
            .then(res => res.json())
            .then(data => {
                const regencies = data.data;
                let select = document.getElementById('city_id');
                let selected = document.getElementById('filter_kota');

                // 🔥 RESET DULU
                select.innerHTML = '<option value="">-- PIlih Kabupaten/Kota --</option>';

                selected.innerHTML = '<option value="">-- PIlih Kabupaten/Kota --</option>';

                regencies.forEach(item => {
                    let option = `<option value="${item.code}">${item.name}</option>`;
                    select.innerHTML += option;
                    selected.innerHTML += option;
                });

                if (selectedRegency) {

                    $('#city_id').val(selectedRegency).trigger('change');

                }

            });
    }
</script>