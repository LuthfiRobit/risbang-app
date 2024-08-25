@extends('layout.main4')
@section('title-one', 'Halaman Review Pengajuan')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
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
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">Halaman
                                    Review Proposal</a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="bi bi-three-dots fs-3"></i> {{ $data->nama_dosen }}</a>
                                <a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="bi bi-three-dots fs-3"></i> {{ $data->nama_prodi }}</a>
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
                            id="kt_tab_proposal_tab" href="#kt_tab_proposal">
                            <span class="text-warning bi bi-file-pdf-fill"></span> Proposal</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 " role="tab" data-bs-toggle="tab"
                            id="kt_tab_luaran_tab" href="#kt_tab_luaran">
                            <span class="text-danger bi bi-file-medical-fill"></span> Luaran</a>
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
            <div id="kt_tab_proposal" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_tab_proposal_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Form Proposal</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Silahkan lakukan review pada proposal, komentar dan nilai wajib diisi pada setiap
                                    item</span>
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar m-0">
                            <!--begin::Tab nav-->
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bolder" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_proposal_penelitian_tab"
                                        class="nav-link justify-content-center text-active-gray-800 active"
                                        data-bs-toggle="tab" role="tab"
                                        href="#kt_tab_proposal_penelitian">Penelitian</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_proposal_pengabdian_tab"
                                        class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab"
                                        role="tab" href="#kt_tab_proposal_pengabdian">Pengabdian</a>
                                </li>
                            </ul>
                            <!--end::Tab nav-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Tab Content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div id="kt_tab_proposal_penelitian" class="card-body p-0 tab-pane fade show active"
                                role="tabpanel" aria-labelledby="kt_tab_proposal_penelitian_tab">
                                <form method="post" id="bt_submit_review_penelitian"
                                    data-id="{{ Crypt::encryptString($data->penelitian) }}"
                                    data-dsn="{{ $data->id_dosen }}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Judul Penelitian</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm form-control-solid"
                                                name="penelitian_judul" id="penelitian_judul"
                                                placeholder="Masukkan Judul Penelitian" readonly />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Judul Penelitian</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_judul"
                                                        id="komen_penelitian_judul" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Judul Penelitian</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_judul" id="nilai_penelitian_judul"
                                                        placeholder="Masukkan Nilai" min="10" max="100"
                                                        required />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Abstrak" name="penelitian_abstrak"
                                                id="penelitian_abstrak" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Abstrak</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_abstrak"
                                                        id="komen_penelitian_abstrak" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Abstrak</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_abstrak" id="nilai_penelitian_abstrak"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Kata Kunci</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm form-control-solid"
                                                name="penelitian_kata_kunci" id="penelitian_kata_kunci"
                                                placeholder="Masukkan Kata Kunci" readonly />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Kata Kunci</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_kata_kunci"
                                                        id="komen_penelitian_kata_kunci" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Kata Kunci</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_kata_kunci"
                                                        id="nilai_penelitian_kata_kunci" placeholder="Masukkan Nilai"
                                                        required min="10" max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Latar Belakang"
                                                name="penelitian_latar_belakang" id="penelitian_latar_belakang" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Latar Belakang</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_latbel"
                                                        id="komen_penelitian_latbel" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Latar Belakang</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_latbel" id="nilai_penelitian_latbel"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Metode" name="penelitian_metode"
                                                id="penelitian_metode" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Metode</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_metode"
                                                        id="komen_penelitian_metode" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Metode</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_metode" id="nilai_penelitian_metode"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Rencana / Rancangan"
                                                name="penelitian_rencana" id="penelitian_rencana" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Rencana / Rancangan</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_rencana"
                                                        id="komen_penelitian_rencana" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Rencana / Rancangan</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_rencana" id="nilai_penelitian_rencana"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Daftar Pustaka"
                                                name="penelitian_dapus" id="penelitian_dapus" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Daftar Pustaka</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_penelitian_dapus"
                                                        id="komen_penelitian_dapus" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Daftar Pustaka</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_penelitian_dapus" id="nilai_penelitian_dapus"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label
                                                class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                                <span>File Proposal Penelitian</span>
                                                <span id="exist-file-pene">
                                                </span>
                                            </label>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Keputusan Reviewer</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="keputusan_reviewer_penelitian" id="keputusan_reviewer_penelitian"
                                                data-live-search="true" title="Pilih Keputusan">
                                                <option value="Ditolak">Tolak</option>
                                                <option value="Direvisi">Revisi</option>
                                                <option value="Diterima">Terima</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                            <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab panel-->
                            <!--begin::Tab panel-->
                            <div id="kt_tab_proposal_pengabdian" class="card-body p-0 tab-pane fade show" role="tabpanel"
                                aria-labelledby="kt_tab_proposal_pengabdian_tab">
                                <form method="post" id="bt_submit_review_pengabdian"
                                    data-id="{{ Crypt::encryptString($data->pengabdian) }}"
                                    data-dsn="{{ $data->id_dosen }}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Judul Pengabdian</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm form-control-solid"
                                                name="pengabdian_judul" id="pengabdian_judul"
                                                placeholder="Masukkan Judul Pengabdian" readonly />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Judul Pengabdian</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_judul"
                                                        id="komen_pengabdian_judul" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Judul Pengabdian</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_judul" id="nilai_pengabdian_judul"
                                                        placeholder="Masukkan Nilai" min="10" max="100"
                                                        required />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Abstrak" name="pengabdian_abstrak"
                                                id="pengabdian_abstrak" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Abstrak</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_abstrak"
                                                        id="komen_pengabdian_abstrak" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Abstrak</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_abstrak" id="nilai_pengabdian_abstrak"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Kata Kunci</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm form-control-solid"
                                                name="pengabdian_kata_kunci" id="pengabdian_kata_kunci"
                                                placeholder="Masukkan Kata Kunci" readonly />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Kata Kunci</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_kata_kunci"
                                                        id="komen_pengabdian_kata_kunci" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Kata Kunci</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_kata_kunci"
                                                        id="nilai_pengabdian_kata_kunci" placeholder="Masukkan Nilai"
                                                        required min="10" max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Latar Belakang"
                                                name="pengabdian_latar_belakang" id="pengabdian_latar_belakang" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Latar Belakang</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_latbel"
                                                        id="komen_pengabdian_latbel" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Latar Belakang</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_latbel" id="nilai_pengabdian_latbel"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Metode" name="pengabdian_metode"
                                                id="pengabdian_metode" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Metode</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_metode"
                                                        id="komen_pengabdian_metode" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Metode</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_metode" id="nilai_pengabdian_metode"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Rencana / Rancangan"
                                                name="pengabdian_rencana" id="pengabdian_rencana" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Rencana / Rancangan</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_rencana"
                                                        id="komen_pengabdian_rencana" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Rencana / Rancangan</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_rencana" id="nilai_pengabdian_rencana"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid" placeholder="Isi Daftar Pustaka"
                                                name="pengabdian_dapus" id="pengabdian_dapus" rows="5" readonly></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Komentar Daftar Pustaka</span>
                                                    </label>
                                                    <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_pengabdian_dapus"
                                                        id="komen_pengabdian_dapus" rows="3" required></textarea>
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-4">
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="required">Nilai Daftar Pustaka</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        name="nilai_pengabdian_dapus" id="nilai_pengabdian_dapus"
                                                        placeholder="Masukkan Nilai" required min="10"
                                                        max="100" />
                                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label
                                                class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                                <span>File Proposal Pengabdian</span>
                                                <span id="exist-file-peng">
                                                </span>
                                            </label>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Keputusan Reviewer</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="keputusan_reviewer_pengabdian" id="keputusan_reviewer_pengabdian"
                                                data-live-search="true" title="Pilih Keputusan">
                                                <option value="Ditolak">Tolak</option>
                                                <option value="Direvisi">Revisi</option>
                                                <option value="Diterima">Terima</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                            <button type="button" class="btn btn-sm btn-danger">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_luaran" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_luaran_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <h3 class="fw-bolder m-0 text-gray-800">Luaran Penelitian dan Pengabdian</h3>
                        </div>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar m-0">
                            <!--begin::Tab nav-->
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bolder" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_luaran_wajib_tab"
                                        class="nav-link justify-content-center text-active-gray-800 active"
                                        data-bs-toggle="tab" role="tab" href="#kt_tab_luaran_wajib">Luaran
                                        Wajib</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_luaran_tambahan_tab"
                                        class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab"
                                        role="tab" href="#kt_tab_luaran_tambahan">Luaran Tambahan</a>
                                </li>
                            </ul>
                            <!--end::Tab nav-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Tab Content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div id="kt_tab_luaran_wajib" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                                aria-labelledby="kt_tab_luaran_wajib_tab">
                                <div class="row" id="show_luaran_wajib"
                                    data-id="{{ Crypt::encryptString($data->tahun_akademik_id) }}"
                                    data-dsn="{{ $data->id_dosen }}"
                                    data-dr="{{ Crypt::encryptString($data->id_detail_reviewer) }}">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600" id="show_luaran_penelitian"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                            <div class="d-flex mb-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                                    data-bs-toggle="modal" data-bs-target="#review_luaran_penelitian"
                                                    id="btn_review_luaran_penelitian">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Review</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600"id="show_luaran_pengabdian"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                            <div class="d-flex mb-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                                    data-bs-toggle="modal" data-bs-target="#review_luaran_pengabdian"
                                                    id="btn_review_luaran_pengabdian">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Review</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600" id="show_luaran_haki"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                            <div class="d-flex mb-4">
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                                    data-bs-toggle="modal" data-bs-target="#review_luaran_haki"
                                                    id="btn_review_luaran_haki">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Tab panel-->
                            <!--begin::Tab panel-->
                            <div id="kt_tab_luaran_tambahan" class="card-body p-0 tab-pane fade show" role="tabpanel"
                                aria-labelledby="kt_tab_luaran_tambahan_tab">
                                <div class="row" id="show_luaran_tambahan"
                                    data-id="{{ Crypt::encryptString($data->tahun_akademik_id) }}"
                                    data-dsn="{{ $data->id_dosen }}"
                                    data-dr="{{ Crypt::encryptString($data->id_detail_reviewer) }}">
                                    <div class="table-responsive">
                                        <table id="example_luaran_buku" data-id="{{ Route::current()->parameter('id') }}"
                                            class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                                            style="width:100%;">
                                            <thead>
                                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                                                    <th class="w-25px"></th>
                                                    <th class="min-w-75px">Actions</th>
                                                    <th class="min-w-175px">Rencana Judul Buku</th>
                                                    <th class="min-w-75px">Rencana Jenis Buku</th>
                                                    <th class="min-w-75px">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-800 fw-bolder">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>
        </div>
    </div>
    @include('review.proposal.createReviewLuaran')
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>

    @include('review.proposal.scripts.showProposal')
    @include('review.proposal.scripts.showReviewProposal')
    @include('review.proposal.scripts.createReviewProposal')
    @include('review.proposal.scripts.showLuaranWajib')
    @include('review.proposal.scripts.showLuaranTambahan')
    @include('review.proposal.scripts.showReviewLuaran')
    @include('review.proposal.scripts.createReviewLuaran')
@endsection
