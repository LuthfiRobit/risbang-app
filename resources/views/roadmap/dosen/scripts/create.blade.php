<script>
    $("#modal_create").on("show.bs.modal", function(e) {
        document.getElementById("form_create").reset();
    });

    $("#form_create").on("submit", function(e) {
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
                const action = "{{ route('roadmap.dosen.store') }}";
                const formData = new FormData();
                formData.append("rentan", $("#rentan").val());
                formData.append("jenis", $("#jenis").val());
                if ($("#file")[0].files.length > 0) {
                    formData.append("file", $("#file")[0].files[0]);
                }
                DataManager.formData(action, formData, 'POST').then(response => {
                        console.log(response);
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
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }

                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Error');
                    });

            }
        })

    });
</script>
