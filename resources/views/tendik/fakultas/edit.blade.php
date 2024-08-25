<div class="modal fade" id="form_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_data_exampleModalLabel">Edit</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Fakultas</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_nama_fakultas"
                                id="edit_data_nama_fakultas" placeholder="Masukkan Nama Fakultas" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Singkatan</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" minlength="2" class="form-control form-control-sm date-own-2"
                                name="edit_data_singkatan" id="edit_data_singkatan" placeholder="Masukkan Singkatan"
                                required />
                            {{-- <input type="text" class="date-own"> --}}
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        {{-- <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Dekan</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" minlength="3" class="form-control form-control-sm date-own-1"
                                name="edit_data_nama_dekan" id="edit_data_nama_dekan" placeholder="Masukkan Nama Dekan"
                                required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div> --}}
                        <div class="col-sm-12">
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
