<div class="modal fade" id="review_luaran_penelitian" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_review_luaran_penelitian">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Luaran</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Komentar Luaran</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_penelitian"
                                id="komen_luaran_penelitian" rows="3" required></textarea>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nilai Luaran</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" name="nilai_luaran_penelitian"
                                id="nilai_luaran_penelitian" placeholder="Masukkan Nilai" required min="10"
                                max="100" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keputusan Reviewer</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="keputusan_reviewer_luaran_penelitian" id="keputusan_reviewer_luaran_penelitian"
                                data-live-search="true" title="Pilih Keputusan">
                                <option value="Ditolak">Tolak</option>
                                <option value="Direvisi">Revisi</option>
                                <option value="Diterima">Terima</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="review_luaran_pengabdian" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_review_luaran_pengabdian">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Luaran</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Komentar Luaran</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_pengabdian"
                                id="komen_luaran_pengabdian" rows="3" required></textarea>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nilai Luaran</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" name="nilai_luaran_pengabdian"
                                id="nilai_luaran_pengabdian" placeholder="Masukkan Nilai" required min="10"
                                max="100" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keputusan Reviewer</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="keputusan_reviewer_luaran_pengabdian" id="keputusan_reviewer_luaran_pengabdian"
                                data-live-search="true" title="Pilih Keputusan">
                                <option value="Ditolak">Tolak</option>
                                <option value="Direvisi">Revisi</option>
                                <option value="Diterima">Terima</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="review_luaran_haki" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_review_luaran_haki">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Luaran</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Komentar Luaran</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_haki"
                                id="komen_luaran_haki" rows="3" required></textarea>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nilai Luaran</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" name="nilai_luaran_haki"
                                id="nilai_luaran_haki" placeholder="Masukkan Nilai" required min="10"
                                max="100" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keputusan Reviewer</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="keputusan_reviewer_luaran_haki" id="keputusan_reviewer_luaran_haki"
                                data-live-search="true" title="Pilih Keputusan">
                                <option value="Ditolak">Tolak</option>
                                <option value="Direvisi">Revisi</option>
                                <option value="Diterima">Terima</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="review_luaran_buku" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_review_luaran_buku">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review Luaran</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Komentar Luaran</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Komentar" name="komen_luaran_buku"
                                id="komen_luaran_buku" rows="3" required></textarea>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nilai Luaran</span>
                            </label>
                            <input type="number" class="form-control form-control-sm" name="nilai_luaran_buku"
                                id="nilai_luaran_buku" placeholder="Masukkan Nilai" required min="10"
                                max="100" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keputusan Reviewer</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="keputusan_reviewer_luaran_buku" id="keputusan_reviewer_luaran_buku"
                                data-live-search="true" title="Pilih Keputusan">
                                <option value="Ditolak">Tolak</option>
                                <option value="Direvisi">Revisi</option>
                                <option value="Diterima">Terima</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
