<script>
    $(document).ready(function() {
        var emptyItem = `
            <div class="timeline-items mb-3 border-danger rounded border border-dashed"><div class="timeline-item pt-3">
                <div class="timeline-media m-3"><span><i class="bi bi-info-circle text-danger fs-1"></i></span></div>
                <div class="timeline-desc timeline-desc-light-primary">
                    <span class="fw-bolder text-warning">Info</span>
                    <p class="font-weight-normal text-dark-50">Mohon maaf data tidak tersedia</p>
                </div>
            </div></div>`;

        function fecthAkhirData(formSelector, jenis, containerHistory, containerReview, linkAkhir, reviewStatus,
            viewFile) {
            var form = $(formSelector);
            var taId = form.data("ta");
            const showUrl = '{{ route('proposal.akhir.show', [':id']) }}'.replace(':id', id) + '?jenis=' +
                jenis;
            DataManager.fetchData(showUrl)
                .then(function(response) {

                    // Handle file existence
                    if (response.data.file_akhir !== null) {
                        const urlPene = "{{ asset('files/akhirProposal/') }}" + "/" + response.data
                            .file_akhir;
                        let ex_file =
                            `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> Lihat File</a>`;
                        $(viewFile).append(ex_file);
                    }
                    $(linkAkhir).val(response.data.link_drive)
                    $(reviewStatus).text(response.data.status_review != null ? response.data.status_review :
                        'Belum Direview');

                    var akhId = response.data.id_akhir_cript;
                    fetchHistoryData(akhId, containerHistory);
                    fetchReviewData(akhId, containerReview);
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                })
        }

        function fetchHistoryData(akhId, container) {
            const historyUrl = '{{ route('proposal.akhir.list.history', [':id']) }}'.replace(':id', akhId);

            DataManager.fetchData(historyUrl)
                .then(function(response) {
                    if (response.success) {
                        var countData = response.data.length;
                        response.data.forEach(function(item, index) {
                            var number = countData - index;
                            var fileUrl = "{{ asset('files/akhirProposal/') }}" + "/" + item
                                .file_akhir;
                            let ex_file;
                            let ex_drive;

                            if (item.link_drive !== null) {
                                ex_drive =
                                    `<a href="${item.link_drive}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-google me-2"></i></span>
                                     Lihat Link Drive</a>`;
                            } else {
                                ex_drive = `<span>Tidak ada record</span>`;
                            }

                            // Handle file existence
                            if (item.file_akhir !== null) {
                                const urlPene = "{{ asset('files/akhirProposal/') }}" + "/" +
                                    item.file_akhir;
                                ex_file =
                                    `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-download me-2"></i></span>
                                    Download Berkas Revisi</a>`;
                            } else {
                                ex_file = `<span>Tidak ada record</span>`;
                            }

                            var reviewItems = `
                            <div class="timeline-items mb-3 border-primary rounded border border-dashed pt-3">
                                <div class="timeline-item">
                                    <div class="timeline-media m-3">
                                        <span><i class="bi bi-info-circle text-primary fs-1"></i></span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <a href="#" class="text-dark-75 text-hover-primary fw-bolder">Revisi ${number}</a>
                                                <span class="text-muted ml-2"> | ${item.tgl_upload} | </span>
                                                <span class="label fw-bolder text-primary label-inline ml-2">${item.status_review}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Link Drive revisi lama :</span>
                                            <div class="row">${ex_drive}</div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">File revisi lama :</span>
                                            <div class="row">${ex_file}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            $(container).append(reviewItems);
                        });
                    } else {
                        $(container).append(emptyItem);
                    }
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }


        function fetchReviewData(akhId, container) {
            const reviewUrl = '{{ route('proposal.akhir.list.review', [':id']) }}'.replace(':id', akhId);

            DataManager.fetchData(reviewUrl)
                .then(function(response) {
                    if (response.success) {
                        var countData = response.data.length;
                        response.data.forEach(function(item, index) {
                            var number = countData - index;
                            var reviewItems = `
                            <div class="timeline-items mb-3 border-success rounded border border-dashed pt-3">
                                <div class="timeline-item">
                                    <div class="timeline-media m-3">
                                        <span><i class="bi bi-info-circle text-success fs-1"></i></span>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <a href="#" class="text-dark-75 text-success text-hover-success fw-bolder">Review ${number}</a>
                                                <span class="text-muted ml-2"> | ${item.tgl_review} </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Komentar reviewer :</span>
                                            <div class="row">
                                                <p class="">${item.komen}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                            $(container).append(reviewItems);
                        });
                    } else {
                        $(container).append(emptyItem);
                    }
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }

        fecthAkhirData("#fm_submit_akhir_penelitian", "Penelitian", "#container-history-pene",
            "#container-review-pene", "#link_akhir_pene", "#review_status_pene",
            "#exist-file-pene");
        fecthAkhirData("#fm_submit_akhir_pengabdian", "Pengabdian", "#container-history-peng",
            "#container-review-peng", "#link_akhir_peng", "#review_status_peng",
            "#exist-file-peng");


    });
</script>
