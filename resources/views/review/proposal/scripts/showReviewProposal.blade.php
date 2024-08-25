<script>
    // let id = '';
    $(document).ready(function() {
        formReviewPenelitian = $("#bt_submit_review_penelitian");
        id = formReviewPenelitian.data("id");
        // console.log(id);
        const reviewPenelitian = '{{ route('review.proposal.show.review.proposal', [':id']) }}';
        DataManager.fetchData(reviewPenelitian.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_penelitian_judul").val(response.data.komen_judul);
                    $("#nilai_penelitian_judul").val(response.data.nilai_judul);
                    $("#komen_penelitian_abstrak").val(response.data.komen_abstrak);
                    $("#nilai_penelitian_abstrak").val(response.data.nilai_abstrak);
                    $("#komen_penelitian_kata_kunci").val(response.data.komen_kata_kunci);
                    $("#nilai_penelitian_kata_kunci").val(response.data.nilai_kata_kunci);
                    $("#komen_penelitian_latbel").val(response.data.komen_latar_belakang);
                    $("#nilai_penelitian_latbel").val(response.data.nilai_latar_belakang);
                    $("#komen_penelitian_metode").val(response.data.komen_metode);
                    $("#nilai_penelitian_metode").val(response.data.nilai_metode);
                    $("#komen_penelitian_rencana").val(response.data.komen_rencana);
                    $("#nilai_penelitian_rencana").val(response.data.nilai_rencana);
                    $("#komen_penelitian_dapus").val(response.data.komen_dapus);
                    $("#nilai_penelitian_dapus").val(response.data.nilai_dapus);
                } else {
                    Swal.fire('Oops...', 'Belum ada record review proposal penelitian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    // let id = '';
    $(document).ready(function() {
        formReviewPengabdian = $("#bt_submit_review_pengabdian");
        id = formReviewPengabdian.data("id");
        // console.log(id);
        const reviewPengabdian = '{{ route('review.proposal.show.review.proposal', [':id']) }}';
        DataManager.fetchData(reviewPengabdian.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_pengabdian_judul").val(response.data.komen_judul);
                    $("#nilai_pengabdian_judul").val(response.data.nilai_judul);
                    $("#komen_pengabdian_abstrak").val(response.data.komen_abstrak);
                    $("#nilai_pengabdian_abstrak").val(response.data.nilai_abstrak);
                    $("#komen_pengabdian_kata_kunci").val(response.data.komen_kata_kunci);
                    $("#nilai_pengabdian_kata_kunci").val(response.data.nilai_kata_kunci);
                    $("#komen_pengabdian_latbel").val(response.data.komen_latar_belakang);
                    $("#nilai_pengabdian_latbel").val(response.data.nilai_latar_belakang);
                    $("#komen_pengabdian_metode").val(response.data.komen_metode);
                    $("#nilai_pengabdian_metode").val(response.data.nilai_metode);
                    $("#komen_pengabdian_rencana").val(response.data.komen_rencana);
                    $("#nilai_pengabdian_rencana").val(response.data.nilai_rencana);
                    $("#komen_pengabdian_dapus").val(response.data.komen_dapus);
                    $("#nilai_pengabdian_dapus").val(response.data.nilai_dapus);
                } else {
                    Swal.fire('Oops...', 'Belum ada record review proposal pengabdian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
