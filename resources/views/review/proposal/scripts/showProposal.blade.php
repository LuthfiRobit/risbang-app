<script>
    // let id = '';
    $(document).ready(function() {
        formPenelitian = $("#bt_submit_review_penelitian");
        id = formPenelitian.data("id");
        console.log(id);
        const detail = '{{ route('proposal.pengajuan.penelitian.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.file_proposal !== null) {
                        urlPene = "{{ asset('files/proposalPenelitian/') }}" + "/" + response.data
                            .file_proposal;
                        let ex_pene =
                            `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success">
                                <i class="bi bi-eye me-1"></i> ${response.data.file_proposal}</a>`
                        $("#exist-file-pene").append(ex_pene);
                    }
                    $("#penelitian_judul").val(response.data.judul);
                    $("#penelitian_abstrak").val(response.data.abstrak);
                    $("#penelitian_kata_kunci").val(response.data.kata_kunci);
                    $("#penelitian_latar_belakang").val(response.data.latar_belakang);
                    $("#penelitian_metode").val(response.data.metode);
                    $("#penelitian_rencana").val(response.data.rencana);
                    $("#penelitian_dapus").val(response.data.dapus);
                    $("#keputusan_reviewer_penelitian").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan proposal penelitian', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $(document).ready(function() {
        formPengabdian = $("#bt_submit_review_pengabdian");
        id = formPengabdian.data("id");
        console.log(id);
        const detail = '{{ route('proposal.pengajuan.pengabdian.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.file_proposal !== null) {
                        urlPene = "{{ asset('files/proposalPenelitian/') }}" + "/" + response.data
                            .file_proposal;
                        let ex_pene =
                            `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success">
                                <i class="bi bi-eye me-1"></i> ${response.data.file_proposal}</a>`
                        $("#exist-file-peng").append(ex_pene);
                    }
                    $("#pengabdian_judul").val(response.data.judul);
                    $("#pengabdian_abstrak").val(response.data.abstrak);
                    $("#pengabdian_kata_kunci").val(response.data.kata_kunci);
                    $("#pengabdian_latar_belakang").val(response.data.latar_belakang);
                    $("#pengabdian_metode").val(response.data.metode);
                    $("#pengabdian_rencana").val(response.data.rencana);
                    $("#pengabdian_dapus").val(response.data.dapus);
                    $("#keputusan_reviewer_pengabdian").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan proposal pengabdian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
