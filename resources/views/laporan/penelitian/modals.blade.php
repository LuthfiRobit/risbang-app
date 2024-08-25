<div class="modal fade" id="create_penulis_luar" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="form_penulis_luar">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penulis Luar</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Dosen</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nama_luar" id="nama_luar"
                                placeholder="Masukkan Nama Dosen" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">NIDN</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nidn_luar" id="nidn_luar"
                                placeholder="Masukkan NIDN" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Pendidikan Terakhir</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="pendidikan_terakhir_luar"
                                id="pendidikan_terakhir_luar" placeholder="Masukkan Pendidikan Terakhir" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis Kelamin</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="jk_luar" id="jk_luar"
                                data-live-search="true" title="Pilih Jenis Kelamin">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">No. Telepon</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="no_tlpn_luar"
                                id="no_tlpn_luar" placeholder="Masukkan No. Telepon" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Kampus</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="kampus_luar"
                                id="kampus_luar" placeholder="Masukkan Nama Kampus" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Alamat Kampus</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Alamat Kampus" name="alamat_kampus_luar"
                                id="alamat_kampus_luar" rows="3" required></textarea>
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

<div class="modal fade" id="create_penulis_lain" data-backdrop="static" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="form_penulis_lain">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Penulis Lain</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Penulis</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nama_lain"
                                id="nama_lain" placeholder="Masukkan Nama Penulis" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">NIK</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nik_lain"
                                id="nik_lain" placeholder="Masukkan NIK" maxlength="16" minlength="16" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Pendidikan Terakhir</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="pendidikan_terakhir_lain" id="pendidikan_terakhir_lain"
                                placeholder="Masukkan Pendidikan Terakhir" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis Kelamin</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="jk_lain" id="jk_lain"
                                data-live-search="true" title="Pilih Jenis Kelamin">
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">No. Telepon</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="no_tlpn_lain"
                                id="no_tlpn_lain" placeholder="Masukkan No. Telepon" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Alamat</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Masukkan Alamat" name="alamat_lain" id="alamat_lain"
                                rows="3" required></textarea>
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
