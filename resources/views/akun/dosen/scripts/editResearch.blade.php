<script>
    $("#form_research").on("submit", function(e) {
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
                const update = '{{ route('akun.dosen.update.research', [':id']) }}';
                const input = {
                    "link_scholar": $("#link_scholar").val(),
                    "link_sinta": $("#link_sinta").val(),
                    "link_scopus": $("#link_scopus").val(),
                    "link_orcid": $("#link_orcid").val(),
                    "link_publons": $("#link_publons").val(),
                    "link_garuda": $("#link_garuda").val(),
                };
                DataManager.putData(update.replace(':id',
                            '{{ Crypt::encrypt(Auth::user()->dosen->id_dosen) }}'),
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
