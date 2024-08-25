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
                                <span class="required">Fakultas</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_fakultas"
                                id="edit_data_fakultas" data-live-search="true" title="Pilih Fakultas">
                                @foreach ($fakultas as $item)
                                    <option value="{{ $item->id_fakultas }}">{{ $item->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Program Studi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_prodi"
                                id="edit_data_prodi" data-live-search="true" title="Pilih Program Studi">
                                {{-- @foreach ($prodi as $item)
                                    <option value="{{ $item->id_prodi }}">{{ $item->nama_prodi }}</option>
                                @endforeach --}}
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Status Dosen</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_status_dosen"
                                id="edit_data_status_dosen" data-live-search="true" title="Pilih Status">
                                <option value="tetap">Tetap</option>
                                <option value="tidak tetap">Tidak Tetap</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Dosen</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_nama_dosen"
                                id="edit_data_nama_dosen" placeholder="Masukkan Nama Dosen" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">NIDN</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_nidn"
                                id="edit_data_nidn" placeholder="Masukkan NIDN" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Email</span>
                            </label>
                            <!--end::Label-->
                            <input type="email" class="form-control form-control-sm" name="edit_data_email"
                                id="edit_data_email" placeholder="Masukkan Email" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Username</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_username"
                                id="edit_data_username" placeholder="Masukkan Username" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Password</span>
                            </label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-sm" name="edit_data_password"
                                id="edit_data_password" placeholder="Masukkan Password"
                                autocomplete="current-password" />
                            <span class="form-text text-muted font-size-sm">*) Kosongkan jika tidak ingin
                                diperbarui</span>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Konfirmasi Password</span>
                            </label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-sm"
                                name="edit_data_password_confirmation" id="edit_data_password_confirmation"
                                placeholder="Konfirmasi Password" autocomplete="current-password" />
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
