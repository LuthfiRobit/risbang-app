@extends('layout.main4')

@section('css-for-this-page')
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
    {{-- <style type="text/css">
        .custom-select {
            display: inline-block;
            width: 100%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            vertical-align: middle;
            background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") no-repeat right 0.75rem center/8px 10px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style> --}}
@endsection

@section('content')
    <div class="content flex-column-fluid">
        <div class="card mb-xl-8 mb-5 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1 ">Tambah User</span>
                </h3>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body py-3">
                <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                    <div class="d-flex flex-stack">
                        <div class="row">
                            <span class="fs-12 text-gray-700">Lengkapi Data User Dengan Benar.</span>
                            <div class="row">
                                <span style="color: #a1081f; font-weight: 500;">*) Field Wajib Diisi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="post" id="bt_submit_create">
                    <div class="form-group d-flex mb-8 row">
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Dosen</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" placeholder="Masukkan Nama Dosen"
                                name="nama_lengkap" required />
                        </div>
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tempat Lahir</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" placeholder="Masukkan Tempat Lahir"
                                name="tempat_lahir" required />
                        </div>
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tanggal Lahir</span>
                            </label>
                            <!--end::Label-->
                            <input type="date" class="form-control form-control-sm" placeholder="Masukkan Tanggal Lahir"
                                name="tgl_lahir" required />
                        </div>
                    </div>
                    <div class="form-group d-flex mb-8 row">
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">No. Telepon</span>
                            </label>
                            <!--end::Label-->
                            <input
                                oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onkeydown="return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                                type="text" maxlength="15" id="telepon" class="form-control form-control-sm"
                                placeholder="Masukkan No. Telepon" required>
                        </div>
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold required mb-2" for="id_role">
                                <span>Role</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm custom-select bg-white" id="id_role"
                                data-live-search="true" title="Role" required>
                                {{-- @foreach ($role as $item)
                                        <option value="{{ $item->id_role }}">{{ $item->role }}</option>
                                    @endforeach --}}
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold required mb-2" for="email">
                                <span>Email</span>
                            </label>
                            <input type="email" id="email" class="form-control form-control-sm"
                                placeholder="Masukkan Email" required>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="text-center">
                            <button type="reset" class="btn btn-sm btn-dark">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-for-this-page')
    {{-- <script src="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/custom/select/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/select/bootstrap-select.min.js') }}"></script>
@endsection
