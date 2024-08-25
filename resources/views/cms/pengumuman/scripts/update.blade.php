<script>
    function getIdFromUrl() {
        const path = window.location.pathname;
        const segments = path.split('/');
        return segments[segments.length - 1];
    }

    const id = getIdFromUrl();
    const updateUrl = `{{ route('cms.pengumuman.update', ['id' => '__ID__']) }}`.replace('__ID__', id);

    $("#form_update").on("submit", function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data yang diubah sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const formData = new FormData();
                const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                formData.append("publish", publishStatus);
                formData.append("jenis", $("#jenis").val());
                formData.append("judul", $("#judul").val());
                formData.append("deskripsi", $("#deskripsi").val());

                const urlValue = $("#url").val();
                const fileInput = $("#file")[0].files;

                // Validate input: only one of url or file must be filled
                if (!urlValue && fileInput.length === 0) {
                    Swal.fire('Oops...', 'Anda harus mengisi link URL atau mengunggah file.', 'error');
                    return;
                }

                if (urlValue && fileInput.length > 0) {
                    Swal.fire('Oops...', 'Anda hanya bisa mengisi salah satu antara URL atau file.',
                        'error');
                    return;
                }

                if (fileInput.length > 0) {
                    const fileSizeMB = fileInput[0].size / 1024 / 1024;
                    if (fileSizeMB > 3 && !urlValue) {
                        Swal.fire('Oops...', 'Jika file lebih dari 3MB, Anda harus mengisi URL.',
                            'error');
                        return;
                    }
                    formData.append("file", fileInput[0]);
                } else {
                    formData.append("url", urlValue);
                }

                formData.append("_method", "PUT");

                DataManager.formData(updateUrl, formData, "POST").then(response => {
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
