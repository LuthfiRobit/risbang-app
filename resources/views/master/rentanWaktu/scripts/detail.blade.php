<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('master.rentan.waktu.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.aktif === 'y') {
                        text = 'Aktif';
                    } else {
                        text = 'Tidak Aktif';
                    }
                    $("#show_data_tahun_awal").text(response.data.tahun_awal);
                    $("#show_data_tahun_akhir").text(response.data.tahun_akhir);
                    $("#show_data_nama").text(response.data.nama_rentan_waktu);
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
