<script>
    $(document).ready(function() {
        const dsn = $('#dsn_id').val();

        function handleFetchData(jenis, formSelector, suffix) {
            const form = $(formSelector);
            const id = form.data("ta");
            const detail = '{{ route('proposal.akhir.show', [':id']) }}'.replace(':id', id);

            DataManager.fetchData(detail + '?jenis=' + jenis + '&dosen=' + dsn)
                .then(function(response) {
                    if (response.success) {
                        $("#review_status_" + suffix).text(response.data.status_review != null ?
                            response.data.status_review : 'Belum Direview');

                        const fileUrl = `{{ asset('files/akhirProposal/') }}/${response.data.file_akhir}`;
                        const ex_drive = response.data.link_drive ?
                            `<a href="${response.data.link_drive}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-google me-2"></i></span> Lihat drive akhir</a>` :
                            `<span class="mb-2">Tidak ada record</span>`;
                        const ex_file = response.data.file_akhir ?
                            `<a href="${fileUrl}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-download me-2"></i></span> Lihat file akhir</a>` :
                            `<span class="mb-2">Tidak ada record</span>`;

                        $("#exist-drive-" + suffix).append(ex_drive);
                        $("#exist-file-" + suffix).append(ex_file);

                        form.attr('data-kem', response.data.id_akhir_cript);
                        const kemId = response.data.id_akhir_cript;
                        const detailRev = '{{ route('review.akhir.show', [':id']) }}'.replace(':id', kemId);

                        DataManager.fetchData(detailRev)
                            .then(function(response) {
                                if (response.success) {
                                    $("#komen_akhir_" + suffix).val(response.data.komen);
                                    $("#nilai_akhir_" + suffix).val(response.data.nilai);
                                    $("#keputusan_akhir_" + suffix).val(response.data
                                        .status_review);
                                    $('#keputusan_akhir_' + suffix).selectpicker('refresh')
                                        .selectpicker('render');
                                } else {
                                    Swal.fire('Oops...', 'Belum ada record review akhir ' + jenis
                                        .toLowerCase(), 'error');
                                }
                            })
                            .catch(function(error) {
                                // Swal.fire('Oops...', 'Kesalahan server', 'error');
                            });
                    } else {
                        Swal.fire('Oops...', 'Belum ada record akhir ' + jenis.toLowerCase(), 'error');
                    }
                })
                .catch(function(error) {
                    // Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }

        // Handle Penelitian
        handleFetchData('Penelitian', "#fm_submit_akhir_penelitian", "pene");

        // Handle Pengabdian
        handleFetchData('Pengabdian', "#fm_submit_akhir_pengabdian", "peng");
    });
</script>
