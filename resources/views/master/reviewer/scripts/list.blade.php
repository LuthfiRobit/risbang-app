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
                url: '{{ route('master.reviewer.list') }}',
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

                const rowId = data['id_reviewer'];
                // If row ID is in the list of selected row IDs
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            },
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
                    data: "cek",
                    render: function(data) {
                        let x = '';
                        x = `<div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input widget-13-check bg-primary" type="checkbox" name="check[]"
                                    value="${data}" />
                            </div>`
                        return x;
                    },
                    orderable: false,
                },
                {
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
                    data: "nama_reviewer",
                    name: "nama_reviewer"
                },
                {
                    data: "username",
                    name: "username"
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

        $('#example tbody').on('click', 'input[type="checkbox"]', function(e) {
            const $row = $(this).closest('tr');
            const data = table.row($row).data();
            const rowId = data['id_reviewer'];
            const index = $.inArray(rowId, rows_selected);
            if (this.checked && index === -1) {
                rows_selected.push(rowId);
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }

            if (this.checked) {
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }
            updateDataTableSelectAllCtrl(table);
            e.stopPropagation();
        });

        // Handle click on table cells with checkboxes
        $('#example').on('click', 'tbody td, thead th:first-child', function(e) {
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });

        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
            if (this.checked) {
                $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#example tbody input[type="checkbox"]:checked').trigger('click');
            }

            // Prevent click event from propagating to parent
            e.stopPropagation();
        });
        table.on('draw', function() {
            updateDataTableSelectAllCtrl(table);
        });

    }

    function updateDataTableSelectAllCtrl(table) {
        const $table = table.table().node();
        const $chkbox_all = $('tbody input[type="checkbox"]', $table);
        const $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
        const chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

        // If none of the checkboxes are checked
        if ($chkbox_checked.length === 0) {
            chkbox_select_all.checked = false;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }

            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }

            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
            }
        }
    }
</script>
