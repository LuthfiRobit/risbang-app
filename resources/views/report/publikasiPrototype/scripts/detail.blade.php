<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('report.publikasi.luaran.prototype.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#show_dosen").text(response.data.dosen != null ? response.data.dosen : '------');
                    $("#show_prodi").text(response.data.prodi != null ? response.data.prodi : '------');
                    $("#show_fakultas").text(response.data.fakultas != null ? response.data.fakultas :
                        '------');
                    $("#show_jenis").text(response.data.jenis != null ? response.data.jenis : '------');
                    $("#show_judul").text(response.data.judul != null ? response.data.judul : '------');
                    $("#show_tahun_pelaksanaan").text(response.data.tahun_pelaksanaan != null ? response
                        .data.tahun_pelaksanaan : '------');
                    $("#show_tkt").text(response.data.tkt != null ? response.data.tkt : '------');
                    $("#show_level").text(response.data.level != null ? response.data.level : '------');
                    $("#show_deskripsi").text(response.data.deskripsi != null ? response.data.deskripsi :
                        '------');
                    // Handle Surat Tugas
                    if (response.data.file != null) {
                        $("#show_file").attr('href', response.data.file).removeClass('d-none');
                        $("#no_file").addClass('d-none');
                    } else {
                        $("#show_file").addClass('d-none');
                        $("#no_file").removeClass('d-none');
                    }
                    // Handle Surat Tugas
                    if (response.data.cover != null) {
                        $("#show_cover").attr('href', response.data.cover).removeClass('d-none');
                        $("#no_cover").addClass('d-none');
                    } else {
                        $("#show_cover").addClass('d-none');
                        $("#no_cover").removeClass('d-none');
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
