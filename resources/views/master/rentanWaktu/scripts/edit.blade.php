<script>
    let id = '';
    $("#form_edit").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('master.rentan.waktu.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_data_tahun_awal").val(response.data.tahun_awal);
                    $("#edit_data_tahun_akhir").val(response.data.tahun_akhir);
                    $("#edit_data_nama_rentan_waktu").val(response.data.nama_rentan_waktu);
                    $("#edit_data_aktifasi").val(response.data.aktif);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });


    $("#edit_data_tahun_awal, #edit_data_tahun_akhir").on("change", function() {
        $("#edit_data_nama_rentan_waktu").val($("#edit_data_tahun_awal").val() + '-' + $(
            "#edit_data_tahun_akhir").val());
    });

    $("#bt_submit_edit").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('master.rentan.waktu.update', [':id']) }}';
                const input = {
                    "tahun_awal": $("#edit_data_tahun_awal").val(),
                    "tahun_akhir": $("#edit_data_tahun_akhir").val(),
                    "nama_rentan_waktu": $("#edit_data_nama_rentan_waktu").val(),
                    "aktifasi": $("#edit_data_aktifasi").val(),
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        })

    });
</script>
