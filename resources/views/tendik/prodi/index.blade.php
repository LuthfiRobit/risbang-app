@extends('layout.main4')
@section('title-one', 'Tendik | Data Prodi')
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
                <span class="card-label fw-bolder fs-3 mb-1 ">List Program Studi</span>
            </h3>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a type="button" class="btn btn-sm btn-primary me-2" data-toggle="modal" data-target="#form_import"
                        aria-label="Close" data-dismiss="modal" title='Import'><i
                            class="bi bi-file-earmark-excel"></i>Import
                        Program Studi</a>
                    <a type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form_create"
                        aria-label="Close" data-dismiss="modal" title='Create'><i class="bi bi-plus-circle"></i>Tambah
                        Program Studi</a>
                </div>
            </div>
        </div>
        <div class="card-body py-3">
            <div class=" bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                <div class="row g-2">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Berikut ini adalah daftar dari Program Studi data.
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Data Program Studi tidak aktif</span>
                            <span style="color: #0b7a44 ; font-weight: 500;">Data Program Studi aktif</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <span class="fs-12 text-gray-700">Catatan :
                        </span>
                        <div class="row">
                            <span style="color: #a1081f; font-weight: 500;">Tentukan kaprodi pada menu <a
                                    href="{{ route('setting.dosen.management.index') }}">Dosen
                                    Management</a></span>
                            <span style="color: #0b7a44 ; font-weight: 500;">
                                <a href="{{ route('tendik.prodi.export.excel') }}"
                                    class=" text-primary text-hover-success me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-download"></i></span>Export Data
                                    Prodi (Excel)
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <select class="selectpicker form-control form-control-sm" name="filter_fakultas" id="filter_fakultas"
                        data-live-search="true" title="Pilih Fakultas">
                        <option value="">Semua</option>
                        @foreach ($fakultas as $item)
                            <option value="{{ $item->id_fakultas }}">{{ $item->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <select class="selectpicker form-control form-control-sm" name="filter_aktifasi" id="filter_aktifasi"
                        data-live-search="true" title="Pilih Aktifasi" required>
                        <option value="">Semua</option>
                        <option value="y">Aktif</option>
                        <option value="t">Tidak Aktif</option>
                    </select>
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
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                            {{-- <th class="w-25px"></th> --}}
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input bg-primary" type="checkbox" data-kt-check="true"
                                        data-kt-check-target=".widget-13-check" name="select_all">
                                </div>
                            </th>
                            <th class="min-w-50px">Actions</th>
                            <th class="min-w-50px">Fakultas</th>
                            <th class="min-w-125px">Program Studi</th>
                            <th class="min-w-50px">Singkatan</th>
                            <th class="min-w-125px">Kaprodi</th>
                            <th class="min-w-50px">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 fw-bolder">
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button class="btn btn-sm btn-primary" id="active" title='Aktifkan Data'>Aktif</button>
                <button class="btn btn-sm btn-danger" id="block" title='Non Aktifkan Data'>Tidak Aktif</button>
            </div>
        </div>
    </div>
    @include('tendik.prodi.create')
    @include('tendik.prodi.detail')
    @include('tendik.prodi.edit')
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

    @include('tendik.prodi.scripts.list')
    @include('tendik.prodi.scripts.detail')
    @include('tendik.prodi.scripts.create')
    @include('tendik.prodi.scripts.edit')
    @include('tendik.prodi.scripts.activation')
@endsection
