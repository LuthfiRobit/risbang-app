<script>
    $("#create_anggota").on("show.bs.modal", function(e) {
        document.getElementById("form_anggota").reset();
    });

    $("#form_anggota").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const action = "{{ route('cms.profil.store.anggota') }}";
                const formData = new FormData();
                formData.append("nama", $("#nama").val());
                formData.append("jabatan", $("#jabatan").val());
                formData.append("urutan", $("#urutan").val());

                if ($("#gambar")[0].files.length > 0) {
                    formData.append("gambar", $("#gambar")[0].files[0]);
                }

                DataManager.formData(action, formData, 'POST').then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                                document.getElementById("form_anggota").reset();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }
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
