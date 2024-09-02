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
                                    <span class="fs-6 fw-bold">Kategori Haki</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_kategori" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Jenis Haki</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_jenis_haki"
                                        class="mb-0"></span>
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Pemegang</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_pemegang" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Pelaksanaan</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_pelaksanaan"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Publish</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_publish"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nomor</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_nomor" class="mb-0"></span>
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
                                    <span class="fs-6 fw-bold">:</span> <span id="show_deskripsi"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Link</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span>
                                    <a id="show_link" target="_blank" class="text-primary text-hover-success">
                                        ---
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Berkas</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span>
                                    <a id="show_berkas" target="_blank"
                                        class="text-primary text-hover-success d-flex align-items-center">
                                        <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                        Lihat Berkas
                                    </a>
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
