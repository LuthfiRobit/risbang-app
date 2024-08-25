<script>
    $("#fm_submit_luaran_penelitian").on("submit", function(e) {
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
                const action = "{{ route('proposal.luaran.store') }}";
                const formData = new FormData();
                formData.append("ta_id", $("#fm_submit_luaran_penelitian").data("ta"));
                formData.append("proposal_id", $("#fm_submit_luaran_penelitian").data("pene"));
                formData.append("jenis", "Penelitian");
                formData.append("judul", $("#judul_luaran_pene").val());
                formData.append("penerbit", $("#publikasi_luaran_pene").val());
                formData.append("publikasi", $("#jenis_publikasi_luaran_pene").val());
                formData.append("tahun", $("#tahun_luaran_pene").val());
                formData.append("volume", $("#volume_luaran_pene").val());
                formData.append("nomor", $("#nomor_luaran_pene").val());
                formData.append("link", $("#url_luaran_pene").val());
                formData.append("issn", $("#issn_luaran_pene").val());
                if ($("#file_luaran_pene")[0].files.length > 0) {
                    formData.append("file_luaran", $("#file_luaran_pene")[0].files[0]);
                }
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr(
                            'content') // Include the CSRF token in the request headers
                        // 'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
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
        })

    });

    $("#fm_submit_luaran_pengabdian").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Apa kamu yakin?",
            text: "Apakah data anda sudah benar dan sesuai?",
            icon: "warning",
            confirmButtonColor: "#3085d6",
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.value) {
                const action = "{{ route('proposal.luaran.store') }}";
                const formData = new FormData();
                formData.append("ta_id", $("#fm_submit_luaran_pengabdian").data("ta"));
                formData.append("proposal_id", $("#fm_submit_luaran_pengabdian").data("peng"));
                formData.append("jenis", "Pengabdian");
                formData.append("judul", $("#judul_luaran_peng").val());
                formData.append("penerbit", $("#publikasi_luaran_peng").val());
                formData.append("publikasi", $("#jenis_publikasi_luaran_peng").val());
                formData.append("tahun", $("#tahun_luaran_peng").val());
                formData.append("volume", $("#volume_luaran_peng").val());
                formData.append("nomor", $("#nomor_luaran_peng").val());
                formData.append("link", $("#url_luaran_peng").val());
                formData.append("issn", $("#issn_luaran_peng").val());
                if ($("#file_luaran_peng")[0].files.length > 0) {
                    formData.append("file_luaran", $("#file_luaran_peng")[0].files[0]);
                }
                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr(
                            'content') // Include the CSRF token in the request headers
                        // 'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
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
