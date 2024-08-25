<div class="modal fade" id="modal_review" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" id="from_review">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Review</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Keputusan</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="keputusan" id="keputusan"
                                data-live-search="true" title="Pilih Keputusan" required>
                                <option value="Revisi">Revisi</option>
                                <option value="Acc">Acc</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Komentar</span>
                            </label>
                            <textarea class="form-control form-control-sm" rows="5" name="komentar" id="komentar" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_review_simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
