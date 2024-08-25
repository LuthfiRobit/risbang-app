<script>
    $(document).ready(function() {
        // Buat URL dengan id
        id = $("#fm_submit_kemajuan_penelitian").data('ta');
        const detailBaseUrl = '{{ route('proposal.kemajuan.deadline', [':id']) }}';
        const detail = detailBaseUrl.replace(':id', id);
        DataManager.fetchData(detail)
            .then(function(response) {
                if (response.success) {
                    // Loop data dan buat elemen HTML
                    response.data.forEach(function(item) {
                        var timelineItem = `
                                <div class="timeline-items mb-3 border-danger rounded border border-dashed">
                                    <div class="timeline-item pt-3">
                                        <div class="timeline-media bg-light-primary m-3">
                                            <span><i class="bi bi-calendar-event text-danger fs-1"></i></span>
                                        </div>
                                        <div class="timeline-desc timeline-desc-light-primary">
                                            <span class="fw-bolder text-warning">${item.deadline}</span>
                                            <p class="font-weight-normal text-dark-50">
                                                DEADLINE LAPORAN KEMAJUAN ${item.jenis.toUpperCase()}
                                            </p>
                                        </div>
                                    </div>
                                </div>`;
                        $('#timeline-container').append(timelineItem);
                    });
                } else {
                    Swal.fire('Oops...', 'Belum ada record deadline kemajuan', 'error');
                    var timelineItem = `
                                <div class="timeline-items mb-3 border-danger rounded border border-dashed">
                                    <div class="timeline-item pt-3">
                                        <div class="timeline-media bg-light-primary m-3">
                                            <span><i class="bi bi-calendar-event text-danger fs-1"></i></span>
                                        </div>
                                        <div class="timeline-desc timeline-desc-light-primary">
                                            <span class="fw-bolder text-warning">Deadline</span>
                                            <p class="font-weight-normal text-dark-50">
                                               Mohon maaf data deadline belum tersedia
                                            </p>
                                        </div>
                                    </div>
                                </div>`;
                    $('#timeline-container').append(timelineItem);
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
