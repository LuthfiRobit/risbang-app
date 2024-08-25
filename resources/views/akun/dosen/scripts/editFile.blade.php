<script>
    $('#form_berkas').on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Apakah data anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('akun.dosen.update.file', [':id']) }}';
                const formData = new FormData();
                formData.append("file_ktp", $("#file_ktp")[0].files[0]);
                formData.append("file_npwp", $("#file_npwp")[0].files[0]);
                formData.append("file_sk", $("#file_sk")[0].files[0]);
                formData.append("file_ttd", $("#file_ttd")[0].files[0]);
                if ($("#file_ktp")[0].files.length > 0) {
                    formData.append("file_ktp", $("#file_ktp")[0].files[0]);
                }
                if ($("#file_npwp")[0].files.length > 0) {
                    formData.append("file_npwp", $("#file_npwp")[0].files[0]);
                }
                if ($("#file_sk")[0].files.length > 0) {
                    formData.append("file_sk", $("#file_sk")[0].files[0]);
                }
                if ($("#file_ttd")[0].files.length > 0) {
                    formData.append("file_ttd", $("#file_ttd")[0].files[0]);
                }
                formData.append("_method", "PUT");
                DataManager.formData(update.replace(':id',
                        '{{ Crypt::encrypt(Auth::user()->dosen->id_dosen) }}'),
                    formData,
                    "POST").then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            Swal.fire({
                                title: 'Menyimpan data...',
                                text: 'Silakan tunggu',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            location.reload();
                        }, 2000);

                    } else if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter();
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                    } else if (!response.success && !response.errors) {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                }).catch(error => {
                    console.log(error);
                    Swal.fire('Oops...', 'Error', 'error');
                });
            }
        });
    });
</script>
