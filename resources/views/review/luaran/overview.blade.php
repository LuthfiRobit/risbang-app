@extends('layout.main4')
@section('title-one', 'Halaman Review Luaran')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')
    <!--begin::Navbar-->
    <div class="card mb-xxl-3">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->
                <div class="me-7 mb-4">
                    <div class="symbol symbol-60px symbol-lg-60px symbol-fixed position-relative">
                        <img src="{{ asset('assets/media/avatars/profil.png') }}" alt="image" />
                        <div
                            class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px">
                        </div>
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">Laporan
                                    Luaran</a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a href="#"
                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                    {{ $dosen->nama_dosen }}
                                </a>
                                <a href="#"
                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="bi bi-three-dots fs-3"></i>
                                    {{ $dosen->nama_prodi }}
                                </a>
                                <input type="hidden" id="dsn_id" value="{{ request()->query('dosen') }}">
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 active" role="tab" data-bs-toggle="tab"
                            id="kt_tab_penelitian_tab" href="#kt_tab_penelitian">
                            <span class="text-warning bi bi-file-font-fill"></span> Penelitian</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
                            id="kt_tab_pengabdian_tab" href="#kt_tab_pengabdian">
                            <span class="text-success bi bi-file-ppt-fill"></span> Pengabdian</a>
                    </li>
                </ul>
            </div>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->

    <div class="card mt-5 mt-xxl-8">
        <div class="tab-content">
            <!--begin::Tab panel-->

            <div id="kt_tab_penelitian" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_tab_penelitian_tab">
                <!--begin::Form-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Luaran Penelitian | Status :
                                    <span class="fw-bolder text-primary" id="review_status_pene">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Cek kelengkapan luaran dan berikan komentar anda !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="POST" id="fm_submit_luaran_penelitian"
                            data-ta="{{ Route::current()->parameter('id') }}">
                            <div class="row">
                                <div
                                    class="col-sm-12 col-md-12 col-lg-6 bg-light-primary border-primary mb-3 rounded border border-dashed">
                                    <div class="row pt-3">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Judul Penelitian : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_judul_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Nama Publikasi : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_publikasi_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Tingkat Publikasi : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_tingkat_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Tahun Pelaksanaan : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_tahun_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Volume : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_volume_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Nomor : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_nomor_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Url : </span>
                                            <a id="view_link_luaran_pene" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-2">
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Issn : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_issn_luaran_pene"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">File Luaran Penelitian : </span>
                                            <a id="view_file_luaran_pene" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-2">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Komentar Luaran</span>
                                        </label>
                                        <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_pene"
                                            id="komen_luaran_pene" rows="3" required></textarea>
                                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Nilai Luaran</span>
                                            </label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="nilai_luaran_pene" id="nilai_luaran_pene"
                                                placeholder="Masukkan Nilai" required min="10" max="100" />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Keputusan Luaran</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="keputusan_luaran_pene" id="keputusan_luaran_pene"
                                                data-live-search="true" title="Pilih Keputusan">
                                                <option value="Ditolak">Tolak</option>
                                                <option value="Direvisi">Revisi</option>
                                                <option value="Diterima">Terima</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="rev-button-container-pene">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                    <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Form-->
            </div>
            <div id="kt_tab_pengabdian" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_pengabdian_tab">
                <!--begin::Form-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Luaran Pengabdian | Status :
                                    <span class="fw-bolder text-primary" id="review_status_peng">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Cek kelengkapan luaran dan berikan komentar anda !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">

                        <form method="POST" id="fm_submit_luaran_pengabdian"
                            data-ta="{{ Route::current()->parameter('id') }}">
                            <div class="row">
                                <div
                                    class="col-sm-12 col-md-12 col-lg-6 bg-light-primary border-primary mb-3 rounded border border-dashed">
                                    <div class="row pt-3">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Judul Pengabdian : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_judul_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Nama Publikasi : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_publikasi_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Tingkat Publikasi : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_tingkat_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Tahun Pelaksanaan : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_tahun_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Volume : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_volume_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Nomor : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_nomor_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Url : </span>
                                            <a id="view_link_luaran_peng" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-2">
                                            </a>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">Issn : </span>
                                            <span class="d-flex align-items-center text-primary"
                                                id="view_issn_luaran_peng"></span>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <span class="fs-6 text-gray-700 fw-bolder">File Luaran Pengabdian : </span>
                                            <a id="view_file_luaran_peng" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-2">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Komentar Luaran</span>
                                        </label>
                                        <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_peng"
                                            id="komen_luaran_peng" rows="3" required></textarea>
                                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Nilai Luaran</span>
                                            </label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="nilai_luaran_peng" id="nilai_luaran_peng"
                                                placeholder="Masukkan Nilai" required min="10" max="100" />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Keputusan Luaran</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="keputusan_luaran_peng" id="keputusan_luaran_peng"
                                                data-live-search="true" title="Pilih Keputusan">
                                                <option value="Ditolak">Tolak</option>
                                                <option value="Direvisi">Revisi</option>
                                                <option value="Diterima">Terima</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="rev-button-container-peng">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                    <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('review.luaran.scripts.show')
    @include('review.luaran.scripts.create')
@endsection
