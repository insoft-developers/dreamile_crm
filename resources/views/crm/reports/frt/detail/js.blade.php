<script>
    function exportExcel() {
        let agentId = window.location.pathname.split('/').pop();
        let params = $('#filterForm').serialize();
        params += '&agent_id=' + agentId;
        window.open('/frt_detail/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let agentId = window.location.pathname.split('/').pop();
        let params = $('#filterForm').serialize();
        params += '&agent_id=' + agentId;
        window.open('/frt_detail/export/pdf?' + params, '_blank');
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
            url: "{{ route('first.response.detail.table') }}",
            data: function(d) {
                d.detailId = window.location.pathname.split('/').pop();
                d.filter_start_date = $("#filter_start_date").val();
                d.filter_end_date = $("#filter_end_date").val();
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
                data: 'customer',
                name: 'customer',
            },
            {
                data: 'consultant',
                name: 'consultant',
            },
            {
                data: 'branch_name',
                name: 'branch_name',
            },
            {
                data: 'chat_masuk',
                name: 'chat_masuk',
            },
            {
                data: 'dibalas',
                name: 'dibalas',
            },
            {
                data: 'frt',
                name: 'frt',
            },


        ]
    });



    function reloadTable() {
        table.ajax.reload(null, false);
    }
</script>
