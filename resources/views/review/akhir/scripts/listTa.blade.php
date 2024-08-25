<script>
    load_data();
    const rows_selected = [];

    function load_data() {

        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            stateSave: true,
            stateDuration: -1,
            lengthmenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'noVis'
            }],
            language: {
                processing: '<p >Please wait...</p>'
            },
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            ajax: {
                url: '{{ route('review.akhir.list.ta') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "DT_RowIndex",
                    render: function(data) {
                        if (data != null) {
                            return "";
                        }
                        return data;
                    },
                    orderable: false,
                },
                {
                    data: "action",
                    render: function(data, row) {
                        var url = '{{ route('review.akhir.index.dosen', ':id') }}';
                        url = url.replace(':id', data);
                        return '<a class="btn btn-sm btn-light-primary" href="' + url +
                            '"><span class="bi bi-search" aria-hidden="true"></span> Detail</a>';;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nama",
                    name: "nama"
                },
                {
                    data: "jumlah_dosen",
                    name: "jumlah_dosen",
                },
            ],
        });

        const performOptimizedSearch = _.debounce(function(query) {
            try {
                if (query.length >= 4 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error("Error during search:", error);
            }
        }, 500);

        $('#example_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });
    }
</script>
