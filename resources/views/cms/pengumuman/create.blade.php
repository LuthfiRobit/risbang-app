@extends('layout.main4')
@section('title-one', 'Halaman Kelola Pengumuman')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('content')
    <form method="post" id="form_create" enctype="multipart/form-data">
        <div class="card mb-xl-8 mb-2 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Tambah Pengumuman</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input sesuai dengan ketentuan yang ada.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Jenis</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm" name="jenis" id="jenis"
                            data-live-search="true" title="Pilih Jenis" required>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Pedoman">Pedoman</option>
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Judul Pengumuman</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="judul" id="judul"
                            placeholder="Masukkan Judul Pengumuman" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Deskripsi</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Isi Deskripsi" name="deskripsi" id="deskripsi"
                            rows="5" word-limit="true"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                            <span class="required">File *)</span>
                            <span id="exist-file">

                            </span>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="file" id="file"
                            placeholder="Masukkan File" accept=".pdf, .docx, .doc" />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Link File **)</span>
                        </label>
                        <input type="url" class="form-control form-control-sm" name="url" id="url"
                            placeholder="Masukkan Link Google Drive File" />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-3">
                            <span>Status Publish ?</span>
                        </label>
                        <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                            <input class="checkbox-publish" type="checkbox" name="publish" id="publish" value="y" />
                            <span class="align-items-center fs-6 fw-bold">*) Silahkan centang agar data terpublish di
                                website resmi LP2M</span>
                        </label>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                        <div class="d-flex flex-stack">
                            <div class="row">
                                <span class="fs-12 text-gray-700 fw-bolder">Catatan : cukup isi salah satu</span>
                                <div class="row">
                                    <span style="color: #0b7a44 ; font-weight: 500;">*) File maksimal
                                        berukuran 3 Mb, jika lebih silahkan input link drive</span>
                                    <span style="color: #a1081f; font-weight: 500;">**) Sertakan link Google
                                        Drive yang bisa diakses secara umum</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-body py-3 text-center">
                <button type="reset" class="btn btn-sm btn-dark">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets2/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    @include('cms.pengumuman.scripts.create');
@endsection
