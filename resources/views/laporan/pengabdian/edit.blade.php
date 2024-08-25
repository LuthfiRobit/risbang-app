@extends('layout.main4')
@section('title-one', 'Halaman Kelola Pengabdian Dosen')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('content')
    <form method="POST" id="form_edit" enctype="multipart/form-data">
        <div class="card mb-xl-8 mb-2 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Edit Pengabdian</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input sesuai dengan ketentuan yang ada.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
                    <div class="row">
                        <div class="col-lg-12 lg-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Penulis (Owner)</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm form-select-sm" name="id_owner"
                                id="id_owner" data-live-search="true" title="Pilih Penulis (Owner)" data-size="5"
                                required>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Judul Pengabdian</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="judul" id="judul"
                            placeholder="Masukkan Judul Pengabdian" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Sumber Dana</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm form-select-sm" name="sumber"
                            id="sumber" data-live-search="true" title="Pilih Sumber Dana" required>
                            <option value="Internasional">Hibah Internasional</option>
                            <option value="Pemerintah">Hibah Pemerintah</option>
                            <option value="Dudi">Hibah DUDI</option>
                            <option value="Mandiri">Mandiri PT</option>
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Jumlah Dana</span>
                        </label>
                        <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah"
                            placeholder="Masukkan Jumlah Dana" min="1000000" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 lg-md-4 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Tahun Akademik</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm form-select-sm" name="ta"
                            id="ta" data-live-search="true" title="Pilih Tahun Akademik" data-size="5" required>
                            @foreach ($ta as $item)
                                <option value="{{ $item->id_tahun_akademik }}">{{ $item->nama_tahun_akademik }}</option>
                            @endforeach
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-4 lg-md-4 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Tahun Pelaksanaan</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="tahun" id="tahun"
                            placeholder="Masukkan Tahun Pelaksanaan" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-4 lg-md-4 col-sm-12">
                        <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                            <span class="required">File Pengabdian</span>
                            <span id="exist-file">

                            </span>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="file" id="file"
                            placeholder="Masukkan File Pengabdian" accept=".pdf," />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Abstrak</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan Abstrak Pengabdian" name="abstrak"
                            id="abstrak" rows="5" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                @if (Auth::user()->user_role == 'admin' || (Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi'))
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Status Publish ?</span>
                            </label>
                            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                <input class="checkbox-publish" type="checkbox" name="publish" id="publish"
                                    value="y" />
                                <span class="align-items-center fs-6 fw-bold">*) Silahkan centang agar data terpublish di
                                    website resmi LP2M</span>
                            </label>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Edit Penulis Dosen Dalam</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input penulis dosen dalam kampus.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_dosen_dalam"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-25px">Actions</th>
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Aktif</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                            <tr class="text-start fs-7 gs-0">
                                <td class="min-w-25px">
                                    <button type="button"
                                        class="btn btn-icon btn-bg-danger btn-active-text-warning btn-sm m-1 delete-row"
                                        disabled>
                                        <span class="bi bi-x-circle"></span></button>
                                </td>
                                <td class="min-w-100px">
                                    <select class="selectpicker form-control form-control-sm form-select-sm"
                                        name="penulis_dosen_dalam[]" id="penulis_dosen_dalam[]" data-live-search="true"
                                        title="Pilih Penulis" required>
                                    </select>
                                </td>
                                <td class="min-w-100px">
                                    <select class="selectpicker form-control form-control-sm form-select-sm status-select"
                                        name="peran_dosen_dalam[]" id="peran_dosen_dalam[]" data-live-search="true"
                                        title="Pilih Peran" required>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Anggota">Anggota</option>
                                    </select>
                                </td>
                                <td class="min-w-100px">
                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                        <input class="correspondent" type="checkbox" name="aktif_dosen_dalam[]"
                                            value="1" />
                                        <span></span>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="add-dsn-dalam">Tambah Dosen Dalam</button>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Edit Penulis Dosen Luar</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input penulis dosen luar kampus.
                    </span>
                </h3>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#create_penulis_luar" aria-label="Close" data-dismiss="modal" title='Create'><i
                                class="bi bi-plus-circle"></i> Tambah data dosen luar</a>
                    </div>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_dosen_luar"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-25px">Actions</th>
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Aktif</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="add-dsn-luar">Tambah Dosen Dalam</button>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Edit Penulis Lain</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input penulis lain.
                    </span>
                </h3>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#create_penulis_lain" aria-label="Close" data-dismiss="modal" title='Create'><i
                                class="bi bi-plus-circle"></i> Tambah data penulis lain</a>
                    </div>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_dosen_lain"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-25px">Actions</th>
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Aktif</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-sm" id="add-dsn-lain">Tambah Dosen Dalam</button>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-body py-3 text-center">
                <button type="button" class="btn btn-sm btn-dark">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </div>
    </form>
    @include('laporan.pengabdian.modals')

@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    @include('laporan.pengabdian.scripts.tabels')
    @include('laporan.pengabdian.scripts.show')
    @include('laporan.pengabdian.scripts.update')
    @include('laporan.pengabdian.scripts.createPenulis')
@endsection
