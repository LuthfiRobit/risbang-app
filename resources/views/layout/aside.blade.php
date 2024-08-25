 <div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_aside_mobile_toggle">
     <!--begin::Aside Toolbarl-->
     <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
         @auth
             <!--begin::User-->
             <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
                 <!--begin::Symbol-->
                 <div class="symbol symbol-50px">
                     @auth
                         @if (Auth::user()->profile_pict !== null)
                             <img src="{{ asset('imgs/profileUser/' . Auth::user()->profile_pict) }}"
                                 alt="Avaliable user profile" />
                         @else
                             <img src="{{ asset('assets/media/avatars/profil.png') }}" alt="User profile unavaliable" />
                         @endif
                     @endauth
                     @guest
                         <img src="{{ asset('assets/media/avatars/profil.png') }}" alt="User profile unavaliable" />
                     @endguest
                 </div>
                 <!--end::Symbol-->
                 <!--begin::Wrapper-->
                 <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                     <!--begin::Section-->
                     <div class="d-flex">
                         <!--begin::Info-->
                         <div class="flex-grow-1 me-2">
                             <!--begin::Username-->
                             <a href="#" class="text-white text-hover-primary fs-7 fw-bold">
                                 @auth
                                     {{ Auth::user()->username }}
                                 @endauth
                                 @guest
                                     ----
                                 @endguest
                             </a>
                             <!--end::Username-->
                             <!--begin::Description-->
                             <span class="text-gray-600 fw-bold d-block fs-8 mb-1">
                                 @auth
                                     {{ Auth::user()->dosen_role != null ? Auth::user()->dosen_role : Auth::user()->user_role }}
                                 @endauth
                                 @guest
                                     ----
                                 @endguest
                             </span>
                             <!--end::Description-->
                             <!--begin::Label-->
                             <div class="d-flex align-items-center text-success fs-9">
                                 <span class="bullet bullet-dot bg-success me-1"></span>online
                             </div>
                             <!--end::Label-->
                         </div>
                         <!--end::Info-->
                         <!--begin::User menu-->
                         <div class="me-n2">
                             <!--begin::Action-->
                             <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2"
                                 data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                                 data-kt-menu-overflow="true">
                                 <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                                 <span class="svg-icon svg-icon-muted svg-icon-1">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                         <path opacity="0.3"
                                             d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z"
                                             fill="black" />
                                         <path
                                             d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z"
                                             fill="black" />
                                     </svg>
                                 </span>
                                 <!--end::Svg Icon-->
                             </a>
                             <!--begin::Menu-->
                             <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                 data-kt-menu="true">
                                 <!--begin::Menu item-->
                                 <div class="menu-item px-3">
                                     <div class="menu-content d-flex align-items-center px-3">
                                         <!--begin::Avatar-->
                                         <div class="symbol symbol-50px me-5">
                                             @auth
                                                 @if (Auth::user()->profile_pict !== null)
                                                     <img src="{{ asset('imgs/profileUser/' . Auth::user()->profile_pict) }}"
                                                         alt="" />
                                                 @else
                                                     <img src="{{ asset('assets/media/avatars/profil.png') }}" alt="" />
                                                 @endif
                                             @endauth
                                             @guest
                                                 <img src="{{ asset('assets/media/avatars/profil.png') }}" alt="" />
                                             @endguest
                                         </div>
                                         <!--end::Avatar-->
                                         <!--begin::Username-->
                                         <div class="d-flex flex-column">
                                             <div class="fw-bolder d-flex align-items-center fs-7">
                                                 @auth
                                                     {{ Auth::user()->username }}
                                                 @endauth
                                                 @guest
                                                     ----
                                                 @endguest
                                                 <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">
                                                     @auth
                                                         {{ Auth::user()->dosen_role != null ? Auth::user()->dosen_role : Auth::user()->user_role }}
                                                     @endauth
                                                     @guest
                                                         ----
                                                     @endguest
                                                 </span>
                                             </div>
                                             <a href="#" class="fw-bold text-muted text-hover-primary fs-8">
                                                 @auth
                                                     {{ Auth::user()->email }}
                                                 @endauth
                                                 @guest
                                                     ----
                                                 @endguest
                                             </a>
                                         </div>
                                         <!--end::Username-->
                                     </div>
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu separator-->
                                 <div class="separator my-2"></div>
                                 <!--end::Menu separator-->

                                 <!--begin::Menu item-->
                                 <div class="menu-item px-5 my-1">
                                     <a @if (Auth::user()->user_role == 'admin') href="{{ route('akun.admin.index') }}" @endif
                                         @if (Auth::user()->user_role == 'dosen') href="{{ route('akun.dosen.index') }}" @endif
                                         @if (Auth::user()->user_role == 'reviewer') href="{{ route('akun.reviewer.index') }}" @endif
                                         class="btn btn-sm border border-primary w-100">Akun</a>
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu item-->
                                 <div class="menu-item px-5">
                                     <form action="{{ route('logout') }}" class="d-block" method="POST" id="logoutform1">
                                         @csrf
                                         <button type="submit" class="btn btn-sm border border-danger w-100"
                                             id="logoutButton1">Log
                                             Out</button>
                                     </form>
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu separator-->
                                 <div class="separator my-2"></div>
                                 <!--end::Menu separator-->

                             </div>
                             <!--end::Menu-->
                             <!--end::Action-->
                         </div>
                         <!--end::User menu-->
                     </div>
                     <!--end::Section-->
                 </div>
                 <!--end::Wrapper-->
             </div>
             <!--end::User-->
             <!--end::Aside user-->
         @endauth
     </div>
     <!--end::Aside Toolbarl-->
     <!--begin::Aside menu-->
     <div class="aside-menu flex-column-fluid">
         <!--begin::Aside Menu-->
         <div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
             data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
             data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
             <!--begin::Menu-->
             <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                 id="#kt_aside_menu" data-kt-menu="true">

                 <div class="menu-item">
                     <div class="menu-content pb-2">
                         <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                     </div>
                 </div>
                 <div class="menu-item">
                     <a class="menu-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                         href="{{ route('dashboard') }}">
                         <span class="menu-icon">
                             <i class="bi bi-three-dots fs-3"></i>
                         </span>
                         <span class="menu-title">Main</span>
                     </a>
                 </div>

                 @auth
                     @if (Auth::user()->user_role == 'admin' ||
                             Auth::user()->user_role == 'developer' ||
                             Auth::user()->dosen_role == 'dekan' ||
                             Auth::user()->dosen_role == 'kaprodi')
                         <div class="menu-item">
                             <div class="menu-content pt-8 pb-2">
                                 <span class="menu-section text-muted text-uppercase fs-8 ls-1">Report</span>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('report.proposal.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Proposal</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div
                                 class="menu-sub menu-sub-accordion {{ Request::routeIs('report.proposal.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('report.proposal.pengajuan.*') ? 'active' : '' }}"
                                         href="{{ route('report.proposal.pengajuan.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Pengajuan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('report.proposal.kemajuan.*') ? 'active' : '' }}"
                                         href="{{ route('report.proposal.kemajuan.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Kemajuan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('report.proposal.akhir.*') ? 'active' : '' }}"
                                         href="{{ route('report.proposal.akhir.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Akhir</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('report.proposal.luaran.*') ? 'active' : '' }}"
                                         href="{{ route('report.proposal.luaran.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Luaran</span>
                                     </a>
                                 </div>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('report.publikasi.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Publikasi</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div
                                 class="menu-sub menu-sub-accordion {{ Request::routeIs('report.publikasi.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('report.publikasi.index') ? 'active' : '' }}"
                                         href="{{ route('report.publikasi.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">List Publikasi</span>
                                     </a>
                                 </div>
                                 <div data-kt-menu-trigger="click"
                                     class="menu-item menu-accordion mb-1 {{ Request::routeIs('report.publikasi.luaran.*') ? 'here show' : '' }}">
                                     <span class="menu-link">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Luaran Publikasi</span>
                                         <span class="menu-arrow"></span>
                                     </span>
                                     <div
                                         class="menu-sub menu-sub-accordion  {{ Request::routeIs('report.publikasi.luaran.*') ? 'show' : '' }}">
                                         <div class="menu-item">
                                             <a class="menu-link  {{ Request::routeIs('report.publikasi.luaran.jurnal.*') ? 'active' : '' }}"
                                                 href="{{ route('report.publikasi.luaran.jurnal.index') }}">
                                                 <span class="menu-bullet">
                                                     <span class="bullet bullet-dot"></span>
                                                 </span>
                                                 <span class="menu-title">Jurnal</span>
                                             </a>
                                         </div>
                                         <div class="menu-item">
                                             <a class="menu-link  {{ Request::routeIs('report.publikasi.luaran.haki.*') ? 'active' : '' }}"
                                                 href="{{ route('report.publikasi.luaran.haki.index') }}">
                                                 <span class="menu-bullet">
                                                     <span class="bullet bullet-dot"></span>
                                                 </span>
                                                 <span class="menu-title">HKI</span>
                                             </a>
                                         </div>
                                         <div class="menu-item">
                                             <a class="menu-link  {{ Request::routeIs('report.publikasi.luaran.buku.*') ? 'active' : '' }}"
                                                 href="{{ route('report.publikasi.luaran.buku.index') }}">
                                                 <span class="menu-bullet">
                                                     <span class="bullet bullet-dot"></span>
                                                 </span>
                                                 <span class="menu-title">Buku</span>
                                             </a>
                                         </div>
                                         <div class="menu-item">
                                             <a class="menu-link" href="#">
                                                 <span class="menu-bullet">
                                                     <span class="bullet bullet-dot"></span>
                                                 </span>
                                                 <span class="menu-title">Prototype</span>
                                             </a>
                                         </div>
                                         <div class="menu-item">
                                             <a class="menu-link" href="#">
                                                 <span class="menu-bullet">
                                                     <span class="bullet bullet-dot"></span>
                                                 </span>
                                                 <span class="menu-title">Produk</span>
                                             </a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endif

                     <div class="menu-item">
                         <div class="menu-content pt-8 pb-2">
                             <span class="menu-section text-muted text-uppercase fs-8 ls-1">Fitur</span>
                         </div>
                     </div>

                     @if (Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'dosen')
                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('proposal.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Proposal</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('proposal.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('proposal.pengajuan.*') ? 'active' : '' }}"
                                         href="{{ route('proposal.pengajuan.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Pengajuan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link " href="#">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Pelaksanaan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('proposal.kemajuan.*') ? 'active' : '' }}"
                                         href="{{ route('proposal.kemajuan.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Kemajuan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('proposal.akhir.*') ? 'active' : '' }}"
                                         href="{{ route('proposal.akhir.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Akhir</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('proposal.luaran.*') ? 'active' : '' }}"
                                         href="{{ route('proposal.luaran.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Luaran</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     @endif

                     @if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'dosen')
                         @if (Auth::user()->dosen_role != 'dekan')
                             <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion mb-1 {{ Request::routeIs('laporan.penelitian.*') ? 'here show' : '' }}">
                                 <span class="menu-link">
                                     <span class="menu-icon">
                                         <i class="bi bi-three-dots fs-3"></i>
                                     </span>
                                     <span class="menu-title">Penelitian</span>
                                     <span class="menu-arrow"></span>
                                 </span>
                                 <div
                                     class="menu-sub menu-sub-accordion {{ Request::routeIs('laporan.penelitian.*') ? 'show' : '' }}">
                                     <div class="menu-item">
                                         <a class="menu-link {{ Request::routeIs('laporan.penelitian.index') ||
                                         Request::routeIs('laporan.penelitian.create') ||
                                         Request::routeIs('laporan.penelitian.edit')
                                             ? 'active'
                                             : '' }}"
                                             href="{{ route('laporan.penelitian.index') }}">
                                             <span class="menu-bullet">
                                                 <span class="bullet bullet-dot"></span>
                                             </span>
                                             <span class="menu-title">Kelola Penelitian</span>
                                         </a>
                                     </div>
                                     <div data-kt-menu-trigger="click"
                                         class="menu-item menu-accordion mb-1 {{ Request::routeIs('laporan.penelitian.luaran.*') ? 'here show' : '' }}">
                                         <span class="menu-link">
                                             <span class="menu-bullet">
                                                 <span class="bullet bullet-dot"></span>
                                             </span>
                                             <span class="menu-title">Kelola Luaran Penelitian</span>
                                             <span class="menu-arrow"></span>
                                         </span>
                                         <div
                                             class="menu-sub menu-sub-accordion  {{ Request::routeIs('laporan.penelitian.luaran.*') ? 'show' : '' }}">
                                             <div class="menu-item">
                                                 <a class="menu-link  {{ Request::routeIs('laporan.penelitian.luaran.jurnal.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.penelitian.luaran.jurnal.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Jurnal</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link  {{ Request::routeIs('laporan.penelitian.luaran.haki.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.penelitian.luaran.haki.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">HKI</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link {{ Request::routeIs('laporan.penelitian.luaran.buku.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.penelitian.luaran.buku.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Buku</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link {{ Request::routeIs('laporan.penelitian.luaran.prototype.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.penelitian.luaran.prototype.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Prototype</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link {{ Request::routeIs('laporan.penelitian.luaran.produk.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.penelitian.luaran.produk.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Produk</span>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion mb-1 {{ Request::routeIs('laporan.pengabdian.*') ? 'here show' : '' }}">
                                 <span class="menu-link">
                                     <span class="menu-icon">
                                         <i class="bi bi-three-dots fs-3"></i>
                                     </span>
                                     <span class="menu-title">Pengabdian</span>
                                     <span class="menu-arrow"></span>
                                 </span>
                                 <div
                                     class="menu-sub menu-sub-accordion {{ Request::routeIs('laporan.pengabdian.*') ? 'show' : '' }}">
                                     <div class="menu-item">
                                         <a class="menu-link {{ Request::routeIs('laporan.pengabdian.index') ||
                                         Request::routeIs('laporan.pengabdian.create') ||
                                         Request::routeIs('laporan.pengabdian.edit')
                                             ? 'active'
                                             : '' }}"
                                             href="{{ route('laporan.pengabdian.index') }}">
                                             <span class="menu-bullet">
                                                 <span class="bullet bullet-dot"></span>
                                             </span>
                                             <span class="menu-title">Kelola Pengabdian</span>
                                         </a>
                                     </div>
                                     <div data-kt-menu-trigger="click"
                                         class="menu-item menu-accordion mb-1 {{ Request::routeIs('laporan.pengabdian.luaran.*') ? 'here show' : '' }}">
                                         <span class="menu-link">
                                             <span class="menu-bullet">
                                                 <span class="bullet bullet-dot"></span>
                                             </span>
                                             <span class="menu-title">Kelola Luaran Pengabdian</span>
                                             <span class="menu-arrow"></span>
                                         </span>
                                         <div
                                             class="menu-sub menu-sub-accordion  {{ Request::routeIs('laporan.pengabdian.luaran.*') ? 'show' : '' }}">
                                             <div class="menu-item">
                                                 <a class="menu-link  {{ Request::routeIs('laporan.pengabdian.luaran.jurnal.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.pengabdian.luaran.jurnal.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Jurnal</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link  {{ Request::routeIs('laporan.pengabdian.luaran.haki.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.pengabdian.luaran.haki.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">HKI</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link  {{ Request::routeIs('laporan.pengabdian.luaran.buku.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.pengabdian.luaran.buku.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Buku</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link {{ Request::routeIs('laporan.pengabdian.luaran.prototype.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.pengabdian.luaran.prototype.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Prototype</span>
                                                 </a>
                                             </div>
                                             <div class="menu-item">
                                                 <a class="menu-link {{ Request::routeIs('laporan.pengabdian.luaran.produk.*') ? 'active' : '' }}"
                                                     href="{{ route('laporan.pengabdian.luaran.produk.index') }}">
                                                     <span class="menu-bullet">
                                                         <span class="bullet bullet-dot"></span>
                                                     </span>
                                                     <span class="menu-title">Produk</span>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @endif
                     @endif

                     @if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'developer' || Auth::user()->user_role == 'dosen')
                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('roadmap.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Roadmap</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('roadmap.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('roadmap.dosen.*') ? 'active' : '' }}"
                                         href="{{ route('roadmap.dosen.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Dosen</span>
                                     </a>
                                 </div>
                                 @if (Auth::user()->user_role == 'admin' || Auth::user()->dosen_role == 'dekan' || Auth::user()->dosen_role == 'kaprodi')
                                     <div class="menu-item">
                                         <a class="menu-link {{ Request::routeIs('roadmap.prodi.*') ? 'active' : '' }}"
                                             href="{{ route('roadmap.prodi.index') }}">
                                             <span class="menu-bullet">
                                                 <span class="bullet bullet-dot"></span>
                                             </span>
                                             <span class="menu-title">Kaprodi</span>
                                         </a>
                                     </div>
                                 @endif
                             </div>
                         </div>
                     @endif

                     @if (Auth::user()->user_role == 'reviewer')
                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('review.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Review</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('review.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('review.proposal.*') ? 'active' : '' }}"
                                         href="{{ route('review.proposal.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Pengajuan Proposal</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('review.kemajuan.*') ? 'active' : '' }}"
                                         href="{{ route('review.kemajuan.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Laporan Kemajuan</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('review.akhir.*') ? 'active' : '' }}"
                                         href="{{ route('review.akhir.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Laporan Akhir</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('review.luaran.*') ? 'active' : '' }}"
                                         href="{{ route('review.luaran.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Laporan Luaran</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     @endif

                     @if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'developer')
                         <div class="menu-item">
                             <div class="menu-content pt-8 pb-2">
                                 <span class="menu-section text-muted text-uppercase fs-8 ls-1">Tendik</span>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion {{ Request::routeIs('tendik.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Data Tendik</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('tendik.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('tendik.tahun.akademik.*') ? 'active' : '' }}"
                                         href="{{ route('tendik.tahun.akademik.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Tahun Akademik</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('tendik.fakultas.*') ? 'active' : '' }}"
                                         href="{{ route('tendik.fakultas.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Fakultas</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('tendik.prodi.*') ? 'active' : '' }}"
                                         href="{{ route('tendik.prodi.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Program Studi</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('tendik.dosen.*') ? 'active' : '' }}"
                                         href="{{ route('tendik.dosen.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Dosen</span>
                                     </a>
                                 </div>
                             </div>
                         </div>

                         <div class="menu-item">
                             <div class="menu-content pt-8 pb-2">
                                 <span class="menu-section text-muted text-uppercase fs-8 ls-1">Masters</span>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('master.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Data Master</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('master.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('master.bidang.ilmu.*') ? 'active' : '' }}"
                                         href="{{ route('master.bidang.ilmu.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Bidang Ilmu</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('master.kepakaran.*') ? 'active' : '' }}"
                                         href="{{ route('master.kepakaran.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Kepakaran</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('master.rentan.waktu.*') ? 'active' : '' }}"
                                         href="{{ route('master.rentan.waktu.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Rentan Waktu</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('master.reviewer.*') ? 'active' : '' }}"
                                         href="{{ route('master.reviewer.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Reviewer</span>
                                     </a>
                                 </div>
                             </div>
                         </div>

                         <div class="menu-item">
                             <div class="menu-content pt-8 pb-2">
                                 <span class="menu-section text-muted text-uppercase fs-8 ls-1">Apps</span>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('setting.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Settings</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('setting.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('setting.dosen.management.*') ? 'active' : '' }}"
                                         href="{{ route('setting.dosen.management.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Dosen Management</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('setting.deadline.proposal.*') ? 'active' : '' }}"
                                         href="{{ route('setting.deadline.proposal.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Deadline Management</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('setting.ploting.reviewer.*') ? 'active' : '' }}"
                                         href="{{ route('setting.ploting.reviewer.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Ploting Reviewer</span>
                                     </a>
                                 </div>
                             </div>
                         </div>

                         <div class="menu-item">
                             <div class="menu-content pt-8 pb-2">
                                 <span class="menu-section text-muted text-uppercase fs-8 ls-1">CMS</span>
                             </div>
                         </div>

                         <div data-kt-menu-trigger="click"
                             class="menu-item menu-accordion mb-1 {{ Request::routeIs('cms.*') ? 'here show' : '' }}">
                             <span class="menu-link">
                                 <span class="menu-icon">
                                     <i class="bi bi-three-dots fs-3"></i>
                                 </span>
                                 <span class="menu-title">Data CMS</span>
                                 <span class="menu-arrow"></span>
                             </span>
                             <div class="menu-sub menu-sub-accordion {{ Request::routeIs('cms.*') ? 'show' : '' }}">
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('cms.profil.*') ? 'active' : '' }}"
                                         href="{{ route('cms.profil.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Profil</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('cms.pengumuman.*') ? 'active' : '' }}"
                                         href="{{ route('cms.pengumuman.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Pengumuman/Pedoman</span>
                                     </a>
                                 </div>
                                 <div class="menu-item">
                                     <a class="menu-link {{ Request::routeIs('cms.berita.*') ? 'active' : '' }}"
                                         href="{{ route('cms.berita.index') }}">
                                         <span class="menu-bullet">
                                             <span class="bullet bullet-dot"></span>
                                         </span>
                                         <span class="menu-title">Berita</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     @endif

                     <div class="menu-item">
                         <div class="menu-content pb-2">
                             <span class="menu-section text-muted text-uppercase fs-8 ls-1">Akun</span>
                         </div>
                     </div>
                     <div class="menu-item">
                         <a class="menu-link {{ Request::routeIs('akun.*') ? 'active' : '' }}"
                             @if (Auth::user()->user_role == 'admin') href="{{ route('akun.admin.index') }}" @endif
                             @if (Auth::user()->user_role == 'dosen') href="{{ route('akun.dosen.index') }}" @endif
                             @if (Auth::user()->user_role == 'reviewer') href="{{ route('akun.reviewer.index') }}" @endif>
                             <span class="menu-icon">
                                 <i class="bi bi-three-dots fs-3"></i>
                             </span>
                             <span class="menu-title">Kelola Akun</span>
                         </a>
                     </div>

                 @endauth
             </div>
             <!--end::Menu-->
         </div>
         <!--end::Aside Menu-->
     </div>
     <!--end::Aside menu-->
     <!--begin::Footer-->
     <div class="aside-footer flex-column-auto py-5" id="kt_aside_footer">

     </div>
     <!--end::Footer-->
 </div>
