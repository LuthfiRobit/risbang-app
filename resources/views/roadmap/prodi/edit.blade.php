<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="form_edit" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rentan Waktu</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_rentan"
                                id="edit_rentan" data-live-search="true" title="Pilih Rentan Waktu" required>
                                @foreach ($rentanWaktu as $item)
                                    <option value="{{ $item->id_rentan_waktu }}"
                                        data-nama="{{ $item->nama_rentan_waktu }}">
                                        {{ $item->nama_rentan_waktu }}
                                    </option>
                                @endforeach
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_jenis" id="edit_jenis"
                                data-live-search="true" title="Pilih Jenis" required>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengabdian">Pengabdian</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Berkas</span>
                            </label>
                            <input type="file" class="form-control form-control-sm" name="edit_file" id="edit_file"
                                placeholder="Masukkan Berkas Roadmap" accept=".pdf," />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Hasil Review : <span id="show_status"></span></span>
                            </label>
                            <textarea class="form-control form-control-sm" id="show_review" rows="5" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_edit_simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
