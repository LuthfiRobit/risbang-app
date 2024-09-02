<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.proposal.luaran.show', [':id']) }}';
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
                    $("#show_status").text(response.data.status != null ? response.data.status : '------');
                    $("#show_judul").text(response.data.judul != null ? response.data.judul : '------');
                    $("#show_nilai").text(response.data.nilai != null ? response.data.nilai : '------');
                    $("#show_pelaksanaan").text(response.data.pelaksanaan != null ? response.data
                        .pelaksanaan :
                        '------');
                    $("#show_jenis_publikasi").text(response.data.jenis != null ? response.data.jenis :
                        '------');
                    $("#show_penerbit").text(response.data.penerbit != null ? response.data.penerbit :
                        '------');
                    $("#show_volume").text(response.data.volume != null ? response.data.volume : '------');
                    $("#show_nomor").text(response.data.nomor != null ? response.data.nomor : '------');
                    $("#show_issn").text(response.data.issn != null ? response.data.issn : '------');
                    $("#show_link")
                        .attr('href', response.data.link != null ? response.data.link : '------')
                        .text(response.data.link != null ? response.data.link : '------');

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
