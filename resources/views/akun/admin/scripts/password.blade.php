<script>
    $("#form_password").on("submit", function(e) {
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
                const update = '{{ route('akun.update.password', [':id']) }}';
                const input = {
                    "current_password": $("#current_password").val(),
                    "new_password": $("#new_password").val(),
                    "new_password_confirmation": $("#password_confirmation").val(),
                };
                DataManager.putData(update.replace(':id',
                            '{{ Crypt::encrypt(Auth::user()->id_user) }}'),
                        input).then(response => {
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
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        })

    });
</script>
