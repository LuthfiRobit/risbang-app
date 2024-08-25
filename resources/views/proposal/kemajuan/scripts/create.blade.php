<script>
    // Function to handle form submission with validation and AJAX
    function handleFormSubmit(formId, fileInputId, urlInputId, jenis) {
        $(formId).on("submit", function(e) {
            e.preventDefault();

            // Check file size and URL input
            var fileInput = $(fileInputId);
            var fileSizeMB = fileInput[0].files.length > 0 ? fileInput[0].files[0].size / 1024 / 1024 : 0;
            var urlInput = $(urlInputId).val();

            if (fileSizeMB > 3 && !urlInput) {
                // alert('Jika file lebih dari 3MB, Anda harus mengisi URL.');
                Swal.fire('Oops...', 'File anda lebih dari 3MB, silahkan isi link google drive', 'error');
                return;
            }

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
                    const action = "{{ route('proposal.kemajuan.store') }}";
                    const formData = new FormData();
                    formData.append("ta_id", $(formId).data("ta"));
                    formData.append("proposal_id", $(formId).data(jenis === "Penelitian" ? "pene" :
                        "peng"));
                    formData.append("jenis", jenis);
                    formData.append("link_drive", urlInput);

                    if (fileInput[0].files.length > 0) {
                        formData.append("file_kemajuan", fileInput[0].files[0]);
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
                            console.log(response);

                            if (response.success) {
                                Swal.fire('Success', "Data telah berhasil dikirim",
                                    'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else if (!response.success && response.errors) {
                                const validationErrorFilter = new ValidationErrorFilter();
                                validationErrorFilter.filterValidationErrors(response);
                                Swal.fire('Oops...',
                                    'Terjadi Kesalahan Validasi, pastikan link drive benar / file sesuai dengan ketentuan',
                                    'error');
                            } else if (!response.success && !response.errors) {
                                Swal.fire('Oops...', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 403) {
                                Swal.fire('Oops...', xhr.responseJSON.message, 'info');
                            } else if (!xhr.responseJSON.success && xhr.responseJSON
                                .message === 'Validasi gagal') {
                                const validationErrorFilter = new ValidationErrorFilter();
                                validationErrorFilter.filterValidationErrors(xhr
                                    .responseJSON);
                                Swal.fire('Oops...',
                                    'Terjadi Kesalahan Validasi, pastikan link drive benar / file sesuai dengan ketentuan',
                                    'error');
                            } else if (!xhr.responseJSON.success && [500, 404, 405, 401,
                                    403, 400
                                ].includes(xhr.status)) {
                                Swal.fire('Oops...', xhr.responseJSON.message, 'error');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        }
                    });
                }
            });
        });
    }

    // Initialize form submission handling for Penelitian and Pengabdian forms
    $(document).ready(function() {
        handleFormSubmit("#fm_submit_kemajuan_penelitian", "#file_kemajuan_pene", "#link_kemajuan_pene",
            "Penelitian");
        handleFormSubmit("#fm_submit_kemajuan_pengabdian", "#file_kemajuan_peng", "#link_kemajuan_peng",
            "Pengabdian");
    });
</script>
