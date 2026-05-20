<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/customer/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/customer/export/pdf?' + params, '_blank');
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
        ajax: {
            url: '{{ route('customer.table') }}',
            data: function(d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
                d.filter_status = $('#filter_status').val();
                d.filter_lead_source = $('#filter_lead_source').val();
                d.filter_consultant = $('#filter_consultant').val();
                d.filter_branch = $('#filter_branch').val();
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
                data: 'lead_source_id',
                name: 'lead_source_id'
            },
            {
                data: 'branch_id',
                name: 'branch_id'
            },

            {
                data: 'created_by',
                name: 'created_by'
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
        $(".modal-title").text("Add Customer Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        loading("btn-save-data");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/customer') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Customer Data");
                $('#id').val(data.id);
                $("#fullname").val(data.fullname);
                $("#full_address").val(data.full_address);
                $("#school_from").val(data.school_from);
                $("#class").val(data.class);
                $("#major").val(data.major);
                $("#phone_number").val(data.phone_number);
                $("#gender").val(data.gender);
                $("#photo").val(null);
                $("#email").val(data.email);
                $("#lead_source_id").val(data.lead_source_id);
                showEventChoice(data.lead_source_id, data.event_id);
                $("#status").val(data.status);
                $("#consultant_id").val(data.consultant_id);
                $("#note").val(data.note);
                $("#branch_id").val(data.branch_id);
                $("#province_code").val(data.province_code);
                getRegency(data.province_code, data.regency_code, data.district_code, data.village_code);



            }
        })
    }


    $("#form-add").submit(function(e) {
        e.preventDefault();
        loading("btn-save-data");
        var id = $('#id').val();
        if (save_method == "add") url = "{{ url('customer') }}";
        else url = "{{ url('customer') . '/' }}" + id;
        var formData = new FormData($('#modal-add form')[0]);
        var provinceName = $('#province_code option:selected').text();
        var regencyName = $('#regency_code option:selected').text();
        var districtName = $('#district_code option:selected').text();
        var villageName = $('#village_code option:selected').text();

        formData.append('province_name', provinceName);
        formData.append('regency_name', regencyName);
        formData.append('district_name', districtName);
        formData.append('village_name', villageName);

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
                    url: "{{ url('customer') }}" + "/" + id,
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
        $("#note").val("");
        $("#full_address").val("");
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

    function getRegency(provinceCode, selectedRegency = null, selectedDistrict = null, selectedVillage = null) {
        if (!provinceCode) {
            $('#btn-save-data').prop('disabled', false).text('Save');
        }

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

                if (selectedRegency) {

                    $('#regency_code').val(selectedRegency).trigger('change');
                    getDisctrict(selectedRegency, function() {
                        if (selectedDistrict) {

                            $('#district_code').val(selectedDistrict).trigger('change');

                            getVillage(selectedDistrict, function() {
                                if (selectedVillage) {
                                    $('#village_code').val(selectedVillage).trigger('change');
                                    $('#btn-save-data').prop('disabled', false).text('Save');
                                } else {
                                    $('#btn-save-data').prop('disabled', false).text('Save');
                                }
                            })
                        } else {
                            $('#btn-save-data').prop('disabled', false).text('Save');
                        }
                    });
                } else {
                    $('#btn-save-data').prop('disabled', false).text('Save');
                }

            });
    }


    function getDisctrict(regencyCode, callback = null) {
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

                if (callback) callback();

            });
    }


    function getVillage(districtCode, callback = null) {
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

                if (callback) callback();


            });
    }

    $("#lead_source_id").change(function() {
        const eventId = $(this).val();
        if (eventId === 'event') {
            fetch("{{ url('/api/event') }}")
                .then(res => res.json())
                .then(data => {
                    let optionData = '';
                    optionData += `<option value="">- Select -</option>`;
                    data.forEach(item => {
                        optionData +=
                            `<option value="${item.id}">${item.event_name} ( ${item.event_location} )</option>`;
                    });

                    let selectEvent = '';
                    selectEvent += `
                    <div class="card">
                        <div class="card-body">    
                            <div class="form-group mb-3">
                                <label for="event_id" class="form-label required">Select Event</label>
                                <select class="form-control" id="event_id" name="event_id">
                                    ${optionData}
                                </select>
                                <small>
                            Event not found? 
                            <a href="{{ url('event') }}">please add event data</a>
                        </small>  
                        </div>                        

                    </div>`;
                    $("#event-container").html(selectEvent);

                });


        } else {
            $("#event-container").html('');
        }
    })

    function showEventChoice(eventType, selectedEventId = null) {
        if (eventType === 'event') {
            fetch("{{ url('/api/event') }}")
                .then(res => res.json())
                .then(data => {

                    let optionData = `<option value="">- Select -</option>`;

                    data.forEach(item => {
                        optionData += `
                        <option value="${item.id}">
                            ${item.event_name} (${item.event_location})
                        </option>`;
                    });

                    let selectEvent = `
                <div class="card">
                    <div class="card-body">    
                        <div class="form-group mb-3">
                            <label for="event_id" class="form-label required">Select Event</label>
                            <select class="form-control" id="event_id" name="event_id">
                                ${optionData}
                            </select>
                        </div>
                        <small>
                            Event not found? 
                            <a href="{{ url('event') }}">please add event data</a>
                        </small>                        
                    </div>
                </div>`;

                    // inject ke DOM
                    $("#event-container").html(selectEvent);

                    // 🔥 SET VALUE SETELAH RENDER
                    if (selectedEventId) {
                        $('#event_id').val(selectedEventId).trigger('change');
                    }

                });
        } else {
            $("#event-container").html('');
        }
    }


    function convert(id) {
        Swal.fire({
            title: 'Are sure?',
            text: "This customer will be downgraded into lead",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Downgrade it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('downgrade') }}",
                    type: 'POST',
                    data: {
                        id: id,
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
</script>
