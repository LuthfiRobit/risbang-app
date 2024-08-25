@extends('layout.main4')
@section('title-one', 'Dashboard')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    <link href="{{ asset('assets2/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-xxl">

        <div class="card mb-xl-5 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3">Dashboard</span>
                </h3>
            </div>
        </div>
        {{-- <div class="notice d-flex bg-light-danger border-danger mb-5 rounded border border-dashed p-3">
            <div class="d-flex flex-stack">
                <div class="row">
                    <span class="fs-12 text-gray-700">Berikut ini adalah.
                    </span>
                    <div class="row">
                        <span style="color: #a1081f; font-weight: 500;">Data </span>
                        <span style="color: #0b7a44 ; font-weight: 500;">Data </span>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row g-5 g-xl-8">
            <div class="col-xl-4">
                <a href="#" class="card bg-light-primary hoverable border border-primary card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-5x text-primary"></i>
                        <div class="text-primary fw-bolder fs-2 mb-2 mt-5">Dosen</div>
                        {{-- <div class="fw-bold text-primary">230 dosen</div> --}}
                    </div>
                </a>
            </div>
            <div class="col-xl-4">
                <a href="#" class="card bg-light-danger hoverable border border-danger card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark-fill fs-5x text-danger"></i>
                        <div class="text-danger fw-bolder fs-2 mb-2 mt-5">Penelitian</div>
                        {{-- <div class="fw-bold text-danger">10 penelitian</div> --}}
                    </div>
                </a>
            </div>
            <div class="col-xl-4">
                <a href="#"
                    class="card bg-light-warning hoverable border border-warning card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <i class="bi bi-journal-album fs-5x text-warning"></i>
                        <div class="text-warning fw-bolder fs-2 mb-2 mt-5">Pengabdian</div>
                        {{-- <div class="fw-bold text-warning">30 pengabdian</div> --}}
                    </div>
                </a>
            </div>
        </div>
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <div class="col-xl-6">
                <div class="card mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1">Grafik penelitian dan pengabdian</span>
                            <span class="text-muted fw-bold fs-7">Setiap tahun akademik</span>
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="">
                                <div class="px-7 py-5">
                                    <div class="fs-8 text-dark fw-bolder">
                                        Filter Options
                                    </div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm" name="arsip_filter_ta"
                                                id="arsip_filter_ta" data-live-search="true" data-size="5"
                                                title="Filter Tahun Akademik">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_filter_fak" id="arsip_filter_fak" data-live-search="true"
                                                data-size="5" title="Filter Fakultas">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_filter_pro" id="arsip_filter_pro" data-live-search="true"
                                                data-size="5" title="Filter Prodi">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="c_arsip_1" style="height: 250px"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1"> Grafik proposal penelitian dan pengabdian</span>
                            <span class="text-muted fw-bold fs-7">Setiap tahun akademik</span>
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="">
                                <div class="px-7 py-5">
                                    <div class="fs-8 text-dark fw-bolder">
                                        Filter Options
                                    </div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm" name="prop_filter_st"
                                                id="prop_filter_st" data-live-search="true" data-size="5"
                                                title="Filter Status">
                                                <option value="">All</option>
                                                <option value="Diterima">Diterima</option>
                                                <option value="Direvisi">Direvisi</option>
                                                <option value="Ditolak">Ditolak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="prop_filter_ta" id="prop_filter_ta" data-live-search="true"
                                                data-size="5" title="Filter Tahun Akademik">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="prop_filter_fak" id="prop_filter_fak" data-live-search="true"
                                                data-size="5" title="Filter Fakultas">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="prop_filter_pro" id="prop_filter_pro" data-live-search="true"
                                                data-size="5" title="Filter Prodi">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="c_proposal_1" style="height: 250px"></div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <div class="col-xl-6">
                <div class="card mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1">Grafik luaran buku penelitian dan
                                pengabdian</span>
                            <span class="text-muted fw-bold fs-7">Setiap tahun akademik</span>
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="">
                                <div class="px-7 py-5">
                                    <div class="fs-8 text-dark fw-bolder">
                                        Filter Options
                                    </div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_buku_filter_ta" id="arsip_buku_filter_ta"
                                                data-live-search="true" data-size="5" title="Filter Tahun Akademik">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_buku_filter_fak" id="arsip_buku_filter_fak"
                                                data-live-search="true" data-size="5" title="Filter Fakultas">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_buku_filter_pro" id="arsip_buku_filter_pro"
                                                data-live-search="true" data-size="5" title="Filter Prodi">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="c_arsip_buku" style="height: 250px"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1">Grafik luaran haki penelitian dan
                                pengabdian</span>
                            <span class="text-muted fw-bold fs-7">Setiap tahun akademik</span>
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="">
                                <div class="px-7 py-5">
                                    <div class="fs-8 text-dark fw-bolder">
                                        Filter Options
                                    </div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_haki_filter_ta" id="arsip_haki_filter_ta"
                                                data-live-search="true" data-size="5" title="Filter Tahun Akademik">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_haki_filter_fak" id="arsip_haki_filter_fak"
                                                data-live-search="true" data-size="5" title="Filter Fakultas">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_haki_filter_pro" id="arsip_haki_filter_pro"
                                                data-live-search="true" data-size="5" title="Filter Prodi">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="c_arsip_haki" style="height: 250px"></div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
            <div class="col-xl-12">
                <div class="card mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1">Grafik luaran jurnal penelitian dan
                                pengabdian</span>
                            <span class="text-muted fw-bold fs-7">Setiap tahun akademik</span>
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                </span>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="">
                                <div class="px-7 py-5">
                                    <div class="fs-8 text-dark fw-bolder">
                                        Filter Options
                                    </div>
                                </div>
                                <div class="separator border-gray-200"></div>
                                <div class="px-7 py-5">
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_jurnal_filter_ta" id="arsip_jurnal_filter_ta"
                                                data-live-search="true" data-size="5" title="Filter Tahun Akademik">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_jurnal_filter_fak" id="arsip_jurnal_filter_fak"
                                                data-live-search="true" data-size="5" title="Filter Fakultas">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="arsip_jurnal_filter_pro" id="arsip_jurnal_filter_pro"
                                                data-live-search="true" data-size="5" title="Filter Prodi">
                                                {{-- <option value="">All</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="c_arsip_jurnal" style="height: 250px"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
@endsection

@section('script-for-this-page')

    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>

    <!--begin::Page Vendors Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets2/plugins/custom/prismjs/prismjs.bundle.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets2/js/scripts.bundle.js') }}"></script> --}}

    {{-- <script src="https://cdn.amcharts.com/lib/4/core.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/charts.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/plugins/timeline.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/plugins/bullets.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/themes/frozen.js"></script> --}}
    {{-- <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script> --}}
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets2/js/custom/documentation/documentation.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets2/js/custom/documentation/search.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets2/js/custom/documentation/charts/amcharts/charts.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->

    <script>
        $(document).ready(function() {
            var element = document.getElementById('c_arsip_1');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-primary');
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

            var chart;

            function updateChart(data) {
                var options = {
                    series: [{
                        name: 'Penelitian',
                        data: data.penelitian
                    }, {
                        name: 'Pengabdian',
                        data: data.pengabdian
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.tahun_akademik,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' record'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(element, options);
                    chart.render();
                }
            }

            function fetchData(tahunAkademik, fakultas, prodi) {
                let url = "{{ route('report.publikasi.by.ta') }}";
                if (fakultas) url += `?fakultas=${fakultas}`;
                if (tahunAkademik) url += (url.includes('?') ? '&' : '?') + `tahun_akademik=${tahunAkademik}`;
                if (prodi) url += (url.includes('?') ? '&' : '?') + `prodi=${prodi}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => updateChart(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial fetch without filters
            fetchData();

            // Fetch fakultas data
            const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
            fetch(fakultasUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_filter_fak").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_filter_fak").append($("<option></option>")
                                .attr("value", item.id_fakultas)
                                .text(item.nama_fakultas));
                        });
                        $("#arsip_filter_fak").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            // Fetch tahun akademik data
            const tahunAkademikUrl =
                '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
            fetch(tahunAkademikUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_filter_ta").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_filter_ta").append($("<option></option>")
                                .attr("value", item.id_tahun_akademik)
                                .text(item.nama_tahun_akademik));
                        });
                        $("#arsip_filter_ta").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            $("#arsip_filter_ta").on('change', function() {
                fetchData($(this).val(), $("#arsip_filter_fak").val(), $("#arsip_filter_pro").val());
            });

            // Event listeners for filters
            $("#arsip_filter_fak").on('change', function() {
                let fakultas = $(this).val();
                $("#arsip_filter_pro").selectpicker('refresh');
                if (fakultas) {
                    const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                        fakultas);
                    fetch(prodiUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                var data = response.data;
                                $("#arsip_filter_pro").empty();
                                $("#arsip_filter_pro").append($("<option></option>")
                                    .attr("value", "")
                                    .text("All"));
                                $.each(data, function(key, item) {
                                    $("#arsip_filter_pro").append($('<option></option>').attr(
                                        'value', item.id_prodi).text(item.nama_prodi));
                                });
                                $("#arsip_filter_pro").selectpicker('refresh');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    $("#arsip_filter_pro").empty();
                    $("#arsip_filter_pro").append($("<option></option>")
                        .attr("value", "")
                        .text("All"));
                    $("#arsip_filter_pro").selectpicker('refresh');
                }
                fetchData($("#arsip_filter_ta").val(), fakultas, $("#arsip_filter_pro").val());
            });

            $("#arsip_filter_pro").on('change', function() {
                fetchData($("#arsip_filter_ta").val(), $("#arsip_filter_fak").val(), $(this).val());
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var element = document.getElementById('c_proposal_1');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-warning');
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

            var chart;

            function updateChart(data) {
                var options = {
                    series: [{
                        name: 'Penelitian',
                        data: data.penelitian
                    }, {
                        name: 'Pengabdian',
                        data: data.pengabdian
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.tahun_akademik,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' proposal'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(element, options);
                    chart.render();
                }
            }

            function fetchData(status, tahunAkademik, fakultas, prodi) {
                let url = "{{ route('report.proposal.pengajuan.by.ta') }}";
                if (fakultas) url += `?fakultas=${fakultas}`;
                if (status) url += (url.includes('?') ? '&' : '?') + `status=${status}`;
                if (tahunAkademik) url += (url.includes('?') ? '&' : '?') + `tahun_akademik=${tahunAkademik}`;
                if (prodi) url += (url.includes('?') ? '&' : '?') + `prodi=${prodi}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => updateChart(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial fetch without filters
            fetchData();

            // Fetch fakultas data
            const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
            fetch(fakultasUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#prop_filter_fak").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#prop_filter_fak").append($("<option></option>")
                                .attr("value", item.id_fakultas)
                                .text(item.nama_fakultas));
                        });
                        $("#prop_filter_fak").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            // Fetch tahun akademik data
            const tahunAkademikUrl =
                '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
            fetch(tahunAkademikUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#prop_filter_ta").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#prop_filter_ta").append($("<option></option>")
                                .attr("value", item.id_tahun_akademik)
                                .text(item.nama_tahun_akademik));
                        });
                        $("#prop_filter_ta").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            $("#prop_filter_ta").on('change', function() {
                fetchData($("#prop_filter_st").val(), $(this).val(), $("#prop_filter_fak").val(), $(
                    "#prop_filter_pro").val());
            });

            // Event listeners for filters
            $("#prop_filter_fak").on('change', function() {
                let fakultas = $(this).val();
                $("#prop_filter_pro").selectpicker('refresh');
                if (fakultas) {
                    const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                        fakultas);
                    fetch(prodiUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                var data = response.data;
                                $("#prop_filter_pro").empty();
                                $("#prop_filter_pro").append($("<option></option>")
                                    .attr("value", "")
                                    .text("All"));
                                $.each(data, function(key, item) {
                                    $("#prop_filter_pro").append($('<option></option>').attr(
                                        'value', item.id_prodi).text(item.nama_prodi));
                                });
                                $("#prop_filter_pro").selectpicker('refresh');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    $("#prop_filter_pro").empty();
                    $("#prop_filter_pro").append($("<option></option>")
                        .attr("value", "")
                        .text("All"));
                    $("#prop_filter_pro").selectpicker('refresh');
                }
                fetchData($("#prop_filter_st").val(), $("#prop_filter_ta").val(), fakultas, $(
                    "#prop_filter_pro").val());
            });

            $("#prop_filter_pro").on('change', function() {
                fetchData($("#prop_filter_st").val(), $("#prop_filter_ta").val(), $("#prop_filter_fak")
                    .val(), $(this).val());
            });

            $("#prop_filter_st").on('change', function() {
                fetchData($(this).val(), $("#prop_filter_ta").val(), $("#prop_filter_fak")
                    .val(), $("#prop_filter_pro").val());
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var element = document.getElementById('c_arsip_buku');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-danger');
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

            var chart;

            function updateChart(data) {
                var options = {
                    series: [{
                        name: 'Penelitian',
                        data: data.penelitian
                    }, {
                        name: 'Pengabdian',
                        data: data.pengabdian
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.tahun_akademik,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' record'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(element, options);
                    chart.render();
                }
            }

            function fetchData(tahunAkademik, fakultas, prodi) {
                let url = "{{ route('report.publikasi.luaran.buku.by.ta') }}";
                if (fakultas) url += `?fakultas=${fakultas}`;
                if (tahunAkademik) url += (url.includes('?') ? '&' : '?') + `tahun_akademik=${tahunAkademik}`;
                if (prodi) url += (url.includes('?') ? '&' : '?') + `prodi=${prodi}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => updateChart(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial fetch without filters
            fetchData();

            // Fetch fakultas data
            const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
            fetch(fakultasUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_buku_filter_fak").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_buku_filter_fak").append($("<option></option>")
                                .attr("value", item.id_fakultas)
                                .text(item.nama_fakultas));
                        });
                        $("#arsip_buku_filter_fak").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            // Fetch tahun akademik data
            const tahunAkademikUrl =
                '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
            fetch(tahunAkademikUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_buku_filter_ta").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_buku_filter_ta").append($("<option></option>")
                                .attr("value", item.id_tahun_akademik)
                                .text(item.nama_tahun_akademik));
                        });
                        $("#arsip_buku_filter_ta").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            $("#arsip_buku_filter_ta").on('change', function() {
                fetchData($(this).val(), $("#arsip_buku_filter_fak").val(), $("#arsip_buku_filter_pro")
                    .val());
            });

            // Event listeners for filters
            $("#arsip_buku_filter_fak").on('change', function() {
                let fakultas = $(this).val();
                $("#arsip_buku_filter_pro").selectpicker('refresh');
                if (fakultas) {
                    const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                        fakultas);
                    fetch(prodiUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                var data = response.data;
                                $("#arsip_buku_filter_pro").empty();
                                $("#arsip_buku_filter_pro").append($("<option></option>")
                                    .attr("value", "")
                                    .text("All"));
                                $.each(data, function(key, item) {
                                    $("#arsip_buku_filter_pro").append($('<option></option>')
                                        .attr(
                                            'value', item.id_prodi).text(item.nama_prodi));
                                });
                                $("#arsip_buku_filter_pro").selectpicker('refresh');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    $("#arsip_buku_filter_pro").empty();
                    $("#arsip_buku_filter_pro").append($("<option></option>")
                        .attr("value", "")
                        .text("All"));
                    $("#arsip_buku_filter_pro").selectpicker('refresh');
                }
                fetchData($("#arsip_buku_filter_ta").val(), fakultas, $("#arsip_buku_filter_pro").val());
            });

            $("#arsip_buku_filter_pro").on('change', function() {
                fetchData($("#arsip_buku_filter_ta").val(), $("#arsip_buku_filter_fak").val(), $(this)
                    .val());
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var element = document.getElementById('c_arsip_haki');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-success');
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');

            var chart;

            function updateChart(data) {
                var options = {
                    series: [{
                        name: 'Penelitian',
                        data: data.penelitian
                    }, {
                        name: 'Pengabdian',
                        data: data.pengabdian
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.tahun_akademik,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' record'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(element, options);
                    chart.render();
                }
            }

            function fetchData(tahunAkademik, fakultas, prodi) {
                let url = "{{ route('report.publikasi.luaran.haki.by.ta') }}";
                if (fakultas) url += `?fakultas=${fakultas}`;
                if (tahunAkademik) url += (url.includes('?') ? '&' : '?') + `tahun_akademik=${tahunAkademik}`;
                if (prodi) url += (url.includes('?') ? '&' : '?') + `prodi=${prodi}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => updateChart(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial fetch without filters
            fetchData();

            // Fetch fakultas data
            const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
            fetch(fakultasUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_haki_filter_fak").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_haki_filter_fak").append($("<option></option>")
                                .attr("value", item.id_fakultas)
                                .text(item.nama_fakultas));
                        });
                        $("#arsip_haki_filter_fak").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            // Fetch tahun akademik data
            const tahunAkademikUrl =
                '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
            fetch(tahunAkademikUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_haki_filter_ta").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_haki_filter_ta").append($("<option></option>")
                                .attr("value", item.id_tahun_akademik)
                                .text(item.nama_tahun_akademik));
                        });
                        $("#arsip_haki_filter_ta").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            $("#arsip_haki_filter_ta").on('change', function() {
                fetchData($(this).val(), $("#arsip_haki_filter_fak").val(), $("#arsip_haki_filter_pro")
                    .val());
            });

            // Event listeners for filters
            $("#arsip_haki_filter_fak").on('change', function() {
                let fakultas = $(this).val();
                $("#arsip_haki_filter_pro").selectpicker('refresh');
                if (fakultas) {
                    const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                        fakultas);
                    fetch(prodiUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                var data = response.data;
                                $("#arsip_haki_filter_pro").empty();
                                $("#arsip_haki_filter_pro").append($("<option></option>")
                                    .attr("value", "")
                                    .text("All"));
                                $.each(data, function(key, item) {
                                    $("#arsip_haki_filter_pro").append($('<option></option>')
                                        .attr(
                                            'value', item.id_prodi).text(item.nama_prodi));
                                });
                                $("#arsip_haki_filter_pro").selectpicker('refresh');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    $("#arsip_haki_filter_pro").empty();
                    $("#arsip_haki_filter_pro").append($("<option></option>")
                        .attr("value", "")
                        .text("All"));
                    $("#arsip_haki_filter_pro").selectpicker('refresh');
                }
                fetchData($("#arsip_haki_filter_ta").val(), fakultas, $("#arsip_haki_filter_pro").val());
            });

            $("#arsip_haki_filter_pro").on('change', function() {
                fetchData($("#arsip_haki_filter_ta").val(), $("#arsip_haki_filter_fak").val(), $(this)
                    .val());
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var element = document.getElementById('c_arsip_jurnal');

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseColor = KTUtil.getCssVariableValue('--bs-primary');
            var secondaryColor = KTUtil.getCssVariableValue('--bs-light-purple');

            var chart;

            function updateChart(data) {
                var options = {
                    series: [{
                        name: 'Penelitian',
                        data: data.penelitian
                    }, {
                        name: 'Pengabdian',
                        data: data.pengabdian
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['30%'],
                            endingShape: 'rounded'
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.tahun_akademik,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function(val) {
                                return val + ' record'
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                if (chart) {
                    chart.updateOptions(options);
                } else {
                    chart = new ApexCharts(element, options);
                    chart.render();
                }
            }

            function fetchData(tahunAkademik, fakultas, prodi) {
                let url = "{{ route('report.publikasi.luaran.jurnal.by.ta') }}";
                if (fakultas) url += `?fakultas=${fakultas}`;
                if (tahunAkademik) url += (url.includes('?') ? '&' : '?') + `tahun_akademik=${tahunAkademik}`;
                if (prodi) url += (url.includes('?') ? '&' : '?') + `prodi=${prodi}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => updateChart(data))
                    .catch(error => console.error('Error fetching data:', error));
            }

            // Initial fetch without filters
            fetchData();

            // Fetch fakultas data
            const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
            fetch(fakultasUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_jurnal_filter_fak").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_jurnal_filter_fak").append($("<option></option>")
                                .attr("value", item.id_fakultas)
                                .text(item.nama_fakultas));
                        });
                        $("#arsip_jurnal_filter_fak").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            // Fetch tahun akademik data
            const tahunAkademikUrl =
                '{{ route('global.tahun.akademik.list.json') }}'; // Adjust the route name accordingly
            fetch(tahunAkademikUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#arsip_jurnal_filter_ta").append($("<option></option>")
                            .attr("value", "")
                            .text("All"));
                        $.each(data, function(key, item) {
                            $("#arsip_jurnal_filter_ta").append($("<option></option>")
                                .attr("value", item.id_tahun_akademik)
                                .text(item.nama_tahun_akademik));
                        });
                        $("#arsip_jurnal_filter_ta").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });

            $("#arsip_jurnal_filter_ta").on('change', function() {
                fetchData($(this).val(), $("#arsip_jurnal_filter_fak").val(), $("#arsip_jurnal_filter_pro")
                    .val());
            });

            // Event listeners for filters
            $("#arsip_jurnal_filter_fak").on('change', function() {
                let fakultas = $(this).val();
                $("#arsip_jurnal_filter_pro").selectpicker('refresh');
                if (fakultas) {
                    const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id',
                        fakultas);
                    fetch(prodiUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                var data = response.data;
                                $("#arsip_jurnal_filter_pro").empty();
                                $("#arsip_jurnal_filter_pro").append($("<option></option>")
                                    .attr("value", "")
                                    .text("All"));
                                $.each(data, function(key, item) {
                                    $("#arsip_jurnal_filter_pro").append($('<option></option>')
                                        .attr(
                                            'value', item.id_prodi).text(item.nama_prodi));
                                });
                                $("#arsip_jurnal_filter_pro").selectpicker('refresh');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    $("#arsip_jurnal_filter_pro").empty();
                    $("#arsip_jurnal_filter_pro").append($("<option></option>")
                        .attr("value", "")
                        .text("All"));
                    $("#arsip_jurnal_filter_pro").selectpicker('refresh');
                }
                fetchData($("#arsip_jurnal_filter_ta").val(), fakultas, $("#arsip_jurnal_filter_pro")
                    .val());
            });

            $("#arsip_jurnal_filter_pro").on('change', function() {
                fetchData($("#arsip_jurnal_filter_ta").val(), $("#arsip_jurnal_filter_fak").val(), $(this)
                    .val());
            });
        });
    </script>
@endsection
