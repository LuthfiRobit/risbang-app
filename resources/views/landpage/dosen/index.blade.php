@extends('landpage.main')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')
    <!--begin::Profil Lp2m Section-->
    <div class="mb-n40 mb-lg-n50 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-17">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="kt_profil_dosen" data-kt-scroll-offset="{default: 100, lg: 150}">Profil
                    Dosen</h3>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="fs-5 text-muted fw-bold">Infografis dan List Dosen</div>
                <!--end::Text-->
            </div>
            <!--end::Heading-->
            <!--begin::Profil Dosen-->
            {{-- <div class="d-flex flex-center"> --}}
            <div class="row g-2 mb-3">
                <div class="col-lg-4">
                    <div class="card card-bordered">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-7 mb-1">Grafik presentasi dosen</span>
                                <span class="text-muted fw-bold fs-7">Per Fakultas</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="kt_apexcharts_2" style="height: 215px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card card-bordered">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-7 mb-1">Grafik jumlah jabatan fungsional dosen</span>
                                <span class="text-muted fw-bold fs-7">Per Fakultas</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="kt_apexcharts_1" style="height: 200px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-4 mb-1">List Dosen</span>
                    </h3>
                    <div class="card-toolbar">
                        <button type="button"
                            class="btn btn-sm btn-icon bg-light-primary btn-color-primary btn-active-light-primary"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-three-dots fs-3"></i>
                            </span>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="">
                            <div class="px-7 py-5">
                                <div class="fs-8 text-dark fw-bolder">
                                    Filter Options
                                </div>
                            </div>
                            <div class="separator border-gray-200"></div>
                            <div class="px-7 py-5">
                                <div class="mb-1">
                                    <div>
                                        <select class="selectpicker form-control form-control-sm" name="jafung"
                                            id="jafung" data-live-search="true" title="Pilih Jabatan Fungsional">
                                            <option value="">Semua</option>
                                            <option value="lecture">Lecturer</option>
                                            <option value="asisten ahli">Asisten Ahli</option>
                                            <option value="lektor">Lektor</option>
                                            <option value="lektor kepala">Lektor Kepala</option>
                                            <option value="guru besar">Guru Besar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div>
                                        <select class="selectpicker form-control form-control-sm" name="filter_fakultas"
                                            id="filter_fakultas" data-live-search="true" data-size="5"
                                            title="Filter Fakultas">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div>
                                        <select class="selectpicker form-control form-control-sm" name="filter_prodi"
                                            id="filter_prodi" data-live-search="true" data-size="5" title="Filter Prodi">
                                            <option value="">Semua</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div>
                                        <a href="{{ route('landpage.dosen.index') }}" class="btn btn-danger btn-sm w-100">
                                            <i class="bi bi-bootstrap-reboot"></i> Reload</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Row-->
                    <div id="data-container" class="row g-6 g-xl-9">
                        {{-- <div class="col-xxl-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-bordered">
                                <div class="card-body d-flex flex-center flex-column pt-3 pb-3">
                                    <div class="symbol symbol-75px symbol-circle mb-5">
                                        <img src="{{ asset('assets2/media/avatars/150-2.jpg') }}" alt="image" />
                                    </div>
                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder mb-0">Karina
                                        Clark</a>
                                    <div class="fw-bold text-gray-400 mb-0 fs-8">Art Director at Novica Co.</div>
                                    <span class="badge badge-light-primary">23434</span>
                                    <div class="text-gray-600">
                                        <a href="#" class="text-gray-600 text-hover-primary">info@keenthemes.com</a>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4 text-center">
                                            <a href="https://scholar.google.com/" target="_blank" title="Google Scholar">
                                                <i class="bi bi-google"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a href="https://www.scopus.com/" target="_blank" title="Scopus">
                                                <i class="bi bi-book"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a href="https://sinta.ristekbrin.go.id/" target="_blank" title="SINTA">
                                                <i class="bi bi-person-lines-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <!--end::Row-->
                    <!--begin::Pagination-->
                    <div id="pagination-container" class="d-flex flex-stack flex-wrap pt-10">
                        <div class="fs-6 fw-bold text-gray-700"></div>
                        <!--begin::Pages-->
                        <ul class="pagination">
                            <!-- Pagination buttons will be dynamically inserted here -->
                        </ul>
                        <!--end::Pages-->
                    </div>
                    <!--end::Pagination-->
                </div>
            </div>
            {{-- </div> --}}
            <!--end::Profil Dosen-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Profil Lp2m Section-->
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('landpage.home.scripts.chartDosen')
    @include('landpage.dosen.scripts.list')
@endsection
