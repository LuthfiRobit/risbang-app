<!--begin::Timeline-->
<div class="card mt-5 mt-xxl-8">
    <!--begin::Card head-->
    <div class="card-header card-header-stretch">
        <!--begin::Title-->
        <div class="card-title d-flex align-items-center">
            <div class="d-flex flex-column">
                <h3 class="fw-bolder m-0 text-gray-800">Kontrak / MoA</h3>
                <span class="d-flex align-items-center text-gray-400 me-5 mb-2 fs-8">
                    Silahkan download MoA dan lengkapi data sesuai dengan kebutuhan penelitian
                    dan pengabdian</span>
            </div>
        </div>
        <!--end::Title-->
    </div>
    <!--end::Card head-->
    <!--begin::Card body-->
    <div class="card-body">
        <div class="row g-2">
            <div class="col-12">
                <div class="notice d-flex bg-light-success border-success mb-3 rounded border border-dashed p-3">
                    <div class="d-flex flex-stack">
                        <div class="row">
                            <span class="fs-12 text-gray-700">Catatan:</span>
                            <div class="row">
                                <span style="color: #a1081f; font-weight: 500;">Download template dibawah, kemudian
                                    upload kontrak/MoA penelitian atau pengabdian yang telah disetujui pada
                                    masing-masing form</span>
                                <span style="color: #0b7a44 ; font-weight: 500;">
                                    <a href="#" target="_blank"
                                        class="d-flex align-items-center text-primary text-hover-success me-5 mb-2">
                                        <span class="svg-icon svg-icon-4 me-1"><i
                                                class="bi bi-download me-2"></i></span>
                                        Template kontrak/MoA</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" id="show_sk_penelitian">
                <form method="post" id="upload_sk_penelitian" enctype="multipart/form-data"
                    class="p-3 rounded border border-primary">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Surat Kontrak/Moa Penelitian *)</span>
                                <span id="show_kontrak_penelitian"></span>
                            </label>
                            <input type="file" class="form-control form-control-sm" name="kontrak" id="kontrak"
                                placeholder="Masukkan kontrak/MoU yang telah disetempel" accept=".pdf," required />
                            <ul id="error-kontrak_penelitian" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 text-end">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12" id="show_sk_pengabdian">
                <form method="post" id="upload_sk_pengabdian" enctype="multipart/form-data"
                    class="p-3 rounded border border-danger">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <label class="d-flex justify-content-between align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Surat Kontrak/Moa Pengabdian *)</span>
                                <span id="show_kontrak_pengabdian"></span>
                            </label>
                            <input type="file" class="form-control form-control-sm" name="kontrak" id="kontrak"
                                placeholder="Masukkan kontrak/Mou tugas yang telah disetempel" accept=".pdf,"
                                required />
                            <ul id="error-kontrak_pengabdian" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4 text-end">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Card body-->
</div>
<!--end::Timeline-->
