<script>
    let id = '';
    $("#edit_anggota").on("show.bs.modal", function(e) {
        document.getElementById("update_anggota").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('cms.profil.show.anggota', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_nama").val(response.data.nama);
                    $("#edit_jabatan").val(response.data.jabatan);
                    $("#edit_urutan").val(response.data.urutan);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#update_anggota").on("submit", function(e) {
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
                const updateUrl = '{{ route('cms.profil.update.anggota', [':id']) }}';
                const formData = new FormData();
                formData.append("nama", $("#edit_nama").val());
                formData.append("jabatan", $("#edit_jabatan").val());
                formData.append("urutan", $("#edit_urutan").val());
                formData.append("gambar", $("#edit_gambar")[0].files[0]);
                if ($("#edit_gambar")[0].files.length > 0) {
                    formData.append("gambar", $("#edit_gambar")[0].files[0]);
                }

                formData.append("_method", "PUT");
                DataManager.formData(updateUrl.replace(':id', id), formData, "POST").then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_");
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
