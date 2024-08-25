<div class="modal fade" id="form_create" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" id="bt_submit_create">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Role Dosen</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="role" id="role"
                                data-live-search="true" title="Pilih Role Dosen" required>
                                <option value="dekan">Dekan</option>
                                <option value="kaprodi">Kaprodi</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Fakultas</span>
                            </label>
                            <div id="select_fakultas" class="select-fakultas">
                            </div>
                            {{-- <ul id="error-list" class="list-unstyled text-danger"></ul> --}}
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Program Studi</span>
                            </label>
                            <div id="select_prodi" class="select-prodi">
                            </div>
                            {{-- <ul id="error-list" class="list-unstyled text-danger"></ul> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Dosen</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="dosen" id="dosen"
                                data-live-search="true" title="Pilih Dosen" required>
                                @foreach ($dosen as $item)
                                    <option class="text-uppercase" value="{{ $item->id_user }}">{{ $item->nidn }} |
                                        {{ $item->nama_dosen }}</option>
                                @endforeach
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
