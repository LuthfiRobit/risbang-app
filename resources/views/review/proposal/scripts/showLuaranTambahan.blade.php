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
          luaranTambahan = $("#show_luaran_tambahan");
          let id = luaranTambahan.data("dr");
          var url = '{{ route('proposal.pengajuan.luaran.tambahan', ':id') }}';
          url = url.replace(':id', id);

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
                  url: url,
                  //   data: iddd,
                  cache: false,
              },
              order: [],
              ordering: true,
              //   rowCallback: function(row, data, dataIndex) {
              //       // Get row ID
              //       if (data["aktif"] === "t") {
              //           $("td", row).css("color", "#a1081f");
              //       } else if (data["aktif"] === "y") {
              //           $("td", row).css("color", "#0b7a44");
              //       }

              //       const rowId = data['id_proposal_luaran'];
              //       // If row ID is in the list of selected row IDs
              //       if ($.inArray(rowId, rows_selected) !== -1) {
              //           $(row).find('input[type="checkbox"]').prop('checked', true);
              //           $(row).addClass('selected');
              //       }
              //   },
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
                      data: null,
                      render: function(data, type, row) {
                          let x_review = "";
                          x_review = `<a
                                data-id="${data.action}"
                                data-dsn="${data.dosen_id}"
                                title='Review'
                                data-toggle="modal"
                                data-target="#review_luaran_buku"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-sm btn-light-primary'>
                                <span class='bi bi-pencil' aria-hidden='true'></span> Review
                            </a>`;
                          if (data.status_review == 'Diterima') {
                              return 'Selesai'
                          } else {
                              return `${x_review}`
                          }
                          //   return data.action
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
                  {
                      data: "status_review",
                      name: "status_review"
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
