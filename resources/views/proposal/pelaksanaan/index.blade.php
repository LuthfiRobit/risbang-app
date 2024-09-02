@extends('layout.main4')
@section('title-one', 'Halaman Pelaksanaan Proposal')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}"> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
@endsection

@section('content')
    {{-- <div class="content flex-column-fluid"> --}}
    <div class="card mb-xl-8 mb-5 border-2">
        <div class="card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1 ">List Tahun Akademik</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="d-flex flex-stack">
                    <div class="row">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari tahun akademik.
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Data Tahun Akademik dibuka untuk
                                pelaksanaan</span>
                            <span style="color: #0b7a44 ; font-weight: 500;">Data Tahun Akademik ditutup untuk
                                pelaksanaan</span>
                        </div>
                        <input type="hidden" id="dsn_id"
                            value="{{ Crypt::encryptString(Auth::user()->dosen->id_dosen) }}">
                    </div>
                </div>
            </div>
            @if (session()->has('fail'))
                <div class="alert alert-danger border border-dashed border-danger d-flex align-items-center p-5 mb-10">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle"></i>
                    </span>
                    <!--end::Svg Icon-->
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">Pemberitahuan</h4>
                        <span>{{ session()->get('fail') }}</span>
                    </div>
                    <!--begin::Close-->
                    <button type="button"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                        data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-2x svg-icon-danger">
                            <i class="bi bi-x"></i>
                        </span>
                    </button>
                    <!--end::Close-->
                </div>
            @endif
            <div class="table-responsive">
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-75px">Actions</th>
                            <th class="min-w-100px">Tahun Akademik</th>
                            <th class="min-w-100px">Keterangan</th>
                            <th class="min-w-100px">Tanggal Mulai</th>
                            <th class="min-w-100px">Tanggal Akhir</th>
                            <th class="min-w-75px">Status</th>
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

    @include('proposal.pelaksanaan.scripts.list')
@endsection
