<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.publikasi.luaran.jurnal.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#show_dosen").text(response.data.dosen != null ? response.data.dosen : '------');
                    $("#show_prodi").text(response.data.prodi != null ? response.data.prodi : '------');
                    $("#show_fakultas").text(response.data.fakultas != null ? response.data.fakultas :
                        '------');
                    $("#show_judul").text(response.data.judul != null ? response.data.judul : '------');
                    $("#show_pelaksanaan").text(response.data.pelaksanaan != null ? response.data
                        .pelaksanaan : '------');
                    $("#show_jenis").text(response.data.jenis != null ? response.data.jenis : '------');
                    $("#show_kategori").text(response.data.kategori != null ? response.data.kategori :
                        '------');
                    $("#show_peringkat").text(response.data.peringkat != null ? response.data.peringkat :
                        '------');
                    $("#show_penerbit").text(response.data.penerbit != null ? response.data.penerbit :
                        '------');
                    $("#show_halaman").text(response.data.halaman != null ? response.data.halaman :
                        '------');
                    $("#show_issn").text(response.data.issn != null ? response.data.issn : '------');
                    $("#show_volume").text(response.data.volume != null ? response.data.volume : '------');
                    $("#show_nomor").text(response.data.nomor != null ? response.data.nomor : '------');
                    $("#show_publish").text(response.data.publish != null ? response.data.publish :
                        '------');
                    $("#show_abstrak").text(response.data.abstrak != null ? response.data.abstrak :
                        '------');
                    $("#show_link")
                        .attr('href', response.data.link != null ? response.data.link : '------')
                        .text(response.data.link != null ? response.data.link : '------');
                    $("#show_berkas")
                        .attr('href', response.data.file != null ? response.data.file : '------');

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
