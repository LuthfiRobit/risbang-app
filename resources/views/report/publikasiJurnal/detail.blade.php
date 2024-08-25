<div class="modal fade" id="form_detail" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
            </div>
            <div class="modal-body">
                <div id="null_data" style="display: none;">
                    <h3>Data not found</h3>
                </div>
                <div id="show_data" style="display: none;">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Nama Dosen</span>
                            </label>
                            <p id="show_dosen"></p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Program Studi</span>
                            </label>
                            <p id="show_prodi"></p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Fakultas</span>
                            </label>
                            <p id="show_fakultas"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Jenis</span>
                            </label>
                            <p id="show_jenis"></p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Peringkat Publikasi</span>
                            </label>
                            <p id="show_kategori"></p>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Tingkat Publikasi</span>
                            </label>
                            <p id="show_peringkat"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Judul : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_judul"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Penerbit : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_penerbit"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Pelaksanaan : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_pelaksanaan"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Publish : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_publish"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Halaman : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_halaman"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">ISSN : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_issn"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Volume : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_volume"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Nomor : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_nomor"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Abstrak : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <p id="show_abstrak"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Link : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <a id="show_link" target="_blank"
                                class="d-flex align-items-center text-primary text-hover-success">
                                ---
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <span class="d-flex align-items-center fs-6 fw-bold mb-2">Berkas : </span>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-9">
                            <a id="show_berkas" target="_blank"
                                class="d-flex align-items-center text-primary text-hover-success">
                                <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                Lihat Berkas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
