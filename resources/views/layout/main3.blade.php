<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    @include('layout.style')
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
    @yield('css-for-this-page')

</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-column-fluid flex-row">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                {{-- @include('layouts.header') --}}
                <div id="kt_header" class="header mb-5 p-3 shadow-sm">
                    <div class="container-fluid d-flex flex-stack">
                        <div class="d-flex align-items-center me-5">
                            <div class="d-lg-none btn btn-icon btn-active-color-white w-30px h-30px ms-n2 me-3"
                                id="kt_aside_toggle">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                            </div>
                            <div class="p-0 m-0">
                                <h5 class="p-0 m-0 text-white">SIRIAN APPS</h5>
                                <p class="p-0 m-0 text-warning fw-boldest">LP2M Universitas Abdurachman Saleh Situbondo
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">
                            <div class="d-flex align-items-stretch" id="kt_header_user_menu_toggle">
                                <!--begin::Menu wrapper-->
                                <div class="topbar-item cursor-pointer symbol px-3 px-lg-5 me-n3 me-lg-n5 symbol-30px symbol-md-35px"
                                    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                    data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                                    {{-- <img src="assets/media/avatars/150-2.jpg" alt="metronic" /> --}}
                                    <i class="bi bi-person fs-1"></i>
                                </div>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-50px me-5">
                                                {{-- <img alt="Logo" src="assets/media/avatars/150-26.jpg" /> --}}
                                                <i class="bi bi-person fs-2"></i>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Username-->
                                            <div class="d-flex flex-column">
                                                <div class="fw-bolder d-flex align-items-center fs-5">Max Smith
                                                    <span
                                                        class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span>
                                                </div>
                                                <a href="#"
                                                    class="fw-bold text-muted text-hover-primary fs-7">max@kt.com</a>
                                            </div>
                                            <!--end::Username-->
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="../../demo13/dist/account/overview.html"
                                            class="menu-link px-5">Akun</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5" data-kt-menu-trigger="hover"
                                        data-kt-menu-placement="left-start">
                                        <a href="#" class="menu-link px-5">
                                            <span class="menu-title">Ganti Mode</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <!--begin::Menu sub-->
                                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="../../demo13/dist/account/referrals.html"
                                                    class="menu-link px-5">Dosen</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="../../demo13/dist/account/billing.html"
                                                    class="menu-link px-5">Dekan</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu sub-->
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="../../demo13/dist/authentication/flows/basic/sign-in.html"
                                            class="menu-link px-5">Keluar</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Menu wrapper-->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column-fluid">
                    {{-- @include('layouts.menu') --}}
                    <div id="kt_aside" class="aside card bg-body shadow-sm" data-kt-drawer="true"
                        data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
                        <div class="aside-menu flex-column-fluid border-2 px-5">
                            <div class="hover-scroll-overlay-y pe-4 me-n4 my-5" id="kt_aside_menu_wrapper"
                                data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_aside_footer"
                                data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu"
                                data-kt-scroll-offset="{lg: '75px'}">
                                <div class="menu menu-column py-8 " id="#kt_aside_menu" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link " href="https://rkas.poter.id/dashboard">
                                            <span class="menu-icon">
                                                <i class="bi bi-window fs-3 text-dark"></i>
                                            </span>
                                            <span class="menu-title fw-bolder text-dark">Dashboard</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <div class="menu-content pb-2">
                                            <span
                                                class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <span class="menu-link">
                                                <span class="menu-title fw-bolder text-dark">Proposal</span>
                                                <span
                                                    class="fw-bolder text-white bg-primary w-25px h-auto rounded text-center fs-8">4</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div class="menu-sub menu-sub-accordion">
                                                <div class="menu-item">
                                                    <a class="menu-link  bg-primary rounded" href="#">
                                                        <span class="menu-title fw-bold text-warning">Penelitian &
                                                            Pengabdian</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Luaran Penelitian &
                                                            Pengabdian</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Luaran Haki</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Luaran Buku</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <span class="menu-link">
                                                <span class="menu-title fw-bolder text-dark">Road Map</span>
                                                <span
                                                    class="fw-bolder text-white bg-primary w-25px h-auto rounded text-center fs-8">2</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div class="menu-sub menu-sub-accordion">
                                                <div class="menu-item">
                                                    <a class="menu-link  bg-primary rounded" href="#">
                                                        <span class="menu-title fw-bold text-warning">Kaprodi</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Dosen</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="menu-item">
                                        <div data-kt-menu-trigger="click"
                                            class="menu-item menu-accordion {{ Request::routeIs('tendik.*') ? 'hover show' : '' }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="bi bi-window fs-3 text-dark"></i>
                                                </span>
                                                <span class="menu-title fw-bolder text-dark">Data Tendik</span>
                                                <span
                                                    class="fw-bolder text-white bg-primary w-25px h-auto rounded text-center fs-8">6</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div
                                                class="menu-sub menu-sub-accordion {{ Request::routeIs('tendik.*') ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('tendik.tahun.akademik.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('tendik.tahun.akademik.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('tendik.tahun.akademik.*') ? 'text-warning' : 'text-dark' }}">Tahun
                                                            Akademik</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('tendik.fakultas.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('tendik.fakultas.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('tendik.fakultas.*') ? 'text-warning' : 'text-dark' }}">Fakultas</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('tendik.prodi.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('tendik.prodi.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('tendik.prodi.*') ? 'text-warning' : 'text-dark' }}">Program
                                                            Studi</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('tendik.dosen.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('tendik.dosen.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('tendik.dosen.*') ? 'text-warning' : 'text-dark' }}">Dosen</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">User
                                                            Management</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="menu-item">
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <span class="menu-link">
                                                <span class="menu-title fw-bolder text-dark">Setting Pengajuan</span>
                                                <span
                                                    class="fw-bolder text-white bg-primary w-25px h-auto rounded text-center fs-8">2</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div class="menu-sub menu-sub-accordion">
                                                <div class="menu-item">
                                                    <a class="menu-link  bg-primary rounded" href="#">
                                                        <span class="menu-title fw-bold text-warning">Tema</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Reviewer</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Ploting
                                                            Reviewer</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Hasil Ploting
                                                            Reviewer</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Luaran Wajib</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Deadline</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link " href="#">
                                                        <span class="menu-title fw-bold text-dark">Ploting By
                                                            Excel</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="menu-item">
                                        <div data-kt-menu-trigger="click"
                                            class="menu-item menu-accordion {{ Request::routeIs('master.*') ? 'hover show' : '' }}">
                                            <span class="menu-link">
                                                <span class="menu-icon">
                                                    <i class="bi bi-window fs-3 text-dark"></i>
                                                </span>
                                                <span class="menu-title fw-bolder text-dark">Data Master</span>
                                                <span
                                                    class="fw-bolder text-white bg-primary w-25px h-auto rounded text-center fs-8">6</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div
                                                class="menu-sub menu-sub-accordion {{ Request::routeIs('master.*') ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('master.bidang.ilmu.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('master.bidang.ilmu.index') }}">
                                                        <span
                                                            class="menu-title fw-bold  {{ Request::routeIs('master.bidang.ilmu.*') ? 'text-warning' : 'text-dark' }}">Bidang
                                                            Ilmu</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('master.kepakaran.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('master.kepakaran.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('master.kepakaran.*') ? 'text-warning' : 'text-dark' }}">Kepakaran</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('master.rentan.waktu.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('master.rentan.waktu.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('master.rentan.waktu.*') ? 'text-warning' : 'text-dark' }}">Rentan
                                                            Waktu</span>
                                                    </a>
                                                </div>


                                                <div class="menu-item">
                                                    <a class="menu-link {{ Request::routeIs('master.reviewer.*') ? 'bg-primary rounded' : '' }}"
                                                        href="{{ route('master.reviewer.index') }}">
                                                        <span
                                                            class="menu-title fw-bold {{ Request::routeIs('master.reviewer.*') ? 'text-warning' : 'text-dark' }}">Reviewer</span>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex flex-column flex-column-fluid container-fluid">

                        {{-- <div id="kt_content_container" class="container"> --}}
                        {{-- <div class="content flex-column-fluid"> --}}
                        @yield('content')

                        {{-- </div> --}}
                        {{-- </div> --}}
                        {{-- @include('layouts.footer') --}}
                        <div class="footer d-flex flex-lg-column py-4" id="kt_footer">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                                <div class="text-dark order-md-1 order-2">
                                    <span class="text-muted fw-bold me-1">2024©</span>
                                    <a class="text-hover-primary text-gray-800">SIRIAN APPS | LP2M Universitas
                                        Abdurachman Saleh Situbondo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="black" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black" />
            </svg>
        </span>
    </div>
    @include('layout.script')
    @yield('script-for-this-page')
</body>

</html>
