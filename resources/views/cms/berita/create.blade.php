@extends('layout.main4')
@section('title-one', 'Halaman Kelola Berita')
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
                    <span class="card-label fw-bolder fs-3 mb-1">Tambah Berita</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input sesuai dengan ketentuan yang ada.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Judul Berita</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="judul" id="judul"
                            placeholder="Masukkan Judul Berita" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Deskripsi</span>
                        </label>
                        <div class="py-5" data-bs-theme="light">
                            <textarea id="kt_docs_ckeditor_classic" name="deskripsi" style="display:none;"></textarea>
                            <div id="ckeditor-container"></div>
                        </div>
                        <div id="ckeditor-error" class="text-danger" style="display: none;">
                            Deskripsi tidak boleh kosong.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Gambar</span>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="gambar" id="gambar"
                            placeholder="Masukkan Gambar" accept=".png, .jpg, .jpeg" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-6 lg-md-6 col-sm-12">
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
    @include('cms.berita.scripts.ckeditor');
    @include('cms.berita.scripts.create');
@endsection
