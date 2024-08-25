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
                url: '{{ route('review.proposal.list') }}',
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

                const rowId = data['id_tahun_akademik'];
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
                    data: "action",
                    render: function(data, row) {
                        var url = '{{ route('review.proposal.index.review', ':id') }}';
                        url = url.replace(':id', data);
                        return '<a class="btn btn-sm btn-light-primary" href="' + url +
                            '"><span class="bi bi-search" aria-hidden="true"></span> Detail</a>';;
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nama",
                    name: "nama"
                },
                {
                    data: "jumlah_dosen",
                    name: "jumlah_dosen",
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
            const rowId = data['id_proposal_luaran'];
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
    }
</script>
