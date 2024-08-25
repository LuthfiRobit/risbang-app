@extends('landpage.main')
@section('css-for-this-page')
@endsection

@section('content')
    <!--begin::Profil Lp2m Section-->
    <div class="mb-n10 mb-lg-n20 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-17">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="kt_profil_lp2m" data-kt-scroll-offset="{default: 100, lg: 150}">Profil
                    LP2M</h3>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="fs-5 text-muted fw-bold">Sekilas tentang kami</div>
                <!--end::Text-->
            </div>
            <!--end::Heading-->
            <!--begin::Anggota Slider-->
            <div class="tns tns-default">
                <!--begin::Wrapper-->
                <div id="slider-anggota"data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false"
                    data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000"
                    data-tns-controls="true" data-tns-nav="false" data-tns-items="1" data-tns-center="false"
                    data-tns-dots="false" data-tns-prev-button="#kt_anggota_slider_prev"
                    data-tns-next-button="#kt_anggota_slider_next">

                </div>
                <!--end::Wrapper-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_anggota_slider_prev">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-left fa-2x"></i>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_anggota_slider_next">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-right fa-2x"></i>
                </button>
                <!--end::Button-->
            </div>
            <!--end::AnggotaSlider-->
            <!--begin::Product slider-->
            <div class="tns tns-default">
                <!--begin::Slider-->
                <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                    data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true" data-tns-nav="false"
                    data-tns-items="1" data-tns-center="false" data-tns-dots="false"
                    data-tns-prev-button="#kt_team_slider_prev1" data-tns-next-button="#kt_team_slider_next1">
                    <!--begin::Item-->
                    <div id="visi" class="px-5 pt-5 pt-lg-10 px-lg-10">
                        <div class="card shadow-sm">
                            <div class="card-header text-center">
                                <h3 class="card-title">VISI</h3>
                            </div>
                            <div class="card-body card-scroll h-200px">
                                <!-- Visi content will be inserted here -->
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div id="misi" class="px-5 pt-5 pt-lg-10 px-lg-10">
                        <div class="card shadow-sm">
                            <div class="card-header text-center">
                                <h3 class="card-title">MISI</h3>
                            </div>
                            <div class="card-body card-scroll h-200px">
                                <!-- Misi content will be inserted here -->
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div id="tujuan" class="px-5 pt-5 pt-lg-10 px-lg-10">
                        <div class="card shadow-sm">
                            <div class="card-header text-center">
                                <h3 class="card-title">TUJUAN</h3>
                            </div>
                            <div class="card-body card-scroll h-200px">
                                <!-- Tujuan content will be inserted here -->
                            </div>
                        </div>
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Slider-->
                <!--begin::Slider button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev1">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-left fa-2x"></i>
                </button>
                <!--end::Slider button-->
                <!--begin::Slider button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-right fa-2x"></i>
                </button>
                <!--end::Slider button-->
            </div>
            <!--end::Product slider-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Profil Lp2m Section-->
    <!--begin::Profil Dosen Section-->
    <div class="mt-sm-n10">
        <!--begin::Curve top-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve top-->
        <!--begin::Wrapper-->
        <div class="pb-15 pt-18 landing-dark-bg">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Heading-->
                <div class="text-center mt-15 mb-10" id="kt_profil_dosen" data-kt-scroll-offset="{default: 100, lg: 150}">
                    <!--begin::Title-->
                    <h3 class="fs-2hx text-white fw-bolder mb-5">Profil Dosen</h3>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="fs-5 text-gray-700 fw-bold">Infografis dosen</div>
                    <!--end::Description-->
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
                                <div id="kt_apexcharts_2" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-bordered">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder fs-7 mb-1">Grafik presentasi dosen</span>
                                    <span class="text-muted fw-bold fs-7">Per Jabatan Fungsional</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="kt_apexcharts_1" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </div> --}}
                <!--end::Profil Dosen-->
                <!--begin::Author-->
                <div class="fs-2 fw-bold text-muted text-center">
                    <a href="{{ route('landpage.dosen.index') }}" class="link-primary fs-4 fw-bolder">Selengkapnya</a>
                </div>
                <!--end::Author-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Curve bottom-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve bottom-->
    </div>
    <!--end::Profil Dosen Section-->
    <!--begin::Beita Section-->
    <div class="py-10 py-lg-20">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-12">
                <!--begin::Title-->
                <h3 class="fs-2hx text-dark mb-5" id="kt_berita" data-kt-scroll-offset="{default: 100, lg: 150}">
                    Berita</h3>
                <!--end::Title-->
                <!--begin::Sub-title-->
                <div class="fs-5 text-muted fw-bold">
                    Berita terbaru LP2M Universitas Abdurachman Saleh Situbondo
                </div>
                <!--end::Sub-title=-->
            </div>
            <!--end::Heading-->
            <!--begin::Slider Wrapper-->
            <div class="tns tns-default">
                <!--begin::Slider-->
                <div id="mySlider" class="tns-inner" data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false"
                    data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000"
                    data-tns-controls="true" data-tns-nav="false" data-tns-items="1" data-tns-center="false"
                    data-tns-dots="false" data-tns-prev-button="#kt_team_slider_prev"
                    data-tns-next-button="#kt_team_slider_next">
                    <!-- Slider items will be dynamically added here by jQuery -->
                </div>
                <!--end::Slider-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-left fa-2x"></i>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next">
                    <!-- Font Awesome Icon -->
                    <i class="fas fa-chevron-right fa-2x"></i>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Slider Wrapper-->

            <!--begin::Author-->
            <div class="fs-2 fw-bold text-muted text-center pt-3">
                <a href="{{ route('landpage.berita.index') }}" class="link-primary fs-4 fw-bolder">Selengkapnya</a>
            </div>
            <!--end::Author-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Beita Section-->
    <!--begin::Pengumuman Section-->
    <div class="mb-lg-n15 position-relative z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card" style="filter: drop-shadow(0px 0px 40px rgba(68, 81, 96, 0.08))">
                <!--begin::Card body-->
                <div class="card-body p-lg-20">
                    <!--begin::Heading-->
                    <div class="text-center mb-5 mb-lg-10">
                        <!--begin::Title-->
                        <h3 class="fs-2hx text-dark mb-5" id="kt_pengumuman"
                            data-kt-scroll-offset="{default: 100, lg: 150}">Pengumuman</h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Tabs wrapper-->
                    <div class="d-flex flex-center mb-3 mb-lg-3">
                        <!--begin::Tabs-->
                        <ul class="nav border-transparent flex-center fs-5 fw-bold">
                            <li class="nav-item">
                                <a class="nav-link text-gray-500 text-active-primary px-3 px-lg-6 active" href="#"
                                    data-bs-toggle="tab" data-bs-target="#kt_landing_pengumuman">Pengumuman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-gray-500 text-active-primary px-3 px-lg-6" href="#"
                                    data-bs-toggle="tab" data-bs-target="#kt_landing_pedoman">Pedoman</a>
                            </li>
                        </ul>
                        <!--end::Tabs-->
                    </div>
                    <!--end::Tabs wrapper-->
                    <!--begin::Tabs content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_landing_pengumuman">
                            <!--begin::Card body-->
                            <div class="card-body">
                                <div class="timeline timeline-5" id="timeline-pengumuman">
                                    <!-- Dynamic content will be inserted here -->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_landing_pedoman">
                            <!--begin::Card body-->
                            <div class="card-body">
                                <div class="timeline timeline-5" id="timeline-pedoman">
                                    <!-- Dynamic content will be inserted here -->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tabs content-->
                    <!--begin::Author-->
                    <div class="fs-2 fw-bold text-muted text-center">
                        <a href="{{ route('landpage.pengumuman.index') }}"
                            class="link-primary fs-4 fw-bolder">Selengkapnya</a>
                    </div>
                    <!--end::Author-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Pengumuman Section-->
    <!--begin::Kontak Section-->
    <div class="mt-sm-n20">
        <!--begin::Curve top-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve top-->
        <!--begin::Wrapper-->
        <div class="py-20 landing-dark-bg">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Plans-->
                <div class="d-flex flex-column container pt-lg-20">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <h1 class="fs-2hx fw-bolder text-white mb-5" id="kt_kontak"
                            data-kt-scroll-offset="{default: 100, lg: 150}">Kontak</h1>
                        <div class="text-gray-600 fw-bold fs-5">Kenali kami lebih dekat
                        </div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Kontak-->
                    <div class="text-white" id="kt_kontak">

                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!-- Span untuk email, no_tlpn, dan alamat -->
                            <div class="col-md-6 pe-lg-10">
                                <h1 class="fw-bolder text-white mb-9">Hubungi kami di</h1>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <span class="fs-5 fw-bold mb-2">Email</span>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <span id="email" class="fs-5 fw-bold mb-2"> : lp2m@unars.co.id</span>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <span class="fs-5 fw-bold mb-2">No. Telepon/Whatsap</span>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <span id="whatsapp" class="fs-5 fw-bold mb-2"> : +625 0000 0000</span>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row">
                                        <span class="fs-5 fw-bold mb-2">Alamat</span>
                                    </div>
                                    <div class="col-md-6 fv-row">
                                        <span id="alamat" class="fs-5 fw-bold mb-2"> : Jl. Pb. Sudirman No.7,
                                            Karangasem,
                                            Patokan, Kec. Situbondo, Kabupaten Situbondo, Jawa Timur 68312, Indonesia</span>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Col-->
                            <div class="col-md-6 ps-lg-10">
                                <!--begin::Map-->
                                <div class="w-100 rounded mb-2 mb-lg-0 mt-2">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3953.762743943494!2d113.99457700000002!3d-7.708589!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd728e255060d4f%3A0xeac6c5471383deb6!2sUniversitas%20Abdurachman%20Saleh!5e0!3m2!1sen!2sus!4v1721633383044!5m2!1sen!2sus"
                                        height="300" width="100%" style="border:1px;" allowfullscreen="true"
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                                <!--end::Map-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Kontak-->
                </div>
                <!--end::Plans-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Curve bottom-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve bottom-->
    </div>
    <!--end::Kontak Section-->
    <!--begin::Testimonials Section-->
    <div class="mt-20 mb-n20 position-relative z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Highlight-->
            <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13"
                style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);">
                <!--begin::Content-->
                <div class="my-2 me-5">
                    <!--begin::Title-->
                    <div class="fs-1 fs-lg-2qx fw-bolder text-white mb-2">Segera upload penelitian dan pengabdian
                        mandiri anda,
                        <span class="fw-normal">Khusus Dosen Unars!</span>
                    </div>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="fs-6 fs-lg-5 text-white fw-bold opacity-75">Jadilah bagian dari penyumbang
                        publikasi ilmiah</div>
                    <!--end::Description-->
                </div>
                <!--end::Content-->
                <!--begin::Link-->
                <a href="{{ route('login') }}"
                    class="btn btn-sm btn-outline border-2 btn-outline-white flex-shrink-0 my-2">Upload</a>
                <!--end::Link-->
            </div>
            <!--end::Highlight-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Testimonials Section-->
@endsection

@section('script-for-this-page')
    @include('landpage.home.scripts.showProfil')
    @include('landpage.home.scripts.sliderAnggota')
    @include('landpage.home.scripts.chartDosen')
    @include('landpage.home.scripts.sliderBerita')
    @include('landpage.home.scripts.tabPengumuman')
@endsection
