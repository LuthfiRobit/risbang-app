<script>
    // let id = '';
    $(document).ready(function() {
        formPenelitian = $("#bt_submit_review_penelitian");
        id = formPenelitian.data("id");
        // console.log(id);
        const showPene = '{{ route('proposal.pengajuan.penelitian.show', [':id']) }}';
        DataManager.fetchData(showPene.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#review_judul_pene").val(response.data.judul);
                    $("#review_judul_pene").val(response.data.judul);
                    $("#review_abstrak_pene").val(response.data.abstrak);
                    $("#review_katkun_pene").val(response.data.kata_kunci);
                    $("#review_latbel_pene").val(response.data.latar_belakang);
                    $("#review_metode_pene").val(response.data.metode);
                    $("#review_rencana_pene").val(response.data.rencana);
                    $("#review_status_pene").text(response.data.status_review);
                    formPenelitian.attr('data-pene', response.data.id_cript);
                    pene = formPenelitian.data("pene");
                    const reviewPene = '{{ route('review.proposal.show.review.proposal', [':id']) }}';
                    DataManager.fetchData(reviewPene.replace(':id', pene))
                        .then(function(response) {
                            if (response.success) {
                                $("#hasil_review_judul_pene").val(response.data.komen_judul);
                                $("#hasil_review_abstrak_pene").val(response.data.komen_abstrak);
                                $("#hasil_review_katkun_pene").val(response.data.komen_kata_kunci);
                                $("#hasil_review_latbel_pene").val(response.data.komen_latar_belakang);
                                $("#hasil_review_metode_pene").val(response.data.komen_metode);
                                $("#hasil_review_rencana_pene").val(response.data.komen_rencana);
                                $("#hasil_review_dapus_pene").val(response.data.komen_dapus);
                            } else {
                                // Swal.fire('Oops...', 'Belum ada record pengajuan proposal penelitian', 'error');
                            }
                        })
                        .catch(function(error) {
                            // Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    // Swal.fire('Oops...', 'Belum ada record pengajuan proposal penelitian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
