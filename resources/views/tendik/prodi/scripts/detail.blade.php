<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('tendik.prodi.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.aktif === 'y') {
                        text = 'Aktif';
                    } else {
                        text = 'Tidak Aktif';
                    }
                    $("#show_data_nama_fakultas").text(response.data.nama_fakultas);
                    $("#show_data_nama_prodi").text(response.data.nama_prodi);
                    // $("#show_data_nama_kaprodi").text(response.data.nama_kaprodi);
                    $("#show_data_singkatan").text(response.data.singkatan);
                    $("#show_data_aktif").text(text);
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
