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

<body id="kt_body" class="app-default bg-white">
    <div class="d-flex flex-column flex-root">
        <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom ">
            <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header"
                data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between shadow rounded-4">
                        <div class="d-flex align-items-center flex-equal">
                            <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none"
                                id="kt_landing_menu_toggle">
                                <span class="svg-icon svg-icon-2x mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                            fill="black" />
                                        <path opacity="0.3"
                                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                            fill="black" />
                                    </svg>
                                </span>
                            </button>
                            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}"
                                class="logo-default h-45px h-lg-45px p-2" />
                            <p class="fw-bolder mx-2 my-3">SIRIAN APPS</p>
                        </div>
                        <div class="d-lg-block" id="kt_header_nav_wrapper">
                            <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu"
                                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                                data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true"
                                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}">
                                <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-primary menu-state-title-primary nav nav-flush"
                                    id="kt_landing_menu" data-kt-menu='true'>
                                    <div class="menu-item py-2 fw-bolder">
                                        <a class="menu-link nav-link bg-hover-primary text-hover-white"
                                            href="#">Beranda</a>
                                    </div>
                                    <div class="menu-item py-2 fw-bolder">
                                        <a class="menu-link nav-link bg-hover-primary text-hover-white"
                                            href="#">Pengguna</a>
                                    </div>
                                    <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                        data-kt-menu-placement="bottom-start"
                                        class="menu-item menu-lg-down-accordion me-0 me-lg-2  py-2 fw-bolder">
                                        <span class="menu-link">
                                            <span class="menu-title">Sistem</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div
                                            class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                            <div class="menu-item py-2">
                                                <a class="menu-link nav-link bg-hover-primary text-hover-white fw-normal"
                                                    href="#">Rollback</a>
                                            </div>
                                            <div class="menu-item py-2">
                                                <a class="menu-link nav-link bg-hover-primary text-hover-white fw-normal"
                                                    href="#">Spam</a>
                                            </div>
                                            <div class="menu-item py-2">
                                                <a class="menu-link nav-link bg-hover-primary text-hover-white fw-normal"
                                                    href="#">BlackList</a>
                                            </div>
                                            <div class="menu-item py-2">
                                                <a class="menu-link nav-link bg-hover-primary text-hover-white fw-normal"
                                                    href="#" target="_blank">Clear
                                                    Cache</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="kt_content_container" class="container">
                    <div class="content flex-column-fluid shadow rounded-4">
                        @yield('content')
                    </div>
                </div>
            </div>
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
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
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
