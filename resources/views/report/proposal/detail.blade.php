<div class="modal fade" id="form_detail" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Beserta Nilai Review</h5>
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
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Rencana Dana</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_dana" class="mb-0"></span>
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
                                    <span class="fs-6 fw-bold">Nilai Judul</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold" id="show_nilai_judul"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Abstrak</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_abstrak" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Abstrak</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_abstrak" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Kata Kunci</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_katkun" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Kata Kunci</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_katkun" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Latar Belakang</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_latbel" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Latar Belakang</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_latbel" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Metode</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_metode" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Metode</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_metode" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Rencana</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_rencana"
                                        class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Rencana</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_rencana" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Daftar Pustaka</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span id="show_dapus" class="mb-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <span class="fs-6 fw-bold">Nilai Daftar Pustaka</span>
                                </div>
                                <div class="col-9">
                                    <span class="fs-6 fw-bold">:</span> <span class="fs-6 fw-bold"
                                        id="show_nilai_dapus" class="mb-0"></span>
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
                                    <a id="show_berkas" target="_blank"
                                        class="d-flex align-items-center text-primary text-hover-success">
                                        <span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span>
                                        Lihat Berkas
                                    </a>
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
