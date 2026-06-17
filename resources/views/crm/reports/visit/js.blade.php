<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/visit_report/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/visit_report/export/pdf?' + params, '_blank');
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
            url: "{{ route('visit.report.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_branch = $('#filter_branch').val();
                d.filter_status = $('#filter_status').val();
                d.filter_consultant = $('#filter_consultant').val();
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
                data: 'date',
                name: 'date',
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
                data: 'location',
                name: 'location',
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
                data: 'images',
                name: 'images',
            },
            {
                data: 'note',
                name: 'note',
            },

            {
                data: 'created_by',
                name: 'created_by',
            },

        ]
    });


    function reloadTable() {
        table.ajax.reload(null, false);
    }
</script>
