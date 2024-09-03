<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.proposal.pengajuan.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#show_dosen").text(response.data.dosen != null ? response.data.dosen : '------');
                    $("#show_prodi").text(response.data.prodi != null ? response.data.prodi : '------');
                    $("#show_fakultas").text(response.data.fakultas != null ? response.data.fakultas :
                        '------');
                    $("#show_jenis").text(response.data.jenis != null ? response.data.jenis : '------');
                    $("#show_status").text(response.data.status != null ? response.data.status : '------');
                    $("#show_dana").text(response.data.dana != null ? response.data.dana : '------');
                    $("#show_judul").text(response.data.judul != null ? response.data.judul : '------');
                    $("#show_abstrak").text(response.data.abstrak != null ? response.data.abstrak :
                        '------');
                    $("#show_katkun").text(response.data.katkun != null ? response.data.katkun : '------');
                    $("#show_latbel").text(response.data.latbel != null ? response.data.latbel : '------');
                    $("#show_metode").text(response.data.metode != null ? response.data.metode : '------');
                    $("#show_rencana").text(response.data.rencana != null ? response.data.rencana :
                        '------');
                    $("#show_dapus").text(response.data.dapus != null ? response.data.dapus : '------');
                    $("#show_berkas").attr('href', response.data.file != null ? response.data.file :
                        '------');

                    $("#show_nilai_judul").text(response.data.nilai_judul != null ? response.data
                        .nilai_judul : '------');
                    $("#show_nilai_abstrak").text(response.data.nilai_abstrak != null ? response.data
                        .nilai_abstrak :
                        '------');
                    $("#show_nilai_katkun").text(response.data.nilai_katkun != null ? response.data
                        .nilai_katkun : '------');
                    $("#show_nilai_latbel").text(response.data.nilai_latbel != null ? response.data
                        .nilai_latbel : '------');
                    $("#show_nilai_metode").text(response.data.nilai_metode != null ? response.data
                        .nilai_metode : '------');
                    $("#show_nilai_rencana").text(response.data.nilai_rencana != null ? response.data
                        .nilai_rencana :
                        '------');
                    $("#show_nilai_dapus").text(response.data.nilai_dapus != null ? response.data
                        .nilai_dapus : '------');

                    $("#null_data").hide();
                    $("#show_data").show();
                } else {
                    $("#null_data").show();
                    $("#show_data").hide();
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server' + error, 'error');
                // console.log(response);
            });
    });
</script>
