@extends('landpage.main')
@section('css-for-this-page')
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
                <h3 class="fs-2hx text-dark mb-5" id="kt_berita" data-kt-scroll-offset="{default: 100, lg: 150}">Detail Berita
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
                                    <h4 class="text-gray-900 mb-7">Berita</h4>
                                    <!--begin::Post content-->
                                    <div class="mb-17" id="berita-detail-container">
                                    </div>
                                    <!--end::Post content-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Sidebar-->
                                <!--end::Sidebar-->
                            </div>
                            <!--end::Layout-->
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
    @include('landpage.berita.scripts.show')
@endsection
