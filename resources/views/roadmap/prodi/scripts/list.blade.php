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
            responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            ajax: {
                url: '{{ route('roadmap.prodi.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "action",
                    render: function(data) {
                        let x_edit = "";
                        let x_review = "";

                        @if (Auth::user()->dosen_role == 'kaprodi')
                            x_edit = `<a
                                data-id="${data}"
                                title='Edit'
                                data-toggle="modal"
                                data-target="#modal_edit"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm me-1'>
                                <span class='bi bi-pencil' aria-hidden='true'></span>
                            </a>`;
                            return `${x_edit}`
                        @endif
                        @if (Auth::user()->user_role == 'admin')
                            x_review = `<a
                                data-id="${data}"
                                title='Review'
                                data-toggle="modal"
                                data-target="#modal_review"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm me-1'>
                                <span class='bi bi-pencil ' aria-hidden='true'></span>
                            </a>`;
                            return `${x_review}`
                        @endif
                    },
                    orderable: true,
                    searchable: true,
                },

                @if (Auth::user()->dosen_role == 'kaprodi')
                    {
                        data: "tgl",
                        name: "tgl"
                    },
                @elseif (Auth::user()->user_role == 'admin')

                    {
                        data: "prodi",
                        name: "prodi"
                    }, {
                        data: "fakultas",
                        name: "fakultas"
                    },
                @endif

                {
                    data: "rentan_waktu",
                    name: "rentan_waktu"
                },
                {
                    data: "jenis",
                    name: "jenis"
                },
                {
                    data: "berkas",
                    render: function(data, row) {
                        const vieBerkas = `<a  href="${data}" target="_blank"  class="d-flex align-items-center text-primary text-hover-success m-3">
                            <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span> Lihat file
                            </a>`
                        return vieBerkas;
                    },
                },
                {
                    data: "status",
                    name: "status",
                    render: function(data, type, row) {
                        if (row.status == 'Pengajuan') {
                            bg = 'warning';
                        } else if (row.status == 'Revisi') {
                            bg = 'danger';
                        } else {
                            bg = 'success';
                        }
                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + row.status +
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
