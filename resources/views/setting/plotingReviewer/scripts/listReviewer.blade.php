<script>
    load_data();
    const rows_selected = [];

    function load_data() {

        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: "lBfrtip",
            stateSave: true,
            stateDuration: -1,
            lengthmenu: [
                [10, 50, 100],
                [10, 50, 100]
            ],
            columnDefs: [{
                targets: [0, 1, ],
                className: 'noVis'
            }],
            buttons: [{
                    extend: 'colvis',
                    collectionLayout: 'fixed columns',
                    collectionTitle: 'Column visibility control',
                    className: 'btn btn-sm btn-primary rounded',
                    columns: ':not(.noVis)'
                },
                {
                    extend: "csv",
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-primary rounded',
                },
                {
                    extend: "excel",
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-primary rounded',
                },
            ],
            language: {
                processing: '<p >Please wait...</p>'
            },
            processing: true,
            serverSide: true,
            // responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            scrollX: true, // Add this line for horizontal scrolling
            ajax: {
                url: '{{ route('setting.ploting.reviewer.list.reviewer') }}',
                cache: false,
                data: function(d) {
                    d.ta = '{{ Request::query('ta') }}';
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        var url = '{{ route('setting.ploting.reviewer.create') }}';
                        url += '?ta=' + '{{ Request::query('ta') }}' + '&rv=' + data.action;
                        return '<a class="btn btn-sm btn-light-primary" href="' + url +
                            '"><span class="bi bi-eye" aria-hidden="true"></span> Detail</a>';;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "reviewer",
                    name: "reviewer"
                },
                {
                    data: "dosen",
                    name: "dosen"
                }
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
