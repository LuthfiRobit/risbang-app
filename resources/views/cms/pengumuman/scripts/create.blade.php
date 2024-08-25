<script>
    $("#form_create").on("submit", function(e) {
        e.preventDefault();

        // Ambil nilai dari input
        const url = $("#url").val();
        const fileInput = $("#file")[0].files;
        const file = fileInput.length > 0 ? fileInput[0] : null;
        const fileSizeMB = file ? file.size / 1024 / 1024 : 0;

        // Validasi client-side
        if (!url && !file) {
            Swal.fire('Error', 'Anda harus mengisi link URL atau mengunggah file.', 'error');
            return;
        }

        if (url && file) {
            Swal.fire('Error', 'Anda hanya bisa mengisi salah satu antara URL atau file.', 'error');
            return;
        }

        if (file && fileSizeMB > 3 && !url) {
            Swal.fire('Error', 'Jika file lebih dari 3MB, Anda harus mengisi URL.', 'error');
            return;
        }

        // Konfirmasi sebelum pengiriman data
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
                const action = "{{ route('cms.pengumuman.store') }}";

                const formData = new FormData();
                const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                formData.append("publish", publishStatus);
                formData.append("jenis", $("#jenis").val());
                formData.append("judul", $("#judul").val());
                formData.append("deskripsi", $("#deskripsi").val());

                // Tambahkan URL jika diisi
                if (url) {
                    formData.append("url", url);
                }

                // Tambahkan file jika diisi
                if (file) {
                    formData.append("file", file);
                }

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('cms.pengumuman.index') }}";
                            }, 2000);
                        } else if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        } else if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'info');
                        } else if (!xhr.responseJSON.success && xhr.responseJSON.message ===
                            'Validasi gagal') {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(xhr.responseJSON);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        } else if (!xhr.responseJSON.success && [500, 404, 405, 401, 403]
                            .includes(xhr.status)) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'error');
                        } else {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        }
                    }
                });
            }
        });
    });
</script>
