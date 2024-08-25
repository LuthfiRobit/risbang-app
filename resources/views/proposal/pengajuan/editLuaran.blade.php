<div class="modal fade" id="edit_luaran_penelitian" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit_luaran_penelitian">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal Penelitian</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Judul Jurnal Penelitian</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_judul_luaran_penelitian" id="edit_judul_luaran_penelitian"
                                placeholder="Masukkan Judul Jurnal" minlength="3" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Penerbitan</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_rencana_penerbitan_luaran_penelitian"
                                id="edit_rencana_penerbitan_luaran_penelitian"
                                placeholder="Masukkan Rencana Penerbitan Jurnal" minlength="2" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Tingkat Publikasi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="edit_jenis_publikasi_luaran_penelitian"
                                id="edit_jenis_publikasi_luaran_penelitian" data-live-search="true"
                                title="Pilih Tingkat Publikasi" required>
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                                <option value="Nasional Tidak Terakreditasi">Nasional Tidak Terakreditasi</option>
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


<div class="modal fade" id="edit_luaran_pengabdian" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit_luaran_pengabdian" data-id="{{ Route::current()->parameter('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal Pengabdian</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Judul Jurnal Pengabdian</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_judul_luaran_pengabdian" id="edit_judul_luaran_pengabdian"
                                placeholder="Masukkan Judul Jurnal" minlength="3" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Penerbitan</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_rencana_penerbitan_luaran_pengabdian"
                                id="edit_rencana_penerbitan_luaran_pengabdian"
                                placeholder="Masukkan Rencana Penerbitan Jurnal" minlength="2" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Tingkat Publikasi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm"
                                name="edit_jenis_publikasi_luaran_pengabdian"
                                id="edit_jenis_publikasi_luaran_pengabdian" data-live-search="true"
                                title="Pilih Tingkat Publikasi" required>
                                <option value="Internasional">Internasional</option>
                                <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                                <option value="Nasional Tidak Terakreditasi">Nasional Tidak Terakreditasi</option>
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


<div class="modal fade" id="edit_luaran_haki" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit_luaran_haki" data-id="{{ Route::current()->parameter('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Haki</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Judul Haki</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_judul_luaran_haki"
                                id="edit_judul_luaran_haki" placeholder="Masukkan Judul Haki" minlength="3"
                                required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Target Kategori</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_jenis_luaran_haki"
                                id="edit_jenis_luaran_haki" data-live-search="true" title="Pilih Target Kategori"
                                required>
                                <option value="Haki">Haki</option>
                                <option value="Merk">Merk</option>
                                <option value="Paten">Paten</option>
                                <option value="Rahasia Dagang">Rahasia Dagang</option>
                                <option value="Desain Industri">Desain Industri</option>
                                <option value="Indikasi Geografis">Indikasi Geografis</option>
                                <option value="Desain Tata Letak Sirkuit Terpadu">Desain Tata Letak Sirkuit Terpadu
                                </option>
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

<div class="modal fade" id="edit_luaran_buku" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit_luaran_buku" data-id="{{ Route::current()->parameter('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Judul Buku</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_judul_luaran_buku"
                                id="edit_judul_luaran_buku" placeholder="Masukkan Judul Buku" minlength="3"
                                required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rencana Jenis Buku</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_jenis_luaran_buku"
                                id="edit_jenis_luaran_buku" data-live-search="true" title="Pilih Jenis Luaran Buku"
                                required>
                                <option value="Buku Ajar">Buku Ajar</option>
                                <option value="Buku Referensi">Buku Referensi</option>
                                <option value="Monograf">Monograf</option>
                                <option value="Modul Ajar">Modul Ajar</option>
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
