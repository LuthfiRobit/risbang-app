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
                [10, 50, 100],
                [10, 50, 100]
            ],
            columnDefs: [{
                targets: [0],
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
                url: '{{ route('report.publikasi.luaran.produk.list') }}',
                cache: false,
                data: function(d) {
                    // console.log(d);
                    d.filter_ta = $('#filter_ta').val();
                    d.filter_fakultas = $('#filter_fakultas').val();
                    d.filter_prodi = $('#filter_prodi').val();
                    d.filter_jenis = $('#filter_jenis').val();
                    d.filter_kate = $('#filter_kate').val();
                }
            },
            columns: [{
                    data: "action",
                    render: function(data) {
                        let x_detail = `<a data-id="${data}" title='Detail' data-toggle="modal" data-target="#form_detail"
                            aria-label="Close" data-dismiss="modal" class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                            <span class='bi bi-file-text ' aria-hidden='true'></span>
                        </a>`;
                        return `${x_detail}`;
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "tahun_akademik",
                    name: "tahun_akademik",
                    orderable: true,
                    searchable: false,
                },
                {
                    data: "dosen",
                    name: "dosen",
                    orderable: false,
                },
                {
                    data: "judul",
                    name: "judul",
                    orderable: false,
                },
                {
                    data: "pelaksanaan",
                    name: "pelaksanaan",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "tkt",
                    name: "tkt",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "jenis",
                    name: "jenis",
                    render: function(data, type, row) {
                        let bg = (row.jenis == 'Penelitian') ? 'primary' : 'success';
                        return `<div class="badge badge-light-${bg} fw-bold">${row.jenis}</div>`;
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "publish",
                    name: "publish",
                    render: function(data, type, row) {
                        let bg = (row.publish == 'Terkonfirmasi') ? 'primary' : 'success';
                        return `<div class="badge badge-light-${bg} fw-bold">${row.publish}</div>`;
                    },
                    orderable: false,
                    searchable: false,
                },

            ],
        });

        $('#filter_ta, #filter_fakultas, #filter_prodi, #filter_jenis, #filter_kate').change(function() {
            table.draw();
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

        // Fetch tahun akademik data
        const tahunAkademikUrl =
            '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
        fetch(tahunAkademikUrl)
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    let data = response.data;
                    $("#filter_ta").append($("<option></option>")
                        .attr("value", "")
                        .text("Semua"));
                    $.each(data, function(key, item) {
                        $("#filter_ta").append($("<option></option>")
                            .attr("value", item.id_tahun_akademik)
                            .text(item.nama_tahun_akademik));
                    });
                    $("#filter_ta").selectpicker("refresh");
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });

        // Fetch fakultas data
        const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
        fetch(fakultasUrl)
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    let data = response.data;
                    $("#filter_fakultas").append($("<option></option>")
                        .attr("value", "")
                        .text("Semua"));
                    $.each(data, function(key, item) {
                        $("#filter_fakultas").append($("<option></option>")
                            .attr("value", item.id_fakultas)
                            .text(item.nama_fakultas));
                    });
                    $("#filter_fakultas").selectpicker("refresh");
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });

        // Event listeners for filters
        $("#filter_fakultas").on('change', function() {
            let fakultas = $(this).val();
            $("#filter_prodi").selectpicker('refresh');
            if (fakultas) {
                const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                    fakultas);
                fetch(prodiUrl)
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            var data = response.data;
                            $("#filter_prodi").empty();
                            $("#filter_prodi").append($("<option></option>")
                                .attr("value", "")
                                .text("Semua"));
                            $.each(data, function(key, item) {
                                $("#filter_prodi").append($('<option></option>').attr(
                                    'value', item.id_prodi).text(item.nama_prodi));
                            });
                            $("#filter_prodi").selectpicker('refresh');
                        } else {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            } else {
                $("#filter_prodi").empty();
                $("#filter_prodi").append($("<option></option>")
                    .attr("value", "")
                    .text("Semua"));
                $("#filter_prodi").selectpicker('refresh');
            }
        });

        @if (Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'dekan')
            const idF = '{{ Auth::user()->dekan->id_fakultas }}';
            const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                idF);
            fetch(prodiUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        var data = response.data;
                        $("#filter_prodi").empty();
                        $("#filter_prodi").append($("<option></option>")
                            .attr("value", "")
                            .text("Semua"));
                        $.each(data, function(key, item) {
                            $("#filter_prodi").append($('<option></option>').attr(
                                'value', item.id_prodi).text(item.nama_prodi));
                        });
                        $("#filter_prodi").selectpicker('refresh');
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        @endif
    }
</script>
