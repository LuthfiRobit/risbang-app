<script>
    $("#form_kelengkapan").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.proposal.pengajuan.kelengkapan', [':id']) }}';
        $("#null_data_kelengkapan, #show_data_kelengkapan").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#show_kel_dosen").text(response.data.dosen != null ? response.data.dosen : '------');
                    $("#show_kel_prodi").text(response.data.prodi != null ? response.data.prodi : '------');
                    $("#show_kel_fakultas").text(response.data.fakultas != null ? response.data.fakultas :
                        '------');
                    $("#show_kel_jenis").text(response.data.jenis != null ? response.data.jenis : '------');
                    $("#show_kel_status").text(response.data.status != null ? response.data.status :
                        '------');
                    $("#show_kel_judul").text(response.data.judul != null ? response.data.judul : '------');

                    // Handle Surat Tugas
                    if (response.data.file_surat != null) {
                        $("#show_kel_surat").attr('href', response.data.file_surat).removeClass('d-none');
                        $("#no_surat").addClass('d-none');
                    } else {
                        $("#show_kel_surat").addClass('d-none');
                        $("#no_surat").removeClass('d-none');
                    }

                    // Handle Kontrak/MoA
                    if (response.data.file_moa != null) {
                        $("#show_kel_moa").attr('href', response.data.file_moa).removeClass('d-none');
                        $("#no_moa").addClass('d-none');
                    } else {
                        $("#show_kel_moa").addClass('d-none');
                        $("#no_moa").removeClass('d-none');
                    }

                    $("#null_data_kelengkapan").hide();
                    $("#show_data_kelengkapan").show();
                } else {
                    $("#null_data_kelengkapan").show();
                    $("#show_data_kelengkapan").hide();
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server' + error, 'error');
                // console.log(response);
            });
    });
</script>
