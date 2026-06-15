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
            url: "{{ route('chat.detail.table') }}",
            data: function(d) {
                d.filter_start_date = $('#filter_start_date').val();
                d.filter_end_date = $('#filter_end_date').val();
                d.filter_id = window.location.pathname.split('/').pop();
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
                data: 'sender',
                name: 'sender',
            },
            {
                data: 'chat_content',
                name: 'chat_content',
            },
            
            {
                data: 'status',
                name: 'status',
            },
            
        ]
    });

    

    function reloadTable() {
        table.ajax.reload(null, false);
    }

   
</script>
