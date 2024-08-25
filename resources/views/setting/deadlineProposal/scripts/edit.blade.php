<script>
    let id = '';
    $("#form_edit").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('setting.deadline.proposal.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_data_tahun_akademik").val(response.data.tahun_akademik_id);
                    $("#edit_data_tanggal_mulai").val(response.data.tanggal_mulai);
                    $("#edit_data_tanggal_akhir").val(response.data.tanggal_akhir);
                    $("#edit_data_jenis").val(response.data.jenis);
                    $("#edit_data_keterangan").val(response.data.keterangan);
                    $("#edit_data_deskripsi").val(response.data.deskripsi);
                    $("#edit_data_aktifasi").val(response.data.aktif);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
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
                const update = '{{ route('setting.deadline.proposal.update', [':id']) }}';
                const input = {
                    "tahun_akademik": $("#edit_data_tahun_akademik").val(),
                    "tanggal_mulai": $("#edit_data_tanggal_mulai").val(),
                    "tanggal_akhir": $("#edit_data_tanggal_akhir").val(),
                    "jenis": $("#edit_data_jenis").val(),
                    "keterangan": $("#edit_data_keterangan").val(),
                    "deskripsi": $("#edit_data_deskripsi").val(),
                    "aktifasi": $("#edit_data_aktifasi").val(),
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire({
                                title: 'Menyimpan data...',
                                text: 'Silakan tunggu',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                }
                            });
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
