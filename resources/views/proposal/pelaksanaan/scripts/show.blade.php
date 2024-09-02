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

        function fetchPelaksanaanData(formSelector, jenis, containerHistory,
            judulProposal, namaKegiatan, tempatKegiatan, tanggalKegiatan, ketKegiatan) {
            var form = $(formSelector);
            var id = form.data("ta");
            const detailUrl = '{{ route('proposal.pelaksanaan.show', [':id']) }}'.replace(':id', id) +
                '?jenis=' +
                jenis;

            DataManager.fetchData(detailUrl)
                .then(function(response) {
                    if (response.success) {
                        $(judulProposal).text(response.data.judul != null ? response.data
                            .judul : 'Tidak terrecord');
                        $(namaKegiatan).val(response.data.nama_kegiatan);
                        $(tempatKegiatan).val(response.data.tempat_kegiatan);
                        $(tanggalKegiatan).val(response.data.tanggal);
                        $(ketKegiatan).val(response.data.keterangan);

                        var kemId = response.data.id_pelaksanaan_cript;
                        fetchHistoryData(kemId, containerHistory);
                    } else {
                        Swal.fire('Oops...', 'Belum ada record pelaksanaan ' + jenis.toLowerCase(),
                            'error');
                    }
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }

        function fetchHistoryData(kemId, container) {
            const historyUrl = '{{ route('proposal.pelaksanaan.list.history', [':id']) }}'.replace(':id',
                kemId);

            DataManager.fetchData(historyUrl)
                .then(function(response) {
                    if (response.success) {
                        var countData = response.data.length;
                        response.data.forEach(function(item, index) {
                            var number = countData - index;

                            var reviewItems = `
                            <div class="timeline-items mb-3 border-primary rounded border border-dashed pt-3">
                                <div class="timeline-item">
                                    <div class="timeline-media m-3"><span><i class="bi bi-info-circle text-primary fs-1"></i></span></div>
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div class="mr-2">
                                                <a href="#" class="text-dark-75 text-hover-primary fw-bolder">History ${number}</a>
                                                <span class="text-muted ml-2"> | ${item.tgl_upload} | </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Nama Kegiatan :</span>
                                            <div class="row ms-2">${item.nama_kegiatan}</div>
                                        </div>
                                        <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Tempat Kegiatan :</span>
                                            <div class="row ms-2">${item.tempat_kegiatan}</div>
                                        </div>
                                          <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Tanggal Kegiatan :</span>
                                            <div class="row ms-2">${item.tanggal}</div>
                                        </div>
                                          <div class="row">
                                            <span class="fs-12 text-gray-700 fw-bolder">Keterangan :</span>
                                            <div class="row ms-2">${item.keterangan}</div>
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

        fetchPelaksanaanData("#fm_submit_pelaksanaan_penelitian", "Penelitian", "#container-history-pene",
            "#judul_pene", "#nama_kegiatan_pene", "#tempat_kegiatan_pene", '#tanggal_kegiatan_pene',
            '#ket_kegiatan_pene');
        fetchPelaksanaanData("#fm_submit_pelaksanaan_pengabdian", "Pengabdian", "#container-history-peng",
            "#judul_peng", "#nama_kegiatan_peng", "#tempat_kegiatan_peng", '#tanggal_kegiatan_peng',
            '#ket_kegiatan_peng');
    });
</script>
