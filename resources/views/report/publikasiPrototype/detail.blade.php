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
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nama Dosen</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_dosen" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Program Studi</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_prodi" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Fakultas</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_fakultas" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Jenis</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_jenis" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Judul</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_judul" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Tahun Pelaksanaan</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_tahun_pelaksanaan"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">TKT</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_tkt" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Level</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_level" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Deskripsi</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_deskripsi" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Berkas</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span>
                                    <a id="show_file" target="_blank" class="text-primary text-hover-success d-none">
                                        <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                        Lihat berkas
                                    </a>
                                    <span id="no_file" class="d-none text-decoration-line-through">Tidak ada
                                        berkas</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Cover</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span>
                                    <a id="show_cover" target="_blank"
                                        class="text-primary text-hover-success d-none">
                                        <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                        Lihat cover
                                    </a>
                                    <span id="no_cover" class="d-none text-decoration-line-through">Tidak ada
                                        cover</span>
                                </div>
                            </div>
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
