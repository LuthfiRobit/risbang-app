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
                url: '{{ route('review.akhir.list.dosen', Route::current()->parameter('id')) }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: null,
                    render: function(data, type, row) {
                        var url = '{{ route('review.akhir.overview', ':id') }}';
                        url = url.replace(':id', data.id_tahun_akademik);
                        url += '?dosen=' + data.id_dosen;
                        return '<a class="btn btn-sm btn-light-primary" href="' + url + '">Review</a>';;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nama_dosen",
                    name: "nama_dosen"
                },
                {
                    data: "prodi",
                    name: "prodi",
                },
                {
                    data: "penelitian",
                    name: "penelitian",
                    render: function(data, type, row) {
                        if (row.penelitian == 'Diterima') {
                            bg = 'primary';
                            text = 'Diterima';
                        } else {
                            bg = 'danger';
                            text = 'Belum diterima';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "pengabdian",
                    name: "pengabdian",
                    render: function(data, type, row) {
                        if (row.pengabdian == 'Diterima') {
                            bg = 'primary';
                            text = 'Diterima';
                        } else {
                            bg = 'danger';
                            text = 'Belum diterima';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "keaslian_pene",
                    name: "keaslian_pene",
                    render: function(data, type, row) {
                        if (row.keaslian_pene == 'y') {
                            bg = 'primary';
                            text = '<i class="bi bi-check-circle"></i>';
                        } else {
                            bg = 'danger';
                            text = '<i class="bi bi-exclamation-circle"></i>';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                },
                {
                    data: "keaslian_peng",
                    name: "keaslian_peng",
                    render: function(data, type, row) {
                        if (row.keaslian_peng == 'y') {
                            bg = 'primary';
                            text = '<i class="bi bi-check-circle"></i>';
                        } else {
                            bg = 'danger';
                            text = '<i class="bi bi-exclamation-circle"></i>';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                },
                {
                    data: "status",
                    name: "status",
                    render: function(data, type, row) {
                        if (row.status == 'Diterima') {
                            bg = 'primary';
                            text = 'Diterima';
                        } else {
                            bg = 'danger';
                            text = 'Belum diterima';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: true,
                    searchable: true,
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
