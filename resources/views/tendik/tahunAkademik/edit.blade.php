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
                                <span class="required">Tahun Awal</span>
                            </label>
                            <!--end::Label-->
                            <input
                                oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onkeydown="return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                                type="text" maxlength="4" minlength="4"
                                class="form-control form-control-sm date-own-1" name="edit_data_tahun_awal"
                                id="edit_data_tahun_awal" placeholder="Masukkan Tahun Awal" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tahun Akhir</span>
                            </label>
                            <!--end::Label-->
                            <input
                                oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onkeydown="return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                                type="text" maxlength="4" minlength="4"
                                class="form-control form-control-sm date-own-2" name="edit_data_tahun_akhir"
                                id="edit_data_tahun_akhir" placeholder="Masukkan Tahun Akhir" required />
                            {{-- <input type="text" class="date-own"> --}}
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Tahun Akademik</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_data_nama_tahun_akademik" id="edit_data_nama_tahun_akademik"
                                placeholder="Masukkan Nama Tahun Akademik" required readonly />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
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
