@extends('layout.main4')
@section('title-one', 'Halaman Pelaksanaan Proposal')
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
                            <span class="text-danger bi bi-file-earmark-x-fill"></span> Dedaline</a>
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

    <div class="card mt-5 mt-xxl-8">
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
                                <h3 class="fw-bolder m-0 text-gray-800">Dedaline Laporan Pelaksanaan</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Tanggal Terakhir Laporan Pelaksanaan
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

            <div id="kt_tab_penelitian" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_penelitian_tab">
                <!--begin::Form-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Pelaksanaan Penelitian |
                                    <span class="fw-bolder" id="judul_pene">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lengkapi laporan pelaksanaan sesuai dengan ketentuan yang ada !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="POST" id="fm_submit_pelaksanaan_penelitian" enctype="multipart/form-data"
                            data-ta="{{ Route::current()->parameter('id') }}" data-pene="{{ $id_pene }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama Kegiatan</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nama_kegiatan_pene"
                                        id="nama_kegiatan_pene" placeholder="Masukkan Nama Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Tempat Kegiatan</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="tempat_kegiatan_pene"
                                        id="tempat_kegiatan_pene" placeholder="Masukkan Tempat Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Tanggal Kegiatan</span>
                                    </label>
                                    <input type="date" class="form-control form-control-sm" name="tanggal_kegiatan_pene"
                                        id="tanggal_kegiatan_pene" placeholder="Masukkan Tanggal Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Keterangan Kegiatan</span>
                                    </label>
                                    <textarea class="form-control form-control-sm" placeholder="Keterangan Kegiatan" name="ket_kegiatan_pene"
                                        id="ket_kegiatan_pene" rows="2" required></textarea>
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
                                                <span style="color: #a1081f; font-weight: 500;">Laporkan setiap kegiatan
                                                    pada proses pengajuan proposal</span>

                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Download :</span>
                                            <div class="row">
                                                <a href="#"
                                                    class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1"><i
                                                            class="bi bi-download"></i></span>
                                                    Template Laporan Pelaksanaan Penelitian
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($access_pelaksanaan == true)
                                    <div
                                        class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                        <div class="d-flex flex-stack">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pemberitahuan !</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">Laporan pelaksanaan anda
                                                    sudah
                                                    diterima, silahkan lanjutkan ke laporan akhir!</span>
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
                                <h3 class="fw-bolder m-0 text-gray-800">History Laporan Pelaksanaan Penelitian
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lakukan update pada setiap proses pelaksanaan proposal!!
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">

                                <div class="timeline timeline-3 scroll h-300px" id="container-history-pene">

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
                                <h3 class="fw-bolder m-0 text-gray-800">Laporan Pelaksanaan Pengabdian |
                                    <span class="fw-bolder" id="judul_peng">---</span>
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lengkapi laporan pelaksanaan sesuai dengan ketentuan yang ada !
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">

                        <form method="POST" id="fm_submit_pelaksanaan_pengabdian" enctype="multipart/form-data"
                            data-ta="{{ Route::current()->parameter('id') }}" data-peng="{{ $id_peng }}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama Kegiatan</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nama_kegiatan_peng"
                                        id="nama_kegiatan_peng" placeholder="Masukkan Nama Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Tempat Kegiatan</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm"
                                        name="tempat_kegiatan_peng" id="tempat_kegiatan_peng"
                                        placeholder="Masukkan Tempat Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Tanggal Kegiatan</span>
                                    </label>
                                    <input type="date" class="form-control form-control-sm"
                                        name="tanggal_kegiatan_peng" id="tanggal_kegiatan_peng"
                                        placeholder="Masukkan Tanggal Kegiatan" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Keterangan Kegiatan</span>
                                    </label>
                                    <textarea class="form-control form-control-sm" placeholder="Keterangan Kegiatan" name="ket_kegiatan_peng"
                                        id="ket_kegiatan_peng" rows="2" required></textarea>
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
                                                <span style="color: #a1081f; font-weight: 500;">Laporkan setiap kegiatan
                                                    pada proses pengajuan proposal</span>

                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Download :</span>
                                            <div class="row">
                                                <a href="#"
                                                    class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                                    <span class="svg-icon svg-icon-4 me-1"><i
                                                            class="bi bi-download"></i></span>
                                                    Template Laporan Pelaksanaan Penelitian
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($access_pelaksanaan == true)
                                    <div
                                        class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                                        <div class="d-flex flex-stack">
                                            <span class="fs-12 text-gray-700 fw-bolder">Pemberitahuan !</span>
                                            <div class="row">
                                                <span style="color: #a1081f; font-weight: 500;">Laporan pelaksanaan anda
                                                    sudah
                                                    diterima, silahkan lanjutkan ke laporan akhir!</span>
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
                                <h3 class="fw-bolder m-0 text-gray-800">History Laporan Pelaksanaan Pengabdian
                                </h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lakukan update pada setiap proses pelaksanaan proposal!
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">

                                <div class="timeline timeline-3 scroll h-300px" id="container-history-peng">
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
    @include('proposal.pelaksanaan.scripts.create')
    @include('proposal.pelaksanaan.scripts.show')
    @include('proposal.pelaksanaan.scripts.deadline')
@endsection
