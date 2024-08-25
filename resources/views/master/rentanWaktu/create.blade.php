<div class="modal fade" id="form_create" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
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
                                class="form-control form-control-sm date-own-1" name="tahun_awal" id="tahun_awal"
                                placeholder="Masukkan Tahun Awal" required />
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
                                class="form-control form-control-sm date-own-2" name="tahun_akhir" id="tahun_akhir"
                                placeholder="Masukkan Tahun Akhir" required />
                            {{-- <input type="text" class="date-own"> --}}
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Rentan Waktu</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nama_rentan_waktu"
                                id="nama_rentan_waktu" placeholder="Masukkan Nama Rentan Waktu" required readonly />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Aktifasi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="aktifasi" id="aktifasi"
                                data-live-search="true" title="Pilih Aktifasi" required>
                                {{-- @foreach ($role as $item)
                                        <option value="{{ $item->id_role }}">{{ $item->role }}</option>
                                    @endforeach --}}
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
