@extends('layout.main4')
@section('title-one', 'Halaman Kelola Roadmap Dosen')
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
                <span class="card-label fw-bolder fs-3 mb-1 ">List Data Roadmap Dosen</span>
            </h3>
            <div class="card-toolbar">
                @if (Auth::user()->dosen_role == 'dosen')
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_create"
                            aria-label="Close" data-dismiss="modal" title='Create'><i class="bi bi-plus-circle"></i> Tambah
                            Roadmap Dosen</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body py-3">
            <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="d-flex flex-stack">
                    <div class="row">
                        <span class="fs-12 text-gray-700">Berikut ini adalah list data roadmap dosen.
                        </span>
                        <div class="row">
                            @if (Auth::user()->dosen_role == 'dosen')
                                <span style="color: #a1081f; font-weight: 500;">Silahkan buat roadmap dan lakukan revisi
                                    jika
                                    belum di-acc </span>
                            @elseif(Auth::user()->dosen_role == 'kaprodi')
                                <span style="color: #a1081f; font-weight: 500;">Silahkan cek dan lakukan komentar pada
                                    roadmap
                                    dosen </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->dosen_role == 'dosen')
                <div class="accordion mb-3" id="kt_accordion_1">
                    <div class="accordion-item">
                        <h6 class="accordion-header bg-light-success border-success rounded border border-dashed p-0"
                            id="kt_accordion_1_header_1">
                            <button class="accordion-button fs-12 fw-bolder p-4" type="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_accordion_1_body_1" aria-expanded="true"
                                aria-controls="kt_accordion_1_body_1">
                                List rujukan roadmap program studi.
                            </button>
                        </h6>
                        <div id="kt_accordion_1_body_1" class="accordion-collapse collapse"
                            aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                            <div class="accordion-body p-0">
                                <div class="row p-3 g-3">
                                    @foreach ($roadmapProdi as $item)
                                        <div class="col-4">
                                            <div class="rounded border border-primary text-center p-2">
                                                <a href="{{ $item['berkas'] }}" target="_blank"
                                                    class="text-primary text-hover-success">
                                                    <span class="svg-icon svg-icon-4 me-1"><i
                                                            class="bi bi-download"></i></span>
                                                    {{ $item['nama_roadmap'] }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
                <table id="example" class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                    style="width:100%;">
                    <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-25px">Actions</th>
                            @if (Auth::user()->dosen_role == 'dosen')
                                {{-- dosen viiew --}}
                                <th class="min-w-100px">Tgl. Upload</th>
                                <th class="min-w-100px">Rentan Waktu </th>
                                {{-- dosen viiew --}}
                            @elseif(Auth::user()->dosen_role == 'kaprodi')
                                {{-- prodi view --}}
                                <th class="min-w-100px">NIDN</th>
                                <th class="min-w-100px">Nama Dosen</th>
                                <th class="min-w-100px">Prodi</th>
                                {{-- prodi view --}}
                            @endif
                            <th class="min-w-100px">Jenis</th>
                            <th class="min-w-100px">Berkas</th>
                            <th class="min-w-100px">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (Auth::user()->dosen_role == 'dosen')
        @include('roadmap.dosen.create')
        @include('roadmap.dosen.edit')
    @endif
    @if (Auth::user()->dosen_role == 'kaprodi')
        @include('roadmap.dosen.review')
    @endif
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

    @include('roadmap.dosen.scripts.list')
    @if (Auth::user()->dosen_role == 'dosen')
        @include('roadmap.dosen.scripts.create')
        @include('roadmap.dosen.scripts.edit')
    @endif
    @if (Auth::user()->dosen_role == 'kaprodi')
        @include('roadmap.dosen.scripts.review')
    @endif
@endsection
