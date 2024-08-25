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
            <div class="text-center mb-5">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="kt_pengumuman" data-kt-scroll-offset="{default: 100, lg: 150}">Pengumuman
                </h3>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="fs-5 text-muted fw-bold">Pengumuman dan Pedoman LP2M</div>
                <!--end::Text-->
            </div>
            <!--end::Heading-->
            <!--begin::Pengumuman-->
            <div class="row g-2 mb-3">
                <div class="card card-xl-stretch mb-3 mb-xl-8">
                    <div class="card-header border-0">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-7 mb-1">List pengumuman dan pedoman</span>
                            <span class="text-muted fw-bold fs-7">Silahkan pilih informasi yang anda butuhkan</span>
                        </h3>
                        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                            title="" data-bs-original-title="Filter">
                            {{-- filter Jenis --}}
                            <select class="selectpicker form-control form-control-sm" name="filter_jenis" id="filter_jenis"
                                data-live-search="true" title="Pilih Jenis">
                                <option value="">Semua</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Pedoman">Pedoman</option>
                            </select>
                            {{-- filter Jenis --}}
                        </div>
                    </div>
                    <!--begin::Card body-->
                    <div class="card-body">
                        {{-- container --}}
                        <div class="timeline timeline-5" id="pengumuman-container">
                            {{-- tampilan pengumuman --}}
                            {{-- <div class="timeline-items mb-3 border-primary rounded border border-dashed pt-3">
                                <div class="timeline-item">
                                    <div class="timeline-media m-3">
                                        <span><i class="bi bi-info-circle text-primary fs-1"></i></span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <a href="#"
                                                    class="text-dark-75 text-hover-primary fw-bolder">Pengumuman</a>
                                                <span class="text-muted ml-2"> | 07-09-2023
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pengumuman Penerima
                                                Pendanaan Program Pengabdian kepada Masyarakat Tahap Kedua
                                                Tahun Anggaran 2024</span>
                                            <div class="row">
                                                <a href="#" target="_blank"
                                                    class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                    Download Berkas Pengumuman
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- tampilan pengumuman --}}
                            {{-- tampilan pedoman --}}
                            {{-- <div class="timeline-items mb-3 border-danger rounded border border-dashed pt-3">
                                <div class="timeline-item">
                                    <div class="timeline-media m-3">
                                        <span><i class="bi bi-info-circle text-danger fs-1"></i></span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <a href="#"
                                                    class="text-danger text-hover-danger fw-bolder">Pedoman</a>
                                                <span class="text-muted ml-2"> | 07-09-2023
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pedoman Penerima
                                                Pendanaan Program Pengabdian kepada Masyarakat Tahap Kedua
                                                Tahun Anggaran 2024</span>
                                            <div class="row">
                                                <a href="#" target="_blank"
                                                    class="d-flex align-items-center text-danger text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                    Download Berkas Pedoman
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- tampilan pedoman --}}
                        </div>
                        {{-- container --}}
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
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Pengumuman-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Profil Lp2m Section-->
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('landpage.pengumuman.scripts.list')
@endsection
