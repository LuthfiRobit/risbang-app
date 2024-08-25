<div class="modal fade" id="modal_create" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" id="form_create" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Rentan Waktu</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="rentan" id="rentan"
                                data-live-search="true" title="Pilih Rentan Waktu" required>
                                @foreach ($rentanWaktu as $item)
                                    <option value="{{ $item->id_rentan_waktu }}">{{ $item->nama_rentan_waktu }}</option>
                                @endforeach
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="jenis" id="jenis"
                                data-live-search="true" title="Pilih Jenis" required>
                                <option value="Penelitian">Penelitian</option>
                                <option value="Pengabdian">Pengabdian</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Berkas</span>
                            </label>
                            <input type="file" class="form-control form-control-sm" name="file" id="file"
                                placeholder="Masukkan Berkas Roadmap" accept=".pdf," required />
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
