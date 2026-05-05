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
        $(".modal-title").text("Add Leads Data");
        resetForm();
        $("#modal-add").modal("show");
    }

    function editData(id) {
        loading("btn-save-data");
        save_method = "edit";
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('/lead') }}" + "/" + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-add').modal("show");
                $('.modal-title').text("Edit Leads Data");
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
        if (save_method == "add") url = "{{ url('lead') }}";
        else url = "{{ url('lead') . '/' }}" + id;
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

    function visitData(id) {
        fetch("{{ url('/get_visit_data') }}" + "/" + id)
            .then(res => res.json())
            .then(data => {

                $("#modal-visit").modal('show');
                $(".modal-title").text('Visit Detail Data');
                $("#visit_customer_id").val(id);
                $("#visit_date").val(data.data.visit_date);
                $("#visit_location").val(data.data.visit_location);
                $("#visit_status").val(data.data.visit_status);
                $("#visit_note").val(data.data.visit_note);

                $("#preview").html('');
                let prevImage = '';
                if (data.images.length > 0) {
                    data.images.forEach(item => {
                        prevImage +=
                            `<img style="Object-fit:cover;" src="{{ asset('storage') }}/${item.image}" width="100" height="100" class="rounded border border-success">`;
                    });

                    $("#preview").html(prevImage);
                }


            });


    }
</script>


<script>
    document.getElementById('photos').addEventListener('change', function(event) {
        let preview = document.getElementById('preview');
        preview.innerHTML = '';

        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();

            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.border = '2px solid green';
                img.classList.add('rounded');
                img.style.marginBottom = '12px';

                preview.appendChild(img);
            }

            reader.readAsDataURL(file);
        });
    });

    $("#form-visit").submit(function(e) {
        e.preventDefault();
        loading("btn-save-visit");
        $.ajax({
            url: "{{ route('visit.add') }}",
            type: "POST",
            data: new FormData($('#modal-visit form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success) {

                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        scrollbarPadding: false,
                    });
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
                $('#btn-save-visit').prop('disabled', false).text('Save');
            }

        });
    });

    function addFollowup() {
        $('#form-follow')[0].reset();
        const step = $("#followup-step").val();
        $("#step").val(step);
        $("#aksi").val("tambah");
        $(".modal-title").text(`Follow Up ${step}`);
        $("#modal-follow").modal('show');
        $("#modal-follow-list").modal('hide');
       
    }


    function followup_edit(id) {
        fetch("{{ url('/followup_edit') }}" + "/" + id)
            .then(res => res.json())
            .then(data => {
                console.log(data);

                $("#aksi").val("edit");
                $("#follow_id").val(data.id);
                $("#customer_follow_id").val(data.customer_id);
                $("#step").val(data.step);
                $("#followup_date").val(data.date);
                $("#followup_note").val(data.note);
                $("#followup_image").val(null);
                $("#modal-follow").modal("show");
                $("#modal-follow-list").modal('hide');
                $(".modal-title").text(`Edit Followup ${data.step}`);
            });
    }

    function followup_delete(id) {
        alert(id);
    }

    function followup(id) {
        $("#customer_follow_id").val(id);
        fetch("{{ url('/followup_data') }}" + "/" + id)
            .then(res => res.json())
            .then(data => {

                if (data.length == 0) {
                    $('#form-follow')[0].reset();
                    $(".modal-title").text('Follow Up 1');
                    $("#step").val(1);
                    $("#aksi").val("tambah");
                    $("#modal-follow").modal('show');
                } else {
                    $(".modal-title").text('Follow Lists');
                    initFollowupData(data);
                }

            });
    }

    function initFollowupData(data) {
        let tcontent = '';
        let angka = 1;
        data.forEach(item => {

            let gambar = '';
            if(item.image != null) {
                gambar += `<a href="{{ asset('storage') }}/${item.image}" target="_blank"><img class="lead-image" src="{{ asset('storage') }}/${item.image}"></a>`;
            } else {
                gambar += '-';
            }

            tcontent += `
                            <tr>
                                <td>${angka++}</td>
                                <td>Followup ${item.step}</td>
                                <td>${item.date}</td>
                                <td style="width:280px;"><span style="white-space:normal;">${item.note}</span></td>
                                <td>${gambar}</td>
                                <td><span onclick="followup_edit(${item.id})" class="text-edit">Edit</span></td>
                            </tr>`;
        });

        let ft = '';
        ft += `<table class="table table-stripped table-bordered table-nowrap">
                            <thead>
                                <th>No</th>
                                <th>Step</th>
                                <th>Date</th>
                                <th>Note</th>
                                <th>Image</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                ${tcontent}
                            </tbody>
                          </table>`;


        $("#table-follow-container").html(ft);
        $("#followup-list-id").val(id);
        let newStep = parseInt(data[0].step) + 1;
        $("#followup-step").val(newStep);
        $("#modal-follow-list").modal('show');
        if(newStep > 3) {
            $("#add-followup-btn").prop("disabled", true);
        } else {
             $("#add-followup-btn").prop("disabled", false);
        }
    }


    $("#form-follow").submit(function(e) {
        e.preventDefault();
        loading("btn-save-follow");
        const aksi = $("#aksi").val();
        let url;
        if(aksi == 'tambah') {
            url = "{{ route('follow.add') }}";
        } else {
            url = "{{ route('follow.update') }}";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData($('#modal-follow form')[0]),
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success) {
                    initFollowupData(data.data);
                    reloadTable();
                    $("#modal-follow").modal('hide');
                    $("#modal-follow-list").modal('show');
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        scrollbarPadding: false,
                    });
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
                $('#btn-save-follow').prop('disabled', false).text('Save');
            }

        });
    });
</script>
