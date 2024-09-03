<!--begin::Timeline-->
<div class="card mt-5 mt-xxl-8">
    <!--begin::Card head-->
    <div class="card-header card-header-stretch">
        <!--begin::Title-->
        <div class="card-title d-flex align-items-center">
            <div class="d-flex flex-column">
                <h3 class="fw-bolder m-0 text-gray-800">Surat Tugas</h3>
                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                    Silahkan lengkapi surat tugas yang dibutuhkan</span>
            </div>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Card head-->
    <!--begin::Card body-->
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="notice d-flex bg-light-success border-success mb-3 rounded border border-dashed p-3">
                    <div class="d-flex flex-stack">
                        <div class="row">
                            <span class="fs-12 text-gray-700">Catatan:</span>
                            <div class="row">
                                <span style="color: #a1081f; font-weight: 500;">- Klik edit untuk mengisi atau mengganti
                                    tanggal dan tempat</span>
                                <span style="color: #a1081f; font-weight: 500;">- Download surat tugas</span>
                                <span style="color: #a1081f; font-weight: 500;">- Lakukan stempel secara manual di
                                    LP2M</span>
                                <span style="color: #a1081f; font-weight: 500;">- Upload surat berstempel dengan format
                                    PDF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="show_surat_tugas" data-id="{{ Route::current()->parameter('id') }}">
            <div class="col-lg-12 col-md-12 col-sm-12" id="show_st_penelitian">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                            </div>
                            <div class="fw-bold ms-5 text-gray-600" data-id="{{ Route::current()->parameter('id') }}">
                                <div class='fs-5' id='jenis_luaran'>Surat Tugas Penelitian</div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul :
                                    <span class='text-gray-400' id='show_st_judul_penelitian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Tanggal :
                                    <span class='text-gray-400' id='show_st_tanggal_penelitian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Tempat :
                                    <span class='text-gray-400' id='show_st_tempat_penelitian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2 d-flex align-items-center'>
                                    Download :
                                    <span class='ms-2 text-gray-400' id='download_penelitian'></span>
                                </div>
                            </div>
                            <div class="d-flex mb-4">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                    data-bs-toggle="modal" data-bs-target="#edit_st_penelitian"
                                    id="btn_edit_st_penelitian">
                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                        <form method="post" id="upload_st_penelitian" enctype="multipart/form-data"
                            class="p-1 rounded border border-dashed border-primary">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Surat Tugas Tersetempel *)</span>
                                        <span id="show_surat_penelitian"></span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="surat"
                                        id="surat" placeholder="Masukkan surat tugas yang telah disetempel"
                                        accept=".pdf," required />
                                    <ul id="error-surat_penelitian" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 text-end">
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" id="show_st_pengabdian">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="d-flex flex-stack position-relative mt-8">
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0">
                            </div>
                            <div class="fw-bold ms-5 text-gray-600" data-id="{{ Route::current()->parameter('id') }}">
                                <div class='fs-5' id='jenis_luaran'>Surat Tugas Pengabdian</div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul :
                                    <span class='text-gray-400' id='show_st_judul_pengabdian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Tanggal :
                                    <span class='text-gray-400' id='show_st_tanggal_pengabdian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2'>Tempat :
                                    <span class='text-gray-400' id='show_st_tempat_pengabdian'>---</span>
                                </div>
                                <div class='fs-5 fw-bolder text-gray-800 mb-2 d-flex align-items-center'>
                                    Download :
                                    <span class='ms-2 text-gray-400' id='download_pengabdian'></span>
                                </div>
                            </div>
                            <div class="d-flex mb-4">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-success btn-active-light-success me-3"
                                    data-bs-toggle="modal" data-bs-target="#edit_st_pengabdian"
                                    id="btn_edit_st_pengabdian">
                                    <span class="bi bi-pencil" aria-hidden="true"></span> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                        <form method="post" id="upload_st_pengabdian" enctype="multipart/form-data"
                            class="p-1 rounded border border-dashed border-primary">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-md-8 col-lg-8">
                                    <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Surat Tugas Tersetempel *)</span>
                                        <span id="show_surat_pengabdian"></span>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" name="surat"
                                        id="surat" placeholder="Masukkan surat tugas yang telah disetempel"
                                        accept=".pdf," required />
                                    <ul id="error-surat_pengabdian" class="list-unstyled text-danger"></ul>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 text-end">
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Timeline-->
