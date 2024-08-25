<script>
    let id = '';
    $('#form_general').on("submit", function(e) {
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
                const update = '{{ route('akun.dosen.update') }}';
                const formData = new FormData();

                formData.append("name", $("#name").val());
                formData.append("nik", $("#nik").val());
                formData.append("nidn", $("#nidn").val());
                formData.append("npwp", $("#npwp").val());

                formData.append("bidang_ilmu", $("#bidang_ilmu").val());
                formData.append("kepakaran", $("#kepakaran").val());
                formData.append("jafung", $("#jafung").val());
                formData.append("status_serdos", $("#status_serdos").val());
                formData.append("pendidikan_terakhir", $("#pendidikan_terakhir").val());

                formData.append("perguruan", $("#perguruan").val());
                formData.append("alamat", $("#alamat").val());
                formData.append("kode_pos", $("#kode_pos").val());

                formData.append("name", $("#name").val());
                formData.append("username", $("#username").val());
                formData.append("email", $("#email").val());
                formData.append("phone_number", $("#phone_number").val());
                formData.append("avatar", $("#avatar")[0].files[0]);
                if ($("#avatar")[0].files.length > 0) {
                    formData.append("avatar", $("#avatar")[0].files[0]);
                }
                formData.append("_method", "PUT");
                DataManager.formData(update, formData, "POST").then(response => {
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