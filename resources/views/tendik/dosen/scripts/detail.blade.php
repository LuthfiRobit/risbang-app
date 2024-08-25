<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('tendik.dosen.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.status_dosen === 'tetap') {
                        status_dosen = 'Tetap';
                    } else {
                        status_dosen = 'Tidak Tetap';
                    }

                    if (response.data.jk === 'l') {
                        jk = 'Laki-laki';
                    } else if (response.data.jk === 'p') {
                        jk = 'Perempuan';
                    }
                    $("#show_data_nama_dosen").text(response.data.nama_dosen != null ? response.data
                        .nama_dosen : '------');
                    $("#show_data_nidn").text(response.data.nidn != null ? response.data.nidn : '------');
                    $("#show_data_nik").text(response.data.nik != null ? response.data.nik : '------');
                    $("#show_data_fakultas").text(response.data.nama_fakultas != null ? response.data
                        .nama_fakultas : '------');
                    $("#show_data_prodi").text(response.data.nama_prodi != null ? response.data.nama_prodi :
                        '------');
                    $("#show_data_jk").text(response.data.jk != null ? jk : '------');
                    $("#show_data_status_dosen").text(response.data.status_dosen != null ? status_dosen :
                        '------');
                    $("#show_data_jabatan").text(response.data.jabatan != null ? response.data.jabatan :
                        '------');
                    $("#show_data_status_serdos").text(response.data.status_serdos != null ? response.data
                        .status_serdos : '------');
                    $("#show_data_email").text(response.data.email != null ? response.data.email :
                        '------');
                    $("#show_data_username").text(response.data.username != null ? response.data.username :
                        '------');
                    $("#show_data_tlpn").text(response.data.no_tlpn != null ? response.data.no_tlpn :
                        '------');
                    $("#null_data").hide();
                    $("#show_data").show();
                } else {
                    $("#null_data").show();
                    $("#show_data").hide();
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
                // console.log(response);
            });
    });
</script>