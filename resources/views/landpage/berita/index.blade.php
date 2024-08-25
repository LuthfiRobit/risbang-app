@extends('landpage.main')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    @include('landpage.berita.styles.loadingicon')
@endsection

@section('content')
    <!--begin::Profil Lp2m Section-->
    <div class="mb-n40 mb-lg-n50 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-5">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="kt_berita" data-kt-scroll-offset="{default: 100, lg: 150}">Berita
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Heading-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Post card-->
                    <div class="card">
                        <!--begin::Body-->
                        <div class="card-body p-lg-20 pb-lg-0">
                            <!-- Indikator Loading Spinner -->
                            <div id="loading" class="spinner-container" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                            <!--begin::Layout-->
                            <div class="d-flex flex-column flex-xl-row">
                                <!--begin::Content-->
                                <div class="flex-lg-row-fluid me-xl-15">
                                    <h4 class="text-gray-900 mb-7">Berita Utama</h4>
                                    <!--begin::Post content-->
                                    <div class="mb-17" id="berita-utama-container">
                                    </div>
                                    <!--end::Post content-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Sidebar-->
                                <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                                    <h4 class="text-gray-900 mb-7">Berita Terbaru</h4>
                                    <!--begin::Recent posts-->
                                    <div class="m-0" id="berita-terbaru-container">
                                    </div>
                                    <!--end::Recent posts-->
                                    <!--begin::Block-->
                                    <div class="align-items-center border-1 border-dashed card-rounded p-5 p-lg-10 mb-5">

                                        <!--begin::Icons-->
                                        <div class="d-flex flex-center">
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-facebook h-20px my-2 icon-facebook"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-instagram h-20px my-2 icon-instagram"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-github h-20px my-2 icon-github"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-whatsapp h-20px my-2 icon-whatsapp"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-envelope h-20px my-2 icon-gmail"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-linkedin h-20px my-2 icon-linkedin"></i>
                                            </a>
                                            <!--end::Icon-->
                                            <!--begin::Icon-->
                                            <a href="#" class="mx-4">
                                                <i class="bi bi-twitter h-20px my-2 text-info"></i>
                                            </a>
                                            <!--end::Icon-->
                                        </div>
                                        <!--end::Icons-->
                                    </div>
                                    <!--end::Block-->
                                </div>
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Layout-->
                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Content-->
                                <div class="d-flex flex-stack mb-5">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-900">List Berita</h3>
                                    <!--end::Title-->
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm w-250px"
                                            name="filter_judul" id="filter_judul" value=""
                                            placeholder="Cari judul relefan" />
                                    </div>
                                </div>
                                <!--end::Content-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-9"></div>
                                <!--end::Separator-->
                                <!--begin::Row-->
                                <div class="row g-10" id="berita-container">
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
                            <!--end::Section-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Post card-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Profil Lp2m Section-->
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('landpage.berita.scripts.listTerbaru')
    @include('landpage.berita.scripts.list')
@endsection
