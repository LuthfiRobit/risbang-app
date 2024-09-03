@extends('layout.main4')
@section('title-one', 'Tendik | Data Dosen')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')
    {{-- <div class="content flex-column-fluid"> --}}
    <div class="card mb-xl-8 mb-5 border-2">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 ">List Dosen</span>
            </h3>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-sm btn-primary me-2" data-toggle="modal" data-target="#form_import"
                        aria-label="Close" data-dismiss="modal" title='Import'><i
                            class="bi bi-file-earmark-excel"></i>Import
                        Dosen</a>
                    <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form_create"
                        aria-label="Close" data-dismiss="modal" title='Create'><i class="bi bi-plus-circle"></i>Tambah
                        Dosen</a>
                </div>
            </div>
        </div>
        <div class="card-body py-3">
            <div class=" bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari Dosen data.
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Data Dosen tidak aktif</span>
                            <span style="color: #0b7a44 ; font-weight: 500;">Data Dosen aktif</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Catatan :
                        </span>
                        <div class="row">
                            <span style="color: #0b7a44 ; font-weight: 500;">
                                <a href="{{ asset('files/template/template_import_dosen_fix.xlsx') }}" target="_blank"
                                    class="text-primary text-hover-success me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-download"></i></span>Template
                                    import dosen (Excel)
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <select class="selectpicker form-control form-control-sm" name="filter_fakultas" id="filter_fakultas"
                        data-live-search="true" title="Pilih Fakultas">
                        <option value="">Semua</option>
                        @foreach ($fakultas as $item)
                            <option value="{{ $item->id_fakultas }}">{{ $item->nama_fakultas }}</option>
                        @endforeach
                    </select>
                    <ul id="error-list" class="list-unstyled text-danger"></ul>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <select class="selectpicker form-control form-control-sm" name="filter_prodi" id="filter_prodi"
                        data-live-search="true" title="Pilih Program Studi">
                        <option value="">Semua</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input bg-primary" type="checkbox" data-kt-check="true"
                                        data-kt-check-target=".widget-13-check" name="select_all">
                                </div>
                            </th>
                            <th class="min-w-75px">Actions</th>
                            <th class="min-w-100px">Fakultas</th>
                            <th class="min-w-100px">Prodi</th>
                            <th class="min-w-100px">NIDN</th>
                            <th class="min-w-125px">Nama Dosen</th>
                            <th class="min-w-125px">Email</th>
                            <th class="min-w-125px">Username</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    {{-- </div> --}}
    @include('tendik.dosen.create')
    @include('tendik.dosen.detail')
    @include('tendik.dosen.edit')
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

    @include('tendik.dosen.scripts.list')
    @include('tendik.dosen.scripts.detail')
    @include('tendik.dosen.scripts.create')
    @include('tendik.dosen.scripts.edit')
@endsection
