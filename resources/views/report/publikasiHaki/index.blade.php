@extends('layout.main4')
@section('title-one', 'Report | Haki Luaran Publikasi')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
@endsection

@section('content')
    <div class="card mb-xl-8 mb-5 border-2">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 ">List Haki Luaran Publikasi</span>
            </h3>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body py-3">
            <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="d-flex flex-stack">
                    <div class="row">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari haki luaran publikasi dosen.
                        </span>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <select class="selectpicker form-control form-control-sm" name="filter_ta" id="filter_ta"
                        data-live-search="true" title="Pilih Tahun Akademik">
                        {{-- <option value="">Semua</option> --}}
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <select class="selectpicker form-control form-control-sm" name="filter_jenis" id="filter_jenis"
                        data-live-search="true" title="Pilih Jenis" required>
                        <option value="">Semua</option>
                        <option value="Penelitian">Penelitian</option>
                        <option value="Pengabdian">Pengabdian</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <select class="selectpicker form-control form-control-sm" name="filter_kate" id="filter_kate"
                        data-live-search="true" title="Pilih Kategori Haki" required>
                        <option value="">Semua</option>
                        <option value="Haki">Haki</option>
                        <option value="Merk">Merk</option>
                        <option value="Paten">Paten</option>
                        <option value="Rahasia Dagang">Rahasia Dagang</option>
                        <option value="Desain Industri">Desain Industri</option>
                        <option value="Indikasi Geografis">Indikasi Geografis</option>
                        <option value="Desain Tata Letak Sirkuit Terpadu">Desain Tata Letak Sirkuit Terpadu</option>
                    </select>
                </div>
                @if (Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'developer')
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <select class="selectpicker form-control form-control-sm" name="filter_fakultas"
                            id="filter_fakultas" data-live-search="true" title="Pilih Fakultas">
                            {{-- <option value="">Semua</option> --}}
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <select class="selectpicker form-control form-control-sm" name="filter_prodi" id="filter_prodi"
                            data-live-search="true" title="Pilih Prodi">
                            {{-- <option value="">Semua</option> --}}
                        </select>
                    </div>
                @else
                    @if (Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'dekan')
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <select class="selectpicker form-control form-control-sm" name="filter_prodi" id="filter_prodi"
                                data-live-search="true" title="Pilih Prodi">
                                {{-- <option value="">Semua</option> --}}
                            </select>
                        </div>
                    @endif
                @endif
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                    style="width:100%;">
                    {{-- <table id="example" class="table table-striped table-row-bordered gy-5 gs-7"> --}}
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                            <th class="min-w-30px">Actions</th>
                            <th class="min-w-50px">Tahun Akademik</th>
                            <th class="min-w-175px">Dosen</th>
                            <th class="min-w-300px">Judul</th>
                            <th class="min-w-50px">Pelaksanaan</th>
                            <th class="min-w-100px">Kategori Haki</th>
                            <th class="min-w-50px">Jenis</th>
                            <th class="min-w-50px">Publish</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('report.publikasiHaki.detail')
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

    @include('report.publikasiHaki.scripts.list')
    @include('report.publikasiHaki.scripts.detail')
@endsection