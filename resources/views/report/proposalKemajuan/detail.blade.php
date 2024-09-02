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
                                    <span class="fs-6 fw-bold">Status</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_status" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
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
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Berkas</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span>
                                    <a id="show_berkas" target="_blank" class="text-primary text-hover-success d-none">
                                        <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                        Lihat Berkas
                                    </a>
                                    <span id="no_berkas" class="d-none text-decoration-line-through">Tidak ada
                                        berkas</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class="fs-2 fw-bold text-decoration-underline">Skor</span>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-8">
                                    <span class="fs-6 fw-bold">Skor Publikasi ilmiah/jurnal (50%)</span>
                                </div>
                                <div class="col-4">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_skor_publikasi"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-8">
                                    <span class="fs-6 fw-bold">Skor Sebagai pemakalah dalam temu ilmiah lokal/nasional
                                        (20%)</span>
                                </div>
                                <div class="col-4">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_skor_pemakalah"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-8">
                                    <span class="fs-6 fw-bold">Skor Bahan ajar (20%)</span>
                                </div>
                                <div class="col-4">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_skor_bahan"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-8">
                                    <span class="fs-6 fw-bold">Skor TTG produk/model/purwarupa/desain/karya
                                        seni/rekayasa sosia (10%)</span>
                                </div>
                                <div class="col-4">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_skor_ttg"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-8">
                                    <span class="fs-6 fw-bold">Skor Total</span>
                                </div>
                                <div class="col-4">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_nilai" class="mb-0"></span>
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
