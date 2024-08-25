<script>
    $(document).ready(function() {
        // Buat URL dengan id
        id = $("#tab_content_container").data('ta');
        const detailBaseUrl = '{{ route('proposal.akhir.rekap', [':id']) }}';
        const detail = detailBaseUrl.replace(':id', id);
        DataManager.fetchData(detail)
            .then(function(response) {
                if (response.success) {
                    // Loop data dan buat elemen HTML
                    response.data.forEach(function(item) {
                        var itemRekap = '';
                        if (item.status_review === 'Diterima') {
                            itemRekap = `
                                    <div class="timeline-items mb-3 border-success rounded border border-dashed">
                                        <div class="timeline-item pt-3">
                                            <div class="timeline-media bg-light-warning m-3">
                                                <span><i class="bi bi-check-circle text-primary fs-1"></i></span>
                                            </div>
                                            <div class="timeline-desc timeline-desc-light-primary">
                                                <span class="fw-bolder text-primary">${item.status_review} Pada :  ${item.tgl_update}</span>
                                                <p class="font-weight-normal text-dark-50">
                                                   LAPORAN KEMAJUAN ${item.jenis.toUpperCase()}
                                                </p>
                                            </div>
                                        </div>
                                    </div>`;
                        } else {
                            itemRekap = `
                                    <div class="timeline-items mb-3 border-success rounded border border-dashed">
                                        <div class="timeline-item pt-3">
                                            <div class="timeline-media bg-light-warning m-3">
                                                <span><i class="bi bi-x-circle text-danger fs-1"></i></span>
                                            </div>
                                            <div class="timeline-desc timeline-desc-light-danger">
                                                <span class="fw-bolder text-danger">${item.status_review}</span>
                                                <p class="font-weight-normal text-dark-50">
                                                    LAPORAN KEMAJUAN ${item.jenis.toUpperCase()}
                                                </p>
                                            </div>
                                        </div>
                                    </div>`;
                        }

                        $('#rekap-container').append(itemRekap);
                    });
                } else {
                    Swal.fire('Oops...', 'Belum ada record', 'error');
                    var itemRekap = `
                                <div class="timeline-items mb-3 border-danger rounded border border-dashed">
                                    <div class="timeline-item pt-3">
                                        <div class="timeline-media bg-light-primary m-3">
                                            <span><i class="bi bi-calendar-event text-danger fs-1"></i></span>
                                        </div>
                                        <div class="timeline-desc timeline-desc-light-primary">
                                            <span class="fw-bolder text-warning">Deadline</span>
                                            <p class="font-weight-normal text-dark-50">
                                               Mohon maaf data rekapitulasi kemajuan tidak ditemukan
                                            </p>
                                        </div>
                                    </div>
                                </div>`;
                    $('#rekap-container').append(itemRekap);
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
