<script>
    load_data();
    const rows_selected = [];

    function load_data() {

        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#table_anggota').DataTable({
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
                url: '{{ route('cms.profil.list.anggota') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "action",
                    render: function(data) {
                        return `
                            <a data-id="${data}" title="Edit" data-toggle="modal" data-target="#edit_anggota" aria-label="Close" data-dismiss="modal" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1">
                                <span class="bi bi-pencil" aria-hidden="true"></span>
                            </a>`;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var view = `<div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="#">
                                                <div class="symbol-label">
                                                    <img src="${data.profil}" alt="Emma Smith" class="w-100">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">${data.nama}</a>
                                        </div>
                                    </div>`;
                        return view;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "jabatan",
                    name: "jabatan",
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "urutan",
                    name: "urutan",
                    orderable: false,
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
