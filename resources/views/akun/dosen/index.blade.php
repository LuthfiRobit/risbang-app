@extends('layout.main4')
@section('title-one', 'Kelola Akun | Dosen')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
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
                            id="kt_tab_bank_tab" href="#kt_tab_bank">
                            <span class="text-warning bi bi-credit-card"> Bank</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
                            id="kt_tab_research_tab" href="#kt_tab_research">
                            <span class="text-success bi bi-journal-bookmark"> Research</span></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary me-6" role="tab" data-bs-toggle="tab"
                            id="kt_tab_file_tab" href="#kt_tab_file">
                            <span class="text-secoundary bi bi-file-earmark-image"> Files</span></a>
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
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama & Gelar</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        id="name" placeholder="Masukkan Nama & Gelar" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">NIK</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nik"
                                        id="nik" placeholder="Masukkan Nik" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">NIDN</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nidn"
                                        id="nidn" placeholder="Masukkan NIDN" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">NPWP</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="npwp"
                                        id="npwp" placeholder="Masukkan NPWP" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Bidang Ilmu</span>
                                    </label>
                                    <select class="selectpicker form-control form-control-sm" name="bidang_ilmu"
                                        id="bidang_ilmu" data-live-search="true" title="Pilih Bidang Ilmu">
                                    </select>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Kepakaran</span>
                                    </label>
                                    <select class="selectpicker form-control form-control-sm" name="kepakaran"
                                        id="kepakaran" data-live-search="true" title="Pilih Kepakaran">
                                    </select>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Jabatan Fungsional</span>
                                    </label>
                                    <select class="selectpicker form-control form-control-sm" name="jafung"
                                        id="jafung" data-live-search="true" title="Pilih Jabatan Fungsional">
                                        <option value="lecture">Lecturer</option>
                                        <option value="asisten ahli">Asisten Ahli</option>
                                        <option value="lektor">Lektor</option>
                                        <option value="lektor kepala">Lektor Kepala</option>
                                        <option value="guru besar">Guru Besar</option>
                                    </select>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Status Serdos</span>
                                    </label>
                                    <select class="selectpicker form-control form-control-sm" name="status_serdos"
                                        id="status_serdos" data-live-search="true" title="Pilih Status Serdos">
                                        <option value="belum terferifikasi">Belum Tersertifikasi</option>
                                        <option value="terferifikasi">Setifikasi Dosen</option>
                                    </select>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Pendidikan Terakhir</span>
                                    </label>
                                    <select class="selectpicker form-control form-control-sm" name="pendidikan_terakhir"
                                        id="pendidikan_terakhir" data-live-search="true"
                                        title="Pilih Pendidikan Terakhir">
                                        <option value="s1">S1</option>
                                        <option value="s2">S2</option>
                                        <option value="s3">S3</option>
                                        <option value="prof">Profesor</option>
                                    </select>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Perguruan Tinggi Terakhir</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="perguruan"
                                        id="perguruan" placeholder="Masukkan Perguruan Tinggi Terakhir" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Alamat</span>
                                    </label>
                                    <textarea class="form-control form-control-sm" placeholder="Masukkan alamat sesuai KTP" name="alamat"
                                        id="alamat" rows="3" required></textarea>
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Kode POS</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="kode_pos"
                                        id="kode_pos" placeholder="Masukkan Kode POS" required />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <span style="color: #a1081f; font-weight: 500;">Kebutuhan Akun</span>
                                <div class="separator border-primary border-2 my-3"></div>
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
                                    <input type="email" class="form-control form-control-sm" name="email"
                                        id="email" placeholder="Masukkan Email" required />
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

            <div id="kt_tab_bank" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_bank_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800"> Bank</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Pastikan rekening bank yang sedang aktif
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="form_bank" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">No. Rekening</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="norek"
                                        id="norek" placeholder="Masukkan No. Rekening Aktif" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Nama Bank</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nama_bank"
                                        id="nama_bank" placeholder="Masukkan Nama Bank" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Atas Nama</span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" name="nama_akun"
                                        id="nama_akun" placeholder="Masukkan Atas Nama Bank" />
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

            <div id="kt_tab_research" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_research_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Akun Research</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Pastikan akun aktif, kosongkan jika tidak memiliki
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="form_research" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Google Scholar</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_scholar"
                                        id="link_scholar" placeholder="Masukkan Link Google Scholar" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Sinta</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_sinta"
                                        id="link_sinta" placeholder="Masukkan Link Sinta" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Scopus</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_scopus"
                                        id="link_scopus" placeholder="Masukkan Link Scopus" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Publons</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_publons"
                                        id="link_publons" placeholder="Masukkan Link Publons" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link ORCID</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_orcid"
                                        id="link_orcid" placeholder="Masukkan Link ORCID" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Link Garuda</span>
                                    </label>
                                    <input type="url" class="form-control form-control-sm" name="link_garuda"
                                        id="link_garuda" placeholder="Masukkan Link Garuda" />
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

            <div id="kt_tab_file" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_file_tab">
                <!--begin::Timeline-->
                <div class="card mt-5 mt-xxl-8">
                    <!--begin::Card head-->
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <div class="d-flex flex-column">
                                <h3 class="fw-bolder m-0 text-gray-800">Berkas Pendukung</h3>
                                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                                    PERHATIAN! Pastikan berkas pendukung asli
                                </span>
                            </div>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card head-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <form method="post" id="form_berkas" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File KTP</span>
                                        <span id="exist-ktp">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_ktp"
                                        id="file_ktp" placeholder="Masukkan File KTP" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File NPWP</span>
                                        <span id="exist-npwp">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_npwp"
                                        id="file_npwp" placeholder="Masukkan File NPWP" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File SK Dosen</span>
                                        <span id="exist-sk">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_sk"
                                        id="file_sk" placeholder="Masukkan File SK Dosen" />
                                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">File Tandatangan</span>
                                        <span id="exist-ttd">

                                        </span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="file_ttd"
                                        id="file_ttd" placeholder="Masukkan File Tandatangan" />
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
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('akun.dosen.scripts.edit')
    @include('akun.dosen.scripts.editBank')
    @include('akun.dosen.scripts.editResearch')
    @include('akun.dosen.scripts.editFile')
    @include('akun.dosen.scripts.show')
    @include('akun.dosen.scripts.password')
@endsection
