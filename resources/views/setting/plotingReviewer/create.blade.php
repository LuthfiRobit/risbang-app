@extends('layout.main4')
@section('title-one', 'Setting | Ploting Reviewer')
@section('css-for-this-page')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/select/bootstrap-select.min.css') }}">
@endsection

@section('content')

    <form method="POST" id="form_create" enctype="multipart/form-data">
        {{-- <form method="POST" id="form_create" enctype="multipart/form-data"
        action="{{ route('setting.ploting.reviewer.store') }}">
        @csrf --}}
        <input type="hidden" id="in-ta" name="id_ta" value="{{ Request::query('ta') }}">
        <input type="hidden" id="in-rv" name="id_rv" value="{{ Request::query('rv') }}">
        <div class="card mb-xl-8 mb-5 border-2">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-uppercase fs-3 mb-1 ">
                        Ploting Reviewer <span class="border-danger rounded border border-dashed" style="color: #a1081f;">
                            {{ $reviewer->nama_reviewer }}</span> |
                        Tahun Akademik <span class="border-danger rounded border border-dashed" style="color: #a1081f;">
                            {{ $tahun_akademik->nama_tahun_akademik }}</span>
                    </span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3">
                    <div class="d-flex flex-stack">
                        <div class="row">
                            <span class="fs-12 text-gray-700">Berikut adalah list dosen yang terploting untuk
                                reviewer</span>
                            <div class="row">
                                <span style="color: #a1081f; font-weight: 500;">List dosen terploting</span>
                                <span style="color: #0b7a44 ; font-weight: 500;">List dosen belum terploting</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="separator border-danger border-2 my-3"></div>
                    <span style="color: #a1081f; font-weight: 500;">List dosen terploting</span>
                    <div class="separator border-danger border-2 my-3"></div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table id="tabel_dosen_ploted"
                                class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                                style="width:100%;">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-25px">Actions</th>
                                        <th class="min-w-100px">Nama Dosen</th>
                                        <th class="min-w-100px">Program Studi</th>
                                        <th class="min-w-100px">Fakultas</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="separator border-danger border-2 my-3"></div>
                    <span style="color: #a1081f; font-weight: 500;">List dosen belum terploting</span>
                    <div class="separator border-danger border-2 my-3"></div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table id="tabel_dosen_unploted"
                                class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3"
                                style="width:100%;">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                                        {{-- <th class="w-25px"></th> --}}
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input bg-primary" type="checkbox"
                                                    data-kt-check="true" data-kt-check-target=".widget-13-check"
                                                    name="select_all">
                                            </div>
                                        </th>
                                        {{-- <th class="min-w-50px">Actions</th> --}}
                                        <th class="min-w-100px">Nama Dosen</th>
                                        <th class="min-w-100px">Program Studi</th>
                                        <th class="min-w-100px">Fakultas</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-800 fw-bolder">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-xl-8 mt-0 border-2">
            <div class="card-body py-3 text-center">
                {{-- <button type="button" class="btn btn-sm btn-danger">Batal</button> --}}
                <button id="btn_store" type="submit" class="btn btn-sm btn-primary" disabled>Simpan</button>
            </div>
        </div>
    </form>
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

    @include('setting.plotingReviewer.scripts.listPloted')
    @include('setting.plotingReviewer.scripts.listUnploted')
    <script>
        $("#btn_store").click(function() {
            if (rows_selected.length > 0) {
                $("#btn_store").prop("disabled", true);
                const input = {
                    "id_dosen": rows_selected,
                    "id_ta": $("#in-ta").val(),
                    "id_rv": $("#in-rv").val()
                };
                DataManager.postData('{{ route('setting.ploting.reviewer.store') }}', input).then(
                        response => {
                            if (response.success) {
                                Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire('Oops...', response.message, 'error');
                            }
                            $("#btn_store").prop("disabled", false);
                        })
                    .catch(error => {
                        $("#btn_store").prop("disabled", false);
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        });
    </script>
    <script>
        function deleteConfirmation(dsn) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Ini akan dihapus secara permanen!",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Silakan tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    const destroy = '{{ route('setting.ploting.reviewer.destroy.ploted', [':dsn']) }}';
                    DataManager.deleteData(destroy.replace(':dsn', dsn)).then(response => {
                            if (response.success) {
                                Swal.fire('Success', "Data berhasil dihapus", 'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire('Oops...', response.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });

                }
            });
        }
    </script>
@endsection
