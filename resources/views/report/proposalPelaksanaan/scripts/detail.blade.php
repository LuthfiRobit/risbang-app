<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.proposal.pelaksanaan.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#show_dosen").text(response.data.dosen != null ? response.data.dosen : '------');
                    $("#show_prodi").text(response.data.prodi != null ? response.data.prodi : '------');
                    $("#show_fakultas").text(response.data.fakultas != null ? response.data.fakultas :
                        '------');
                    $("#show_jenis").text(response.data.jenis_proposal != null ? response.data
                        .jenis_proposal : '------');
                    $("#show_judul").text(response.data.judul != null ? response.data.judul : '------');
                    $("#show_nama_kegiatan").text(response.data.nama_kegiatan != null ? response.data
                        .nama_kegiatan : '------');
                    $("#show_tempat_kegiatan").text(response.data.tempat_kegiatan != null ? response.data
                        .tempat_kegiatan : '------');
                    $("#show_tanggal_kegiatan").text(response.data.tanggal != null ? response.data.tanggal :
                        '------');
                    $("#show_keterangan_kegiatan").text(response.data.keterangan != null ? response.data
                        .keterangan : '------');

                    // Handle Surat Tugas
                    if (response.data.file != null) {
                        $("#show_berkas").attr('href', response.data.file).removeClass('d-none');
                        $("#no_berkas").addClass('d-none');
                    } else {
                        $("#show_berkas").addClass('d-none');
                        $("#no_berkas").removeClass('d-none');
                    }

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
