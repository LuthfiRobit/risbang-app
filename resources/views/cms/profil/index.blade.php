@extends('layout.main4')
@section('title-one', 'Halaman Profil')
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
                    <span class="card-label fw-bolder fs-3 mb-1 ">Informas Profil LP2M</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input sesuai dengan ketentuan yang ada. Informasi profil akan ditampilkan pada halaman
                        landpage SIRIAN.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Visi</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan Visi Lp2m" name="visi" id="visi"
                            rows="3" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Misi</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan Misi Lp2m" name="misi" id="misi"
                            rows="3" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Tujuan</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan Tujuan Lp2m" name="tujuan" id="tujuan"
                            rows="3" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Email</span>
                        </label>
                        <input type="email" class="form-control form-control-sm" name="email" id="email"
                            placeholder="Masukkan Email" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">No. Telepon / Whatsap</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="phone" id="phone"
                            placeholder="Masukkan No. Telepon" required pattern="\+?[0-9\s]*"
                            title="Hanya angka, spasi, dan tanda plus yang diizinkan" />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Alamat</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan alamat" name="alamat" id="alamat"
                            rows="3" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class=" py-3 text-center">
            <button type="button" class="btn btn-sm btn-dark">Batal</button>
            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </div>
    </form>

    <div class="pt-0">
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Struktur Personalia</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan anggota lp2m.
                    </span>
                </h3>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#create_anggota"
                            aria-label="Close" data-dismiss="modal" title='Create'><i class="bi bi-plus-circle"></i>
                            Tambah anggota</a>
                    </div>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_anggota"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-25px">Actions</th>
                                <th class="min-w-100px">Anggota</th>
                                <th class="min-w-100px">Jabatan</th>
                                <th class="min-w-15px">Urutan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('cms.profil.createAnggota')
    @include('cms.profil.editAnggota')
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.buttons.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/custom/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/print.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('cms.profil.scripts.showProfil')
    @include('cms.profil.scripts.createProfil')
    @include('cms.profil.scripts.createAnggota')
    @include('cms.profil.scripts.listAnggota')
    @include('cms.profil.scripts.updateAnggota')
@endsection
