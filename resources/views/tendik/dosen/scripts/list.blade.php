<script>
    $(document).ready(function() {
        const rows_selected = [];

        function load_data() {
            $.fn.dataTable.ext.errMode = 'none';

            const table = $('#example').DataTable({
                dom: "lBfrtip",
                stateSave: true,
                stateDuration: -1,
                lengthMenu: [
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
                    processing: '<p>Please wait...</p>'
                },
                processing: true,
                serverSide: true,
                searchHighlight: true,
                scroller: {
                    loadingIndicator: true
                },
                deferRender: true,
                destroy: true,
                scrollX: true,
                ajax: {
                    url: '{{ route('tendik.dosen.list') }}',
                    cache: false,
                    data: function(d) {
                        d.filter_fakultas = $('#filter_fakultas').val();
                        d.filter_prodi = $('#filter_prodi').val();
                    }
                },
                rowCallback: function(row, data) {
                    if (data.aktif === "t") {
                        $("td", row).css("color", "#a1081f");
                    } else if (data.aktif === "y") {
                        $("td", row).css("color", "#0b7a44");
                    }

                    const rowId = data.id_dosen;
                    if ($.inArray(rowId, rows_selected) !== -1) {
                        $(row).find('input[type="checkbox"]').prop('checked', true);
                        $(row).addClass('selected');
                    }
                },
                columns: [{
                        data: "cek",
                        render: function(data) {
                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input widget-13-check bg-primary" type="checkbox" name="check[]" value="${data}" />
                            </div>`;
                        },
                        orderable: false,
                    },
                    {
                        data: "action",
                        render: function(data) {
                            return `
                            <a data-id="${data}" title="Detail" data-toggle="modal" data-target="#form_detail" aria-label="Close" data-dismiss="modal" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1">
                                <span class="bi bi-file-text" aria-hidden="true"></span>
                            </a>
                            <a data-id="${data}" title="Edit" data-toggle="modal" data-target="#form_edit" aria-label="Close" data-dismiss="modal" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1">
                                <span class="bi bi-pencil" aria-hidden="true"></span>
                            </a>`;
                        },
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: "nama_fakultas",
                        name: "nama_fakultas"
                    },
                    {
                        data: "nama_prodi",
                        name: "nama_prodi"
                    },
                    {
                        data: "nidn",
                        name: "nidn"
                    },
                    {
                        data: "nama_dosen",
                        name: "nama_dosen"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "username",
                        name: "username"
                    },
                ],
            });

            $('#example_filter input').unbind().on('input', _.debounce(function() {
                const query = $(this).val();
                if (query.length >= 4 || query.length === 0) {
                    table.search(query).draw();
                }
            }, 500));

            $('#example tbody').on('click', 'input[type="checkbox"]', function(e) {
                const $row = $(this).closest('tr');
                const data = table.row($row).data();
                const rowId = data.id_dosen;
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

            $('#example').on('click', 'tbody td, thead th:first-child', function() {
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            $('thead input[name="select_all"]', table.table().container()).on('click', function(e) {
                if (this.checked) {
                    $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
                } else {
                    $('#example tbody input[type="checkbox"]:checked').trigger('click');
                }
                e.stopPropagation();
            });

            table.on('draw', function() {
                updateDataTableSelectAllCtrl(table);
            });

            $('#filter_fakultas').on('change', function() {
                const id = $(this).val();
                $('#filter_prodi').empty().append('<option value="">Semua</option>').selectpicker(
                    'refresh');

                if (id === '') {
                    table.draw();
                    return;
                }

                const get = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
                $.ajax({
                    url: get.replace(':id', id),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(key, item) {
                                $('#filter_prodi').append($('<option></option>')
                                    .attr('value', item.id_prodi).text(item
                                        .nama_prodi));
                            });
                            $('#filter_prodi').selectpicker('refresh');
                        }
                        table.draw();
                    },
                    error: function() {
                        table.draw();
                    }
                });
            });

            $('#filter_prodi').change(function() {
                table.draw();
            });
        }

        function updateDataTableSelectAllCtrl(table) {
            const $table = table.table().node();
            const $chkbox_all = $('tbody input[type="checkbox"]', $table);
            const $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
            const chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

            if ($chkbox_checked.length === 0) {
                chkbox_select_all.checked = false;
                chkbox_select_all.indeterminate = false;
            } else if ($chkbox_checked.length === $chkbox_all.length) {
                chkbox_select_all.checked = true;
                chkbox_select_all.indeterminate = false;
            } else {
                chkbox_select_all.checked = true;
                chkbox_select_all.indeterminate = true;
            }
        }

        load_data();
    });
</script>
