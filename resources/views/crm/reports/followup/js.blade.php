<script>
    function exportExcel() {
        let params = $('#filterForm').serialize();
        window.open('/followup_report/export/excel?' + params, '_blank');
    }

    function exportPDF() {
        let params = $('#filterForm').serialize();
        window.open('/followup_report/export/pdf?' + params, '_blank');
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
            url: "{{ route('followup.report.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_branch = $("#filter_branch").val();
                d.filter_consultant = $("#filter_consultant").val();
                d.filter_created_by = $("#filter_created_by").val();
               
            }
        },
        order: [
            [2, 'desc']
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
                data: 'consultant',
                name: 'consultant',
            },

            {
                data: 'step',
                name: 'step',
            },
            {
                data : 'branch',
                name : 'branch'
            },

            {
                data: 'note',
                name: 'note',
            },
            {
                data: 'image',
                name: 'image',
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
