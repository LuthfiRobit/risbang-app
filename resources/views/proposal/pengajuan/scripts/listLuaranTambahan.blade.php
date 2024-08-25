  <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/lodash.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/dataTables.colReorder.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.js') }}"></script>
  <script>
      load_data();
      const rows_selected = [];

      function load_data() {
          $.fn.dataTable.ext.errMode = 'none';
          const table = $('#example_luaran_buku').DataTable({
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
                  url: '{{ route('proposal.pengajuan.luaran.tambahan', Route::current()->parameter('id')) }}',
                  //   data: iddd,
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

                  const rowId = data['id_proposal_luaran'];
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
                      render: function(data) {
                          let x_edit = "";
                          let x_delete = "";
                          x_edit = `<a
                                data-id="${data}"
                                title='Edit'
                                data-toggle="modal"
                                data-target="#edit_luaran_buku"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                                <span class='bi bi-pencil' aria-hidden='true'></span>
                            </a>`;
                          x_delete = `<a
                                    data-toggle='tooltip'
                                    data-placement='top'
                                    title='Delete'
                                    onclick='deleteConfirmation("${data}")'
                                    class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm me-1'>
                                    <span class='bi bi-trash ' aria-hidden='true'></span>
                                </a>`;
                          return `${x_edit} ${x_delete}`
                      },
                      orderable: true,
                      searchable: true,
                  },
                  {
                      data: "judul",
                      name: "judul"
                  },
                  {
                      data: "jenis_buku",
                      name: "jenis_buku"
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
