<script>
    // Function to handle form submission with validation and AJAX
    function handleFormSubmit(formId, namaId, tempatId, tanggalId, ketId, jenis) {
        $(formId).on("submit", function(e) {
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
                    const action = "{{ route('proposal.pelaksanaan.store') }}";
                    const formData = new FormData();
                    formData.append("ta_id", $(formId).data("ta"));
                    formData.append("proposal_id", $(formId).data(jenis === "Penelitian" ? "pene" :
                        "peng"));
                    formData.append("jenis", jenis);
                    formData.append("nama_kegiatan", $(namaId).val());
                    formData.append("tempat_kegiatan", $(tempatId).val());
                    formData.append("tanggal", $(tanggalId).val());
                    formData.append("keterangan", $(ketId).val());

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
        handleFormSubmit("#fm_submit_pelaksanaan_penelitian",
            "#nama_kegiatan_pene",
            "#tempat_kegiatan_pene",
            "#tanggal_kegiatan_pene",
            "#ket_kegiatan_pene",
            "Penelitian");
        handleFormSubmit("#fm_submit_pelaksanaan_pengabdian",
            "#nama_kegiatan_peng",
            "#tempat_kegiatan_peng",
            "#tanggal_kegiatan_peng",
            "#ket_kegiatan_peng",
            "Pengabdian");
    });
</script>
