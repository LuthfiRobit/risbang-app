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
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columnDefs: [{
                targets: [0, 1, 2],
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
                url: '{{ route('setting.dosen.management.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            rowCallback: function(row, data, dataIndex) {
                // Get row ID
                if (data["aktif"] === "t") {
                    $("td", row).css("color", "#a1081f");
                } else if (data["aktif"] === "y") {
                    $("td", row).css("color", "#0b7a44");
                }

                const rowId = data['id_user'];
                // If row ID is in the list of selected row IDs
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            },
            columns: [{
                    data: "action",
                    render: function(data) {
                        let x_edit = "";
                        let x_detail = "";
                        x_detail = `<a
                                data-id="${data}"
                                title='Detail'
                                data-toggle="modal"
                                data-target="#form_detail"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                                <span class='bi bi-file-text ' aria-hidden='true'></span>
                            </a>`;
                        x_edit = `<a
                                data-id="${data}"
                                title='Edit'
                                data-toggle="modal"
                                data-target="#form_edit"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                                <span class='bi bi-pencil' aria-hidden='true'></span>
                            </a>`;
                        return `${x_detail} ${x_edit}`
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nama_dosen",
                    name: "nama_dosen"
                },
                {
                    data: "username",
                    name: "username"
                },
                {
                    data: "dosen_role",
                    name: "dosen_role",
                    render: function(data, type, row) {
                        if (row.dosen_role == 'dekan') {
                            bg = 'primary';
                            text = 'Dekan';
                        } else if (row.dosen_role == 'kaprodi') {
                            bg = 'warning';
                            text = 'Kaprodi';
                        } else {
                            bg = 'success';
                            text = 'Dosen';
                        }
                        return '<div class="badge badge-light-' + bg + ' fw-bold text-uppercase">' +
                            text +
                            '</div>';

                    }
                },
                {
                    data: "aktif",
                    name: "aktif",
                    render: function(data, type, row) {
                        if (row.aktif == 'y') {
                            bg = 'primary';
                            text = 'Aktif';
                        } else {
                            bg = 'danger';
                            text = 'Tidak Aktif';
                        }

                        return '<div class="badge badge-light-' + bg + ' fw-bold">' + text +
                            '</div>';

                    },
                    orderable: false,
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
