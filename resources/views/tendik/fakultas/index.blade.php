@extends('layout.main4')
@section('title-one', 'Tendik | Data Fakultas')
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
                <span class="card-label fw-bolder fs-3 mb-1 ">List Fakultas</span>
            </h3>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form_create"
                        aria-label="Close" data-dismiss="modal" title='Create'>Tambah Fakultas</a>
                </div>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari Fakultas data.
                        </span>
                        <div class="row mb-2">
                            <span style="color: #a1081f; font-weight: 500;">Data Fakultas tidak aktif</span>
                            <span style="color: #0b7a44 ; font-weight: 500;">Data Fakultas aktif</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Catatan :
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Tentukan dekan pada menu <a
                                    href="{{ route('setting.dosen.management.index') }}">Dosen
                                    Management</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-sm btn-primary" id="active" title='Aktifkan Data'>Aktif</button>
                <button class="btn btn-sm btn-danger" id="block" title='Non Aktifkan Data'>Tidak Aktif</button>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                            <th class="w-25px"></th>
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input bg-primary" type="checkbox" data-kt-check="true"
                                        data-kt-check-target=".widget-13-check" name="select_all">
                                </div>
                            </th>
                            <th class="min-w-125px">Actions</th>
                            <th class="min-w-125px">Fakultas</th>
                            <th class="min-w-125px">Singkatan</th>
                            <th class="min-w-125px">Dekan</th>
                            <th class="min-w-125px">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('tendik.fakultas.create')
    @include('tendik.fakultas.detail')
    @include('tendik.fakultas.edit')
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

    @include('tendik.fakultas.scripts.list')
    @include('tendik.fakultas.scripts.detail')
    @include('tendik.fakultas.scripts.create')
    @include('tendik.fakultas.scripts.edit')
    @include('tendik.fakultas.scripts.activation')
@endsection
