@extends('layout.main4')

@section('title-one', 'Setting | Role Dosen')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')
    <div class="card mb-xl-8 mb-5 border-2">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 ">List Role Dosen</span>
            </h3>
            <div class="card-toolbar">
                {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form_create"
                        aria-label="Close" data-dismiss="modal" title='Create'>Tambah Role Dosen</a>
                </div> --}}
            </div>
        </div>
        <div class="card-body py-3">
            <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="d-flex flex-stack">
                    <div class="row">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari Role Dosen.
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Silahkan lakukan perubahan terhadap role
                                dosen</span>
                            <span style="color: #0b7a44 ; font-weight: 500;">Pergantian dekan atau kaprodi otomatis akan
                                me-replace dekan atau kaprodi sebelumnya</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="text-center">
                <button class="btn btn-sm btn-primary" id="active">Active</button>
                <button class="btn btn-sm btn-danger" id="block">Block</button>
            </div> --}}
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                            <th class="min-w-125px">Actions</th>
                            <th class="min-w-125px">Nama</th>
                            <th class="min-w-125px">Username</th>
                            <th class="min-w-125px">Role</th>
                            <th class="min-w-125px">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    {{-- @include('setting.dosen.create') --}}
    @include('setting.dosen.detail')
    @include('setting.dosen.edit')
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
    <script src="{{ asset('assets2/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>

    @include('setting.dosen.scripts.list')
    @include('setting.dosen.scripts.detail')
    {{-- @include('setting.dosen.scripts.create') --}}
    @include('setting.dosen.scripts.edit')
    {{-- @include('setting.dosen.scripts.activation') --}}
@endsection
