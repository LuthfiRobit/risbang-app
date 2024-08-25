<div class="modal fade" id="form_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_data_exampleModalLabel">Edit</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tahun Akademik</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_tahun_akademik"
                                id="edit_data_tahun_akademik" data-live-search="true" title="Pilih Tahun Akademik"
                                data-size="5" required>
                                @foreach ($tahunAkademik as $item)
                                    <option value="{{ $item->id_tahun_akademik }}">{{ $item->nama_tahun_akademik }}
                                    </option>
                                @endforeach
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis Deadline</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_jenis"
                                id="edit_data_jenis" data-live-search="true" title="Pilih Jenis Deadline" required>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengabdian">Pengabdian</option>
                                {{-- <option value="Prosiding">Prosiding</option>
                                <option value="Buku">Buku</option>
                                <option value="Laporan">Laporan</option>
                                <option value="Haki">Haki</option> --}}
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keterangan Dedaline</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_keterangan"
                                id="edit_data_keterangan" data-live-search="true" title="Pilih Keterangan Deadline"
                                required>
                                <option value="Proposal">Proposal</option>
                                <option value="Kemajuan">Kemajuan</option>
                                <option value="Akhir">Akhir</option>
                                <option value="Luaran">Luaran</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tanggal Mulai Deadline</span>
                            </label>
                            <input type="date" class="form-control form-control-sm" name="edit_data_tanggal_mulai"
                                id="edit_data_tanggal_mulai" placeholder="Masukkan Tanggal Mulai Deadline" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tanggal Akhir Deadline</span>
                            </label>
                            <input type="date" class="form-control form-control-sm" name="edit_data_tanggal_akhir"
                                id="edit_data_tanggal_akhir" placeholder="Masukkan Tanggal Akhir Deadline" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Aktifasi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_aktifasi"
                                id="edit_data_aktifasi" data-live-search="true" title="Pilih Aktifasi" required>
                                <option value="y">Aktif</option>
                                <option value="t">Tidak Aktif</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Deskripsi</span>
                            </label>
                            <textarea class="form-control form-control-sm" placeholder="Isi Deskripsi Jika Diperlukan" name="edit_data_deskripsi"
                                id="edit_data_deskripsi" rows="3"></textarea>
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
