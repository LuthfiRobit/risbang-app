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
                url: '{{ route('laporan.penelitian.luaran.buku.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "action",
                    render: function(data, row) {
                        var url = '{{ route('laporan.penelitian.luaran.buku.edit', ':id') }}';
                        url = url.replace(':id', data);
                        return '<a class="btn btn-sm btn-light-primary" href="' + url +
                            '"><span class="bi bi-pencil" aria-hidden="true"></span> Detail</a>';;
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "penginput",
                    name: "penginput",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "ta",
                    name: "ta",
                    orderable: true,
                    searchable: false,
                },
                {
                    data: "tahun",
                    name: "tahun",
                    orderable: true,
                    searchable: false,
                },
                {
                    data: "penulis",
                    name: "penulis",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "judul",
                    name: "judul",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "publish",
                    name: "publish",
                    render: function(data, type, row) {
                        if (row.publish == 'y') {
                            bg = 'primary';
                            text = 'Publish';
                        } else {
                            bg = 'danger';
                            text = 'Tidak';
                        }
                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: false,
                    searchable: false,
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
    }
</script>
