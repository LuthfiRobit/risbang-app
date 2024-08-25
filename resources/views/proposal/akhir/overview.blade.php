@extends('layout.main4')
@section('title-one', 'Halaman Akhir Proposal')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')
    <!--begin::Navbar-->
    <div class="card mb-xxl-3">
        <div class="card-body">
            <!--begin::Navs-->
            <div class="d-flex overflow-auto">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 active" role="tab" data-bs-toggle="tab"
                            id="kt_tab_deadline_tab" href="#kt_tab_deadline">
                            <span class="text-danger bi bi-file-x-fill"></span> Dedaline</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
                            id="kt_tab_rekap_tab" href="#kt_tab_rekap">
                            <span class="text-primary bi bi-file-check-fill"></span> Rekap Kemajuan</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
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

    <div class="card mt-5 mt-xxl-8" id="tab_content_container" data-ta="{{ Route::current()->parameter('id') }}">
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_tab_deadline" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_tab_deadline_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Dedaline Laporan Akhir</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Tanggal Terakhir Pengumpulan Berkas Laporan Akhir
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="timeline timeline-5" id="timeline-container">
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_rekap" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_rekap_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Rekapitulasi Hasil Laporan Kemajuan</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Segera lengkapi laporan kemajuan yang belum diterima !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="timeline timeline-5" id="rekap-container">

                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_penelitian" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_penelitian_tab">
                <!--begin::Form-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Akhir Penelitian | Status :
                                    <span class="fw-bolder text-primary" id="review_status_pene">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lengkapi laporan akhir sesuai dengan ketentuan yang ada !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="fm_submit_akhir_penelitian" enctype="multipart/form-data"
                            data-ta="{{ Route::current()->parameter('id') }}" data-pene="{{ $id_pene }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Google Drive Laporan Akhir *)</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_akhir_pene"
                                        id="link_akhir_pene" placeholder="Masukkan Link Google Drive Akhir Penelitian" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File Akhir Penelitian **)</span>
                                        <span id="exist-file-pene">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_akhir_pene"
                                        id="file_akhir_pene" placeholder="Masukkan File Akhir"
                                        accept=".pdf, .doc, .docx" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline checkbox-success">
                                            <input type="checkbox" name="pernyataan_pene" id="pernyataan_pene"
                                                value="y" required />
                                            <span class="required"></span>
                                            Berkas yang diinput adalah milik anda pribadi dan belum pernah dipublikasi di
                                            tempat
                                            lain.
                                        </label>
                                    </div>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                    <div class="d-flex flex-stack">
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Catatan :</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">*) Sertakan link Google
                                                    Drive yang bisa diakses secara umum</span>
                                                <span style="color: #0b7a44 ; font-weight: 500;">**) File maksimal
                                                    berukuran 3 Mb</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Download :</span>
                                            <div class="row">
                                                <a href="#"
                                                    class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1"><i
                                                            class="bi bi-download"></i></span>
                                                    Template Laporan Akhir Penelitian
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($access_akhir == true)
                                    <div
                                        class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                        <div class="d-flex flex-stack">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pemberitahuan !</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">Laporan akhir anda sudah
                                                    diterima, silahkan lanjutkan ke laporan luaran!</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                        <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Form-->
                <!--begin::Review-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">History Review dan Revisi Laporan Akhir Penelitian
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lakukan revisi laporan sesuai dengan komentar dari reviewer!
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-6">
                                    History Revisi
                                </span>
                                <div class="timeline timeline-3 scroll h-300px" id="container-history-pene">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-6">
                                    History Review
                                </span>
                                <div class="timeline timeline-3 scroll h-300px" id="container-review-pene">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Review-->
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
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Akhir Pengabdian | Status :
                                    <span class="fw-bolder text-primary" id="review_status_peng">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lengkapi laporan akhir sesuai dengan ketentuan yang ada !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">

                        <form method="post" id="fm_submit_akhir_pengabdian" enctype="multipart/form-data"
                            data-ta="{{ Route::current()->parameter('id') }}" data-peng="{{ $id_peng }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Google Drive Laporan Akhir *)</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_akhir_peng"
                                        id="link_akhir_peng" placeholder="Masukkan Link Google Drive Akhir Pengabdian" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File Akhir Pengabdian **)</span>
                                        <span id="exist-file-peng">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_akhir_peng"
                                        id="file_akhir_peng" placeholder="Masukkan File Akhir"
                                        accept=".pdf, .doc, .docx" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline checkbox-success">
                                            <input type="checkbox" name="pernyataan_peng" id="pernyataan_peng"
                                                value="y" required />
                                            <span class="required"></span>
                                            Berkas yang diinput adalah milik anda pribadi dan belum pernah dipublikasi di
                                            tempat
                                            lain.
                                        </label>
                                    </div>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div
                                    class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                    <div class="d-flex flex-stack">
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Catatan :</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">*) Sertakan link Google
                                                    Drive yang bisa diakses secara umum</span>
                                                <span style="color: #0b7a44 ; font-weight: 500;">**) File maksimal
                                                    berukuran 3 Mb</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Download :</span>
                                            <div class="row">
                                                <a href="#"
                                                    class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1"><i
                                                            class="bi bi-download"></i></span>
                                                    Template Laporan Akhir Penelitian
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($access_akhir == true)
                                    <div
                                        class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                        <div class="d-flex flex-stack">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pemberitahuan !</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">Laporan akhir anda sudah
                                                    diterima, silahkan lanjutkan ke laporan luaran!</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                        <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Form-->

                <!--begin::Review-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">History Review dan Revisi Laporan Akhir Pengabdian
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lakukan revisi laporan sesuai dengan komentar dari reviewer!
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-6">
                                    History Revisi
                                </span>
                                <div class="timeline timeline-3 scroll h-300px" id="container-history-peng">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-6">
                                    History Review
                                </span>
                                <div class="timeline timeline-3 scroll h-300px" id="container-review-peng">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Review-->
            </div>
        </div>
    </div>
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('proposal.akhir.scripts.deadline')
    @include('proposal.akhir.scripts.rekap')
    @include('proposal.akhir.scripts.create')
    @include('proposal.akhir.scripts.show')
@endsection
