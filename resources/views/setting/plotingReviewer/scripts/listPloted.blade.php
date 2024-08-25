<script>
    load_data();

    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#tabel_dosen_ploted').DataTable({
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
                url: '{{ route('setting.ploting.reviewer.list.ploted') }}',
                cache: false,
                data: function(d) {
                    d.ta = '{{ Request::query('ta') }}';
                    d.rv = '{{ Request::query('rv') }}';
                }
            },
            columns: [{
                    data: "action",
                    render: function(data) {
                        let x_delete = "";
                        x_delete = `<a
                                    data-toggle='tooltip'
                                    data-placement='top'
                                    title='Delete'
                                    onclick='deleteConfirmation("${data}")'
                                    class='btn btn-icon btn-bg-danger btn-active-text-warning btn-sm m-1 delete-row-exist'>
                                    <span class='bi bi-trash ' aria-hidden='true'></span>
                                </a>`;
                        return `${x_delete}`
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "dosen",
                    name: "dosen"
                },
                {
                    data: "prodi",
                    name: "prodi"
                },
                {
                    data: "fakultas",
                    name: "fakultas"
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

        $('#tabel_dosen_ploted_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });
    }
</script>
