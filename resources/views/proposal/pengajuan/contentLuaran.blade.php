<!--begin::Timeline-->
<div class="card mt-5 mt-xxl-8">
    <!--begin::Card head-->
    <div class="card-header card-header-stretch">
        <!--begin::Title-->
        <div class="card-title d-flex align-items-center">
            <div class="d-flex flex-column">
                <h3 class="fw-bolder m-0 text-gray-800">Luaran Penelitian dan Pengabdian</h3>
                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                    Lengkapi luaran sesuai dengan ketentuan yang ada</span>
            </div>
        </div>
        <!--end::Title-->
        <!--begin::Toolbar-->
        <div class="card-toolbar m-0">
            <!--begin::Tab nav-->
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bolder" role="tablist">
                <li class="nav-item" role="presentation">
                    <a id="kt_tab_luaran_wajib_tab" class="nav-link justify-content-center text-active-gray-800 active"
                        data-bs-toggle="tab" role="tab" href="#kt_tab_luaran_wajib">Luaran
                        Wajib</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a id="kt_tab_luaran_tambahan_tab" class="nav-link justify-content-center text-active-gray-800"
                        data-bs-toggle="tab" role="tab" href="#kt_tab_luaran_tambahan">Luaran Tambahan</a>
                </li>
            </ul>
            <!--end::Tab nav-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Card head-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Tab Content-->
        <div class="tab-content">
            <!--begin::Tab panel-->
            <div id="kt_tab_luaran_wajib" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                aria-labelledby="kt_tab_luaran_wajib_tab">
                <div class="row" id="show_luaran_wajib" data-id="{{ Route::current()->parameter('id') }}">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                            </div>
                            <div class="fw-bold ms-5 text-gray-600" id="show_luaran_penelitian"
                                data-id="{{ Route::current()->parameter('id') }}">
                            </div>
                            <div class="d-flex mb-4">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_penelitian"
                                    id="btn_tambah_luaran_penelitian">
                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_penelitian"
                                    id="btn_edit_luaran_penelitian">
                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                    data-bs-toggle="modal" data-bs-target="#hapus_luaran_penelitian"
                                    id="btn_hapus_luaran_penelitian">
                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                            </div>
                            <div class="fw-bold ms-5 text-gray-600"id="show_luaran_pengabdian"
                                data-id="{{ Route::current()->parameter('id') }}">
                            </div>
                            <div class="d-flex mb-4">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_pengabdian"
                                    id="btn_tambah_luaran_pengabdian">
                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_pengabdian"
                                    id="btn_edit_luaran_pengabdian">
                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                    data-bs-toggle="modal" data-bs-target="#hapus_luaran_pengabdian"
                                    id="btn_hapus_luaran_pengabdian">
                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                            </div>
                            <div class="fw-bold ms-5 text-gray-600" id="show_luaran_haki"
                                data-id="{{ Route::current()->parameter('id') }}">
                            </div>
                            <div class="d-flex mb-4">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                                    data-bs-toggle="modal" data-bs-target="#tambah_luaran_haki"
                                    id="btn_tambah_luaran_haki">
                                    <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                    data-bs-toggle="modal" data-bs-target="#edit_luaran_haki"
                                    id="btn_edit_luaran_haki">
                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                                <a class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger me-3"
                                    id="btn_hapus_luaran_haki">
                                    <span class="bi bi-trash" aria-hidden="true"></span> Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Tab panel-->
            <!--begin::Tab panel-->
            <div id="kt_tab_luaran_tambahan" class="card-body p-0 tab-pane fade show" role="tabpanel"
                aria-labelledby="kt_tab_luaran_tambahan_tab">
                <div class="row" id="show_luaran_tambahan" data-id="{{ Route::current()->parameter('id') }}">
                    <div class="text-center">
                        <a href="#"
                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary me-3"
                            data-bs-toggle="modal" data-bs-target="#tambah_luaran_buku">
                            <span class="bi bi-plus" aria-hidden="true"></span> Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table id="example_luaran_buku" data-id="{{ Route::current()->parameter('id') }}"
                            class="table table-row-dashed table-row-gray-500 align-middle gs-0 gy-3 dt-responsive"
                            style="width:100%;">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0 ">
                                    <th class="w-25px"></th>
                                    <th class="min-w-75px">Actions</th>
                                    <th class="min-w-175px">Rencana Judul Buku</th>
                                    <th class="min-w-75px">Rencana Jenis Buku</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 fw-bolder">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Tab panel-->
        </div>
        <!--end::Tab Content-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Timeline-->
