<script>
    // let id = '';
    $(document).ready(function() {
        formPengabdian = $("#bt_submit_review_pengabdian");
        id = formPengabdian.data("id");
        // console.log(id);
        const showPene = '{{ route('proposal.pengajuan.pengabdian.show', [':id']) }}';
        DataManager.fetchData(showPene.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#review_judul_peng").val(response.data.judul);
                    $("#review_abstrak_peng").val(response.data.abstrak);
                    $("#review_katkun_peng").val(response.data.kata_kunci);
                    $("#review_latbel_peng").val(response.data.latar_belakang);
                    $("#review_metode_peng").val(response.data.metode);
                    $("#review_rencana_peng").val(response.data.rencana);
                    $("#review_dapus_peng").val(response.data.dapus);
                    $("#review_status_peng").text(response.data.status_review);
                    formPengabdian.attr('data-peng', response.data.id_cript);
                    peng = formPengabdian.data("peng");
                    const reviewPene = '{{ route('review.proposal.show.review.proposal', [':id']) }}';
                    DataManager.fetchData(reviewPene.replace(':id', peng))
                        .then(function(response) {
                            if (response.success) {
                                $("#hasil_review_judul_peng").val(response.data.komen_judul);
                                $("#hasil_review_abstrak_peng").val(response.data.komen_abstrak);
                                $("#hasil_review_katkun_peng").val(response.data.komen_kata_kunci);
                                $("#hasil_review_latbel_peng").val(response.data.komen_latar_belakang);
                                $("#hasil_review_metode_peng").val(response.data.komen_metode);
                                $("#hasil_review_rencana_peng").val(response.data.komen_rencana);
                                $("#hasil_review_dapus_peng").val(response.data.komen_dapus);
                            } else {
                                // Swal.fire('Oops...', 'Belum ada record pengajuan proposal pengabdian', 'error');
                            }
                        })
                        .catch(function(error) {
                            // Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    // Swal.fire('Oops...', 'Belum ada record pengajuan proposal pengabdian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
