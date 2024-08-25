@extends('layout.main4')
@section('title-one', 'Halaman Kelola Penelitian Dosen')
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
                    <span class="card-label fw-bolder fs-3 mb-1 ">Edit Prototype Penelitian</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Silahkan input sesuai dengan ketentuan yang ada.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Judul Penelitian</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm form-select-sm" name="arsip"
                            id="arsip" data-live-search="true" title="Pilih Judul Penelitian" data-size="5" required>
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 lg-md-12 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Judul Prototype</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="judul" id="judul"
                            placeholder="Masukkan Judul Prototype" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">TKT</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm form-select-sm" name="tkt"
                            id="tkt" data-live-search="true" title="Pilih TKT" data-size="4" required>
                            <option value="Seni">Seni</option>
                            <option value="Alkes">Alkes</option>
                            <option value="Vaksin">Vaksin</option>
                            <option value="Software">Software</option>
                            <option value="Obat/Farmasi">Obat/Farmasi</option>
                            <option value="Sosial Humaniora">Sosial Humaniora</option>
                            <option value="Engeneering/Umum">Engeneering/Umum</option>
                            <option value="Pertanian/Perikanan/Peternakan">Pertanian/Perikanan/Peternakan</option>
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Level</span>
                        </label>
                        <select class="selectpicker form-control form-control-sm form-select-sm" name="level"
                            id="level" data-live-search="true" title="Pilih Level" data-size="5" required>
                            <option value="1">Level 1</option>
                            <option value="2">Level 2</option>
                            <option value="3">Level 3</option>
                            <option value="4">Level 4</option>
                            <option value="5">Level 5</option>
                            <option value="6">Level 6</option>
                            <option value="7">Level 7</option>
                            <option value="8">Level 8</option>
                            <option value="9">Level 9</option>
                        </select>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
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
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Tahun Pelaksanaan</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="tahun" id="tahun"
                            placeholder="Masukkan Tahun Pelaksanaan" required />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Cover</span>
                            <span id="exist-cover">

                            </span>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="cover" id="cover"
                            placeholder="Masukkan Cover" accept=".png, .jpg, .jpeg" />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                    <div class="col-lg-6 lg-md-6 col-sm-12">
                        <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                            <span class="required">File</span>
                            <span id="exist-file">

                            </span>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="file" id="file"
                            placeholder="Masukkan File" accept=".pdf," />
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                            <span class="required">Deskripsi</span>
                        </label>
                        <textarea class="form-control form-control-sm" placeholder="Masukkan Deskripsi" name="deskripsi" id="deskripsi"
                            rows="5" required></textarea>
                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                    </div>
                </div>
                {{-- if auth admin or kaprodi --}}
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
                    <span class="card-label fw-bolder fs-3 mb-1 ">Penulis Dosen Dalam</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Penulis dosen dalam kampus berdasarkan penelitian.
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
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Afiliasi</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Koresponden</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Penulis Dosen Luar</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Penulis dosen luar kampus berdasarkan penelitian.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_dosen_luar"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Afiliasi</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Koresponden</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Penulis Lain</span>
                    <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                        Penulis lain berdasarkan penelitian.
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="table_dosen_lain"
                        class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                        style="width:100%;">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Nama Penulis</th>
                                <th class="min-w-100px">Afiliasi</th>
                                <th class="min-w-100px">Peran</th>
                                <th class="min-w-15px">Koresponden</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-body py-3 text-center">
                <button type="button" class="btn btn-sm btn-dark">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </div>
        </div>
    </form>
    {{-- @include('laporan.modalCreatePenulis') --}}
@endsection

@section('script-for-this-page')
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
    {{-- @include('laporan.luaranPrototype.penelitian.scripts.tabels') --}}
    @include('laporan.luaranPrototype.penelitian.scripts.show')
    @include('laporan.luaranPrototype.penelitian.scripts.update')
    {{-- @include('laporan.scripts.createPenulis') --}}
@endsection
