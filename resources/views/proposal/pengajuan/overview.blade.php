@extends('layout.main4')
@section('title-one', 'Halaman Pengajuan Proposal')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    @if ($access == true)
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    @endif
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
                            id="kt_tab_proposal_tab" href="#kt_tab_proposal">
                            <span class="text-warning bi bi-file-pdf-fill"></span> Proposal</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 {{ $access == true ? '' : 'disabled' }}" role="tab"
                            data-bs-toggle="tab" id="kt_tab_luaran_tab" href="#kt_tab_luaran">
                            <span class="text-danger bi bi-file-medical-fill"></span> Luaran</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 " role="tab" data-bs-toggle="tab"
                            id="kt_tab_review_tab" href="#kt_tab_review">
                            <span class="text-success bi bi-file-check-fill"></span> Review</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 {{ $access == true ? '' : 'disabled' }}" role="tab"
                            data-bs-toggle="tab" id="kt_tab_tugas_tab" href="#kt_tab_tugas">
                            <span class="text-primary bi bi-file-earmark-font-fill"></span> Surat Tugas</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 {{ $access == true ? '' : 'disabled' }}" role="tab"
                            data-bs-toggle="tab" id="kt_tab_pengantar_tab" href="#kt_tab_pengantar">
                            <span class="text-primary bi bi-file-earmark-ppt-fill"></span> Surat Pengantar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6 {{ $access == true ? '' : 'disabled' }}" role="tab"
                            data-bs-toggle="tab" id="kt_tab_kontrak_tab" href="#kt_tab_kontrak">
                            <span class="text-primary bi bi-file-earmark-zip-fill"></span> Kontrak / MoA</a>
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
                                    Lengkapi field sesuai dengan ketentuan yang ada</span>
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
                                <form method="post" id="bt_submit_proposal_penelitian"
                                    data-id="{{ Route::current()->parameter('id') }}" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Rencana Dana</span>
                                            </label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="penelitian_dana" id="penelitian_dana"
                                                placeholder="Masukkan Rencana Dana" required />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Klasifikasi Penelitian</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="penelitian_jenis_penelitian" id="penelitian_jenis_penelitian"
                                                data-live-search="true" title="Pilih Klasifikasi Penelitian" required>
                                                <option value="Dasar">Penelitian Dasar</option>
                                                <option value="Terapan">Penelitian Terapan</option>
                                                <option value="Strategis Nasional">Penelitian Strategis Nasional</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Judul Penelitian</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="penelitian_judul" id="penelitian_judul"
                                                placeholder="Masukkan Judul Penelitian" required />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Abstrak" name="penelitian_abstrak"
                                                id="penelitian_abstrak" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Kata Kunci *) Pisah dengan tanda titik koma ;</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="penelitian_kata_kunci" id="penelitian_kata_kunci"
                                                placeholder="Masukkan Judul Penelitian" required />
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Latar Belakang" name="penelitian_latar_belakang"
                                                id="penelitian_latar_belakang" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Metode" name="penelitian_metode"
                                                id="penelitian_metode" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Rencana / Rancangan" name="penelitian_rencana"
                                                id="penelitian_rencana" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Daftar Pustaka" name="penelitian_dapus"
                                                id="penelitian_dapus" rows="5" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label
                                                class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">File Proposal Penelitian *) Pdf Maksimal 3 Mb</span>
                                                <span id="exist-file-pene">

                                                </span>
                                            </label>
                                            <input type="file" class="form-control form-control-sm"
                                                name="penelitian_file_proposal" id="penelitian_file_proposal"
                                                placeholder="Masukkan File Proposal" accept=".pdf," required />
                                            {{-- <a id="view_penelitian_file_proposal" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-3">
                                                <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                                Lihat File
                                            </a> --}}
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
                                <form method="post" id="bt_submit_proposal_pengabdian"
                                    data-id="{{ Route::current()->parameter('id') }}" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Rencana Dana</span>
                                            </label>
                                            <input type="number" class="form-control form-control-sm"
                                                name="pengabdian_dana" id="pengabdian_dana"
                                                placeholder="Masukkan Rencana Dana" required />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-6">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Klasifikasi Pengabdian</span>
                                            </label>
                                            <select class="selectpicker form-control form-control-sm"
                                                name="pengabdian_jenis_pengabdian" id="pengabdian_jenis_pengabdian"
                                                data-live-search="true" title="Pilih Klasifikasi Pengabdian" required>
                                                <option value="Layanan">Layanan</option>
                                                <option value="Pendampingan">Pendampingan</option>
                                                <option value="Pemberdayaan">Pemberdayaan</option>
                                                <option value="Pengembangan Produk">Pengembangan Produk</option>
                                            </select>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Judul Pengabdian</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="pengabdian_judul" id="pengabdian_judul"
                                                placeholder="Masukkan Judul Pengabdian" required />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Abstrak" name="pengabdian_abstrak"
                                                id="pengabdian_abstrak" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Kata Kunci *) Pisah dengan tanda titik koma ;</span>
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                name="pengabdian_kata_kunci" id="pengabdian_kata_kunci"
                                                placeholder="Masukkan KataKunci Pengabdian" required />
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Latar Belakang" name="pengabdian_latar_belakang"
                                                id="pengabdian_latar_belakang" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Metode" name="pengabdian_metode"
                                                id="pengabdian_metode" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Rencana / Rancangan" name="pengabdian_rencana"
                                                id="pengabdian_rencana" rows="5" word-limit="true" max-words="250" min-words="150" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger writing_error"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm" placeholder="Isi Daftar Pustaka" name="pengabdian_dapus"
                                                id="pengabdian_dapus" rows="5" required></textarea>
                                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label
                                                class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                                <span class="required">File Proposal Pengabdian *) Pdf Maksimal 3 Mb</span>
                                                <span id="exist-file-peng">

                                                </span>
                                            </label>
                                            <input type="file" class="form-control form-control-sm"
                                                name="pengabdian_file_proposal" id="pengabdian_file_proposal"
                                                placeholder="Masukkan File Proposal" accept=".pdf," required />
                                            {{-- <a id="view_pengabdian_file_proposal" href="#" target="_blank"
                                                class="d-flex align-items-center text-primary text-hover-success m-3">
                                                <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                                Lihat File
                                            </a> --}}
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
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Luaran Penelitian dan Pengabdian</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Lengkapi luaran sesuai dengan ketentuan yang ada</span>
                            </div>
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
                                    data-id="{{ Route::current()->parameter('id') }}">
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
                                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_penelitian"
                                                    id="btn_tambah_luaran_penelitian">
                                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_penelitian"
                                                    id="btn_edit_luaran_penelitian">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                                    data-bs-toggle="modal" data-bs-target="#hapus_luaran_penelitian"
                                                    id="btn_hapus_luaran_penelitian">
                                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
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
                                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_pengabdian"
                                                    id="btn_tambah_luaran_pengabdian">
                                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_pengabdian"
                                                    id="btn_edit_luaran_pengabdian">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                                    data-bs-toggle="modal" data-bs-target="#hapus_luaran_pengabdian"
                                                    id="btn_hapus_luaran_pengabdian">
                                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
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
                                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_haki"
                                                    id="btn_tambah_luaran_haki">
                                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                                <a href="#"
                                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_haki"
                                                    id="btn_edit_luaran_haki">
                                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                                <a class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                                    id="btn_hapus_luaran_haki">
                                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
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
                                    data-id="{{ Route::current()->parameter('id') }}">
                                    <div class="text-center">
                                        <a href="#"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                            data-bs-toggle="modal" data-bs-target="#tambah_luaran_buku">
                                            <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                    </div>
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

            <div id="kt_tab_review" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_review_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Hasil Review Proposal</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Silahkan lakukan revisi pada tab proposal dan luaran</span>
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar m-0">
                            <!--begin::Tab nav-->
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bolder" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_review_penelitian_tab"
                                        class="nav-link justify-content-center text-active-gray-800 active"
                                        data-bs-toggle="tab" role="tab"
                                        href="#kt_tab_review_penelitian">Penelitian</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_review_pengabdian_tab"
                                        class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab"
                                        role="tab" href="#kt_tab_review_pengabdian">Pengabdian</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="kt_tab_review_luaran_tab"
                                        class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab"
                                        role="tab" href="#kt_tab_review_luaran">Luaran</a>
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
                            <div id="kt_tab_review_penelitian" class="card-body p-0 tab-pane fade show active"
                                role="tabpanel" aria-labelledby="kt_tab_review_penelitian_tab">
                                <div class="d-flex flex-column">
                                    <h3 class="fw-bolder m-0 text-gray-800">Hasil Review Proposal Penelitian : <span
                                            id="review_status_pene">---</span></h3>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                        Silahkan lakukan revisi pada tab proposal penelitian</span>
                                </div>
                                <form method="post" id="bt_submit_review_penelitian"
                                    data-id="{{ Route::current()->parameter('id') }}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Judul Penelitian</span>
                                            </label>
                                            <input type="text"
                                                class="form-control form-control-sm form-control-solid mb-3"
                                                name="review_judul_pene" id="review_judul_pene"
                                                placeholder="Masukkan Judul Penelitian" readonly />
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_judul_pene"
                                                id="hasil_review_judul_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Abstrak"
                                                name="review_abstrak_pene" id="review_abstrak_pene" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_abstrak_pene"
                                                id="hasil_review_abstrak_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Kata Kunci</span>
                                            </label>
                                            <input type="text"
                                                class="form-control form-control-sm form-control-solid mb-3"
                                                name="review_katkun_pene" id="review_katkun_pene"
                                                placeholder="Masukkan Kata Kunci" readonly />
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_katkun_pene"
                                                id="hasil_review_katkun_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Latar Belakang"
                                                name="review_latbel_pene" id="review_latbel_pene" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_latbel_pene"
                                                id="hasil_review_latbel_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Metode"
                                                name="review_metode_pene" id="review_metode_pene" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_metode_pene"
                                                id="hasil_review_metode_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Rencana / Rancangan"
                                                name="review_rencana_pene" id="review_rencana_pene" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_rencana_pene"
                                                id="hasil_review_rencana_pene" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Daftar Pustaka"
                                                name="review_dapus_pene" id="review_dapus_pene" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_dapus_pene"
                                                id="hasil_review_dapus_pene" rows="5" readonly></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab panel-->
                            <!--begin::Tab panel-->
                            <div id="kt_tab_review_pengabdian" class="card-body p-0 tab-pane fade show" role="tabpanel"
                                aria-labelledby="kt_tab_review_pengabdian_tab">
                                <div class="d-flex flex-column">
                                    <h3 class="fw-bolder m-0 text-gray-800">Hasil Review Proposal Pengabdian : <span
                                            id="review_status_peng">---</span></h3>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                        Silahkan lakukan revisi pada tab proposal pengabdian</span>
                                </div>
                                <form method="post" id="bt_submit_review_pengabdian"
                                    data-id="{{ Route::current()->parameter('id') }}">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Judul Penelitian</span>
                                            </label>
                                            <input type="text"
                                                class="form-control form-control-sm form-control-solid mb-3"
                                                name="review_judul_peng" id="review_judul_peng"
                                                placeholder="Masukkan Judul Penelitian" readonly />
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_judul_peng"
                                                id="hasil_review_judul_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Abstrak</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Abstrak"
                                                name="review_abstrak_peng" id="review_abstrak_peng" rows="5" readonly></textarea>

                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_abstrak_peng"
                                                id="hasil_review_abstrak_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Kata Kunci</span>
                                            </label>
                                            <input type="text"
                                                class="form-control form-control-sm form-control-solid mb-3"
                                                name="review_katkun_peng" id="review_katkun_peng"
                                                placeholder="Masukkan Kata Kunci" readonly />
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_katkun_peng"
                                                id="hasil_review_katkun_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Latar Belakang</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Latar Belakang"
                                                name="review_latbel_peng" id="review_latbel_peng" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_latbel_peng"
                                                id="hasil_review_latbel_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Metode</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Metode"
                                                name="review_metode_peng" id="review_metode_peng" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_metode_peng"
                                                id="hasil_review_metode_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Rencana / Rancangan</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Rencana / Rancangan"
                                                name="review_rencana_peng" id="review_rencana_peng" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_rencana_peng"
                                                id="hasil_review_rencana_peng" rows="5" readonly></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                <span class="">Daftar Pustaka</span>
                                            </label>
                                            <textarea class="form-control form-control-sm form-control-solid mb-3" placeholder="Isi Daftar Pustaka"
                                                name="review_dapus_peng" id="review_dapus_peng" rows="5" readonly></textarea>
                                            <textarea class="form-control form-control-sm form-control-solid" name="hasil_review_dapus_peng"
                                                id="hasil_review_dapus_peng" rows="5" readonly></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab panel-->

                            <!--begin::Tab panel-->
                            <div id="kt_tab_review_luaran" class="card-body p-0 tab-pane fade show" role="tabpanel"
                                aria-labelledby="kt_tab_review_luaran_tab">
                                <div class="d-flex flex-column">
                                    <h3 class="fw-bolder m-0 text-gray-800">Hasil Review Luaran Wajib</h3>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                        Silahkan lakukan revisi pada tab luaran wajib</span>
                                </div>
                                <div class="row" id="show_review_luaran_wajib"
                                    data-id="{{ Route::current()->parameter('id') }}">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600" id="show_review_luaran_penelitian"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600"id="show_review_luaran_pengabdian"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex flex-stack position-relative mt-8">
                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                            </div>
                                            <div class="fw-bold ms-5 text-gray-600" id="show_review_luaran_haki"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-10">
                                    <h3 class="fw-bolder m-0 text-gray-800">Hasil Review Luaran Tambahan</h3>
                                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                        Silahkan lakukan revisi pada tab luaran tambahan</span>
                                </div>
                                <div class="row" id="show_review_luaran_tambahan"
                                    data-id="{{ Route::current()->parameter('id') }}">
                                    <div class="table-responsive">
                                        <table id="example_review_luaran_buku"
                                            data-id="{{ Route::current()->parameter('id') }}"
                                            class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                                            style="width:100%;">
                                            <thead>
                                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                                                    <th class="min-w-75px">Judul</th>
                                                    <th class="min-w-175px">Komentar</th>
                                                    <th class="min-w-75px">Status Review</th>
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

            <div id="kt_tab_tugas" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_tugas_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Surat Tugas</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Silahkan lengkapi surat tugas yang dibutuhkan</span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <div class="row" id="show_surat_tugas" data-id="{{ Route::current()->parameter('id') }}">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="d-flex flex-stack position-relative mt-8">
                                    <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                                    </div>
                                    <div class="fw-bold ms-5 text-gray-600" id="show_st_penelitian"
                                        data-id="{{ Route::current()->parameter('id') }}">
                                        <div class='fs-5' id='jenis_luaran'>Surat Tugas Penelitian</div>
                                        <div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul :
                                            <span class='text-gray-400' id='show_st_judul_penelitian'>---</span>
                                        </div>
                                        <div class='fs-5 fw-bolder text-gray-800 mb-2'>Tanggal :
                                            <span class='text-gray-400' id='show_st_tgl_penelitian'>---</span>
                                        </div>
                                        <div class='fs-5 fw-bolder text-gray-800 mb-2'>Download :
                                            <span class='text-gray-400' id='show_st_berkas'>---</span>
                                        </div>
                                        <div class='fs-5 fw-bolder text-gray-800 mb-2'>Berkas Surat Tugas *PDF :
                                            <form method="post" id="upload_st_penelitian"
                                                data-id="{{ Route::current()->parameter('id') }}">
                                                <div class="row justify-content-md-center">
                                                    <div class="col-sm-6">
                                                        <input type="file" class="form-control form-control-sm"
                                                            name="file_st" id="file_st"
                                                            placeholder="Masukkan Surat Yang Telah Ditanda Tangani"
                                                            required />
                                                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-4">
                                        <a href="#"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                            data-bs-toggle="modal" data-bs-target="#tambah_st_penelitian"
                                            id="btn_tambah_st_penelitian">
                                            <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                        <a href="#"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                            data-bs-toggle="modal" data-bs-target="#edit_st_penelitian"
                                            id="btn_edit_st_penelitian">
                                            <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_pengantar" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_pengantar_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Surat Pengantar</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Silahkan download surat pengantar dan lengkapi data sesuai dengan kebutuhan penelitian
                                    dan pengabdian</span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <h1>Dalam Pengembangan</h1>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>

            <div id="kt_tab_kontrak" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_kontrak_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Kontrak / MoA</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    Silahkan download MoA dan lengkapi data sesuai dengan kebutuhan penelitian
                                    dan pengabdian</span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <h1>Dalam Pengembangan</h1>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Timeline-->
            </div>
        </div>
    </div>
    @include('proposal.pengajuan.createLuaran')
    @include('proposal.pengajuan.editLuaran')
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>

    @include('proposal.pengajuan.scripts.validation')
    @include('proposal.pengajuan.scripts.createPenelitian')
    @include('proposal.pengajuan.scripts.createPengabdian')
    @include('proposal.pengajuan.scripts.showReviewPenelitian')
    @include('proposal.pengajuan.scripts.showReviewPengabdian')
    @include('proposal.pengajuan.scripts.showReviewLuaran')
    @include('proposal.pengajuan.scripts.showReviewLuaranTambahan')
    @if ($access == true)
        @include('proposal.pengajuan.scripts.listLuaranWajib')
        @include('proposal.pengajuan.scripts.listLuaranTambahan')
        @include('proposal.pengajuan.scripts.createLuaran')
        @include('proposal.pengajuan.scripts.editLuaran')
        @include('proposal.pengajuan.scripts.deleteLuaran')
    @endif
@endsection
