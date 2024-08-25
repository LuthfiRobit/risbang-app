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
                                <span class="required">Nama Kepakaran</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="nama_kepakaran"
                                id="nama_kepakaran" placeholder="Masukkan Nama Kepakaran" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Bidang Ilmu</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="bidang_ilmu"
                                id="bidang_ilmu" data-live-search="true" title="Pilih Bidang Ilmu">
                                @foreach ($bidangIlmu as $item)
                                    <option value="{{ $item->id_bidang_ilmu }}">{{ $item->nama_bidang_ilmu }}</option>
                                @endforeach
                                {{-- <option value="y">Aktif</option>
                                <option value="t">Tidak Aktif</option> --}}
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Aktifasi</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="aktifasi" id="aktifasi"
                                data-live-search="true" title="Pilih Aktifasi">
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
