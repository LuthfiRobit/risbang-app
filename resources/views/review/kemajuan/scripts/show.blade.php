<script>
    $(document).ready(function() {
        const dsn = $('#dsn_id').val();

        function fetchDataAndPopulateForm(url, formId, fileContainerId, driveContainerId, statusContainerId) {
            DataManager.fetchData(url)
                .then(function(response) {
                    if (response.success) {
                        const data = response.data;
                        const fileUrl = `{{ asset('files/kemajuanProposal/') }}/${data.file_kemajuan}`;
                        const ex_drive = data.link_drive ?
                            `<a href="${data.link_drive}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-google me-2"></i></span> Lihat drive kemajuan</a>` :
                            `<span class="mb-2">Tidak ada record</span>`;
                        const ex_file = data.file_kemajuan ?
                            `<a href="${fileUrl}" target="_blank" class="d-flex align-items-center text-primary text-hover-success me-5 mb-2"><span class="svg-icon svg-icon-4 me-1"><i class="bi bi-download me-2"></i></span> Lihat file kemajuan</a>` :
                            `<span class="mb-2">Tidak ada record</span>`;

                        $(driveContainerId).append(ex_drive);
                        $(fileContainerId).append(ex_file);
                        $(statusContainerId).text(data.status_review);

                        $(formId).attr('data-kem', data.id_kemajuan_cript);

                        fetchReviewData(data.id_kemajuan_cript, formId, data.jenis);
                    } else {
                        console.log('Belum ada record kemajuan');
                    }
                })
                .catch(function(error) {
                    console.log('Kesalahan server', error);
                });
        }

        function fetchReviewData(id, formId, jenis) {
            const detailRev = '{{ route('review.kemajuan.show', [':id']) }}'.replace(':id', id);
            DataManager.fetchData(detailRev)
                .then(function(response) {
                    if (response.success) {
                        const data = response.data;

                        $(formId).find('input[name="skor_publikasi"]').val(data.skor_publikasi);
                        $(formId).find('input[name="skor_pemakalah"]').val(data.skor_pemakalah);
                        $(formId).find('input[name="skor_bahan"]').val(data.skor_bahan);
                        $(formId).find('input[name="skor_ttg"]').val(data.skor_ttg);
                        if (jenis == 'Penelitian') {
                            $("#komen_kemajuan_pene").val(data.komen);
                            $("#nilai_kemajuan_pene").val(data.nilai);
                            $("#keputusan_kemajuan_pene").val(data.status_review);
                            $('#keputusan_kemajuan_pene').selectpicker('refresh').selectpicker('render');
                        } else {
                            $("#komen_kemajuan_peng").val(data.komen);
                            $("#nilai_kemajuan_peng").val(data.nilai);
                            $("#keputusan_kemajuan_peng").val(data.status_review);
                            $('#keputusan_kemajuan_peng').selectpicker('refresh').selectpicker('render');
                        }
                    } else {
                        console.log('Belum ada record review kemajuan');
                    }
                })
                .catch(function(error) {
                    console.log('Kesalahan server', error);
                });
        }

        const penelitianForm = "#fm_submit_kemajuan_penelitian";
        const penelitianId = $(penelitianForm).data("ta");
        const penelitianUrl = '{{ route('proposal.kemajuan.show', [':id']) }}'.replace(':id', penelitianId) +
            `?jenis=Penelitian&dosen=${dsn}`;
        fetchDataAndPopulateForm(penelitianUrl, penelitianForm, "#exist-file-pene", "#exist-drive-pene",
            "#review_status_pene");

        const pengabdianForm = "#fm_submit_kemajuan_pengabdian";
        const pengabdianId = $(pengabdianForm).data("ta");
        const pengabdianUrl = '{{ route('proposal.kemajuan.show', [':id']) }}'.replace(':id', pengabdianId) +
            `?jenis=Pengabdian&dosen=${dsn}`;
        fetchDataAndPopulateForm(pengabdianUrl, pengabdianForm, "#exist-file-peng", "#exist-drive-peng",
            "#review_status_peng");
    });
</script>
