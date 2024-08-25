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
                url: '{{ route('proposal.luaran.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "action",
                    render: function(data, row) {
                        var url = '{{ route('proposal.luaran.overview', ':id') }}';
                        url = url.replace(':id', data);
                        url += '?dosen=' + $('#dsn_id').val();
                        return '<a class="btn btn-sm btn-light-primary" href="' + url +
                            '"><span class="bi bi-pencil" aria-hidden="true"></span> Ajukan Proposal</a>';;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nama",
                    name: "nama"
                },
                {
                    data: "keterangan",
                    name: "keterangan"
                },
                {
                    data: "tgl_mulai",
                    name: "tgl_mulai"
                },
                {
                    data: "tgl_akhir",
                    name: "tgl_akhir"
                },
                {
                    data: "aktif",
                    name: "aktif",
                    render: function(data, type, row) {
                        if (row.aktif == 'Dibuka') {
                            bg = 'primary';
                            text = 'Dibuka';
                        } else {
                            bg = 'danger';
                            text = 'Ditutup / Selesai';
                        }
                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: true,
                    searchable: true,
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
