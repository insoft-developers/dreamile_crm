<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/chat/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/chat/export/pdf?' + params, '_blank');
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
            url: "{{ route('chat.report.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_customer = $('#filter_customer').val();
                d.filter_consultant = $('#filter_consultant').val();
                d.filter_branch = $("#filter_branch").val();
                d.filter_status = $("#filter_status").val();
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
                data: 'customer',
                name: 'customer',
            },
            {
                data: 'phone',
                name: 'phone',
            },
            {
                data: 'consultant',
                name: 'consultant',
            },
            {
                data: 'branch',
                name: 'branch',
            },
            {
                data: 'status',
                name: 'status',
            },
            {
                data: 'last_message_at',
                name: 'last_message_at',
            },
            {
                data: 'assign_at',
                name: 'assign_at',
            },
            {
                data: 'action',
                name: 'action',
            },
        ]
    });

    

    function reloadTable() {
        table.ajax.reload(null, false);
    }

   
</script>
