<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/frt/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/frt/export/pdf?' + params, '_blank');
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
            url: "{{ route('first.response.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_branch = $('#filter_branch').val();
                d.filter_consultant = $('#filter_consultant').val();
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
                data: 'consultant',
                name: 'consultant',
            },
            {
                data: 'branch_id',
                name: 'branch_id',
            },
            {
                data: 'total_chat',
                name: 'total_chat',
            },
            {
                data: 'avg_frt',
                name: 'avg_frt',
            },
            {
                data: 'fastest',
                name: 'fastest',
            },
            {
                data: 'slowest',
                name: 'slowest',
            },
            {
                data: 'action',
                name: 'action',
            }
        ]
    });

    

    function reloadTable() {
        table.ajax.reload(null, false);
    }

   
</script>
