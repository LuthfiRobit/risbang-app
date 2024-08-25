@extends('layout.main4')
@section('title-one', 'Halaman Kelola Penelitian Dosen')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('content')
    {{-- <div class="content flex-column-fluid"> --}}
    <div class="card mb-xl-8 mb-5 border-2">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 ">List Data Penelitian</span>
            </h3>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ route('laporan.penelitian.create') }}" type="button" class="btn btn-sm btn-primary"
                        title='Create'><i class="bi bi-plus-circle"></i> Tambah
                        Penelitian</a>
                </div>
            </div>
        </div>
        <div class="card-body py-3">
            <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="d-flex flex-stack">
                    <div class="row">
                        <span class="fs-12 text-gray-700">Berikut ini adalah list data penelitian dosen.
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Data penelitian publish</span>
                            <span style="color: #a1081f; font-weight: 500;">Data penelitian tidak publish</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">Actions</th>
                            <th class="min-w-100px">Penginput</th>
                            <th class="min-w-100px">TA</th>
                            <th class="min-w-100px">Pelaksanaan</th>
                            <th class="min-w-200px">Penulis (Owner)</th>
                            <th class="min-w-350px">Judul</th>
                            <th class="min-w-100px">Publish</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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

    @include('laporan.penelitian.scripts.list')
@endsection
