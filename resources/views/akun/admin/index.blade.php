@extends('layout.main4')
@section('title-one', 'Kelola Akun | Admin')
@section('css-for-this-page')
@endsection

@section('content')
    {{-- <div class="content flex-column-fluid"> --}}

    <!--begin::Navbar-->
    <div class="card mb-xxl-3">
        <div class="card-body">
            <!--begin::Navs-->
            <div class="d-flex overflow-auto">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 active" role="tab" data-bs-toggle="tab"
                            id="kt_tab_general_tab" href="#kt_tab_general">
                            <span class="text-danger bi bi-person-fill"> General</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
                            id="kt_tab_password_tab" href="#kt_tab_password">
                            <span class="text-primary bi bi-lock-fill"> Password</span></a>
                    </li>
                </ul>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->

    <div class="card mt-5 mt-xxl-8" id="tab_content_container">
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_tab_general" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_tab_general_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Informasi general</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Silahkan ganti sesuai dengan ketentuan
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="form_general" enctype="multipart/form-data">
                            <div class="row text-center mb-5">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <!--begin::Image input-->
                                    <div id="avatar-show" class="image-input image-input-outline image-input-empty"
                                        data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px" style="background-image: none;">
                                        </div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="avatar_remove" value="1">
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                    <!--begin::Hint-->
                                    <div class="form-text">Type file: png, jpg, jpeg. | Besar max : 2048 Kb.</div>
                                    <!--end::Hint-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Username</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="username"
                                        id="username" placeholder="Masukkan Username" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Email</span>
                                    </label>
                                    <input type="email" class="form-control form-control-sm" name="email" id="email"
                                        placeholder="Masukkan Email" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">No. Telepon</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="phone_number"
                                        id="phone_number" placeholder="Masukkan No. Telepon" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 col-lg-12 col-md-12 text-center">
                                    <button type="reset" class="btn btn-sm btn-danger">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_password" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_password_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Ganti password</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Pastikan password anda mudah diingat dan sesuai ketentuan
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="form_password">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Password Lama</span>
                                    </label>
                                    <input type="password" class="form-control form-control-sm" name="current_password"
                                        id="current_password" placeholder="Masukkan password lama">
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Password Baru</span>
                                    </label>
                                    <input type="password" class="form-control form-control-sm" name="new_password"
                                        id="new_password" placeholder="Masukkan password baru">
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Konfirmasi Password Baru</span>
                                    </label>
                                    <input type="password" class="form-control form-control-sm "
                                        name="password_confirmation" id="password_confirmation"
                                        placeholder="Konfirmasi password baru">
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 col-lg-12 col-md-12 text-center">
                                    <button type="reset" class="btn btn-sm btn-danger">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection

@section('script-for-this-page')
    @include('akun.admin.scripts.edit')
    @include('akun.admin.scripts.show')
    @include('akun.admin.scripts.password')
@endsection
