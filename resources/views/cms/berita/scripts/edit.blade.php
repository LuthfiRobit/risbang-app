<script>
    function getIdFromUrl() {
        const path = window.location.pathname;
        const segments = path.split('/');
        return segments[segments.length - 1];
    }

    const id = getIdFromUrl();

    const updateUrl = `{{ route('cms.berita.update', ['id' => '__ID__']) }}`.replace('__ID__', id);

    $('#form_edit').on("submit", function(e) {

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

                const formData = new FormData();
                const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                formData.append("publish", publishStatus);

                formData.append("judul", $("#judul").val());
                formData.append("deskripsi", $("#kt_docs_ckeditor_classic").val());
                formData.append("gambar", $("#gambar")[0].files[0]);
                if ($("#gambar")[0].files.length > 0) {
                    formData.append("gambar", $("#gambar")[0].files[0]);
                }

                formData.append("_method", "PUT");
                DataManager.formData(updateUrl.replace(':id', id), formData, "POST").then(response => {
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
