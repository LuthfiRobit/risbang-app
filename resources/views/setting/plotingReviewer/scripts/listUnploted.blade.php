<script>
    load_data();
    const rows_selected = [];
    const btnStore = $('#btn_store');

    function load_data() {

        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#tabel_dosen_unploted').DataTable({
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
                url: '{{ route('setting.ploting.reviewer.list.unploted') }}',
                cache: false,
                data: function(d) {
                    d.ta = '{{ Request::query('ta') }}';
                    d.rv = '{{ Request::query('rv') }}';
                }
            },
            rowCallback: function(row, data, dataIndex) {
                // if (data["aktif"] === "t") {
                //     $("td", row).css("color", "#a1081f");
                // } else if (data["aktif"] === "y") {
                //     $("td", row).css("color", "#0b7a44");
                // }

                const rowId = data['id_dosen'];
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            },
            columns: [{
                    data: "cek",
                    render: function(data) {
                        return `<div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input widget-13-check bg-primary" type="checkbox" name="check[]"
                                    value="${data}" />
                            </div>`;
                    },
                    orderable: false,
                    searchable: false,
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

        $('#tabel_dosen_unploted_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });

        $('#tabel_dosen_unploted tbody').on('click', 'input[type="checkbox"]', function(e) {
            const $row = $(this).closest('tr');
            const data = table.row($row).data();
            const rowId = data['id_dosen'];
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
            console.log(index);
            updateDataTableSelectAllCtrl(table);
            e.stopPropagation();
        });

        // Handle click on table cells with checkboxes
        $('#tabel_dosen_unploted').on('click', 'tbody td, thead th:first-child', function(e) {
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });

        // Handle click on "Select all" control
        $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
            if (this.checked) {
                $('#tabel_dosen_unploted tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#tabel_dosen_unploted tbody input[type="checkbox"]:checked').trigger('click');
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
            btnStore.prop('disabled', true); // Disable button if no checkboxes are checked

            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length) {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = false;
            }
            btnStore.prop('disabled', false); // Enable button if checkboxes are checked

            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if ('indeterminate' in chkbox_select_all) {
                chkbox_select_all.indeterminate = true;
            }
            btnStore.prop('disabled', false); // Enable button if some checkboxes are checked
        }
    }
</script>
