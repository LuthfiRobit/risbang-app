<script>
    $("#upload_sk_penelitian").on("submit", function(e) {
        e.preventDefault();
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
                const action = "{{ route('surat.moa.upload') }}";
                const formData = new FormData();
                formData.append("id_proposal", $(this).data('proposal'));
                formData.append("ta_id", $(this).data('ta'));
                formData.append("jenis", 'Penelitian');
                if ($(this).find("#kontrak")[0].files.length > 0) {
                    formData.append("kontrak", $(this).find("#kontrak")[0].files[0]);
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
                                location.reload();
                            }, 2000);
                        } else if (response.errors) {
                            $("#upload_sk_penelitian").find("#error-kontrak_penelitian")
                                .html(
                                    '');
                            $.each(response.errors, function(field, messages) {
                                if (field === 'kontrak') {
                                    $("#error-kontrak_penelitian").html(messages
                                        .join(
                                            '<br>'));
                                }
                            });
                            Swal.fire('Oops...',
                                'Terjadi Kesalahan Validasi, Pastikan file tidak lebih dari 3 mb',
                                'error');
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        $("#upload_sk_penelitian").find("#error-kontrak_penelitian").html(
                            '');
                        if (xhr.status === 403) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'info');
                        } else if (xhr.responseJSON.message === 'Validasi gagal') {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                if (field === 'kontrak') {
                                    $("#error-kontrak_penelitian").html(messages
                                        .join(
                                            '<br>'));
                                }
                            });
                            Swal.fire('Oops...',
                                'Terjadi Kesalahan Validasi, Pastikan file tidak lebih dari 3 mb',
                                'error');
                        } else if ([500, 404, 405, 401, 403].includes(xhr.status)) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'error');
                        } else {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        }
                    }
                });
            }
        });
    });

    $("#upload_sk_pengabdian").on("submit", function(e) {
        e.preventDefault();
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
                const action = "{{ route('surat.moa.upload') }}";
                const formData = new FormData();
                formData.append("id_proposal", $(this).data('proposal'));
                formData.append("ta_id", $(this).data('ta'));
                formData.append("jenis", 'Pengabdian');
                if ($(this).find("#kontrak")[0].files.length > 0) {
                    formData.append("kontrak", $(this).find("#kontrak")[0].files[0]);
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
                                location.reload();
                            }, 2000);
                        } else if (response.errors) {
                            $("#upload_sk_pengabdian").find("#error-kontrak_pengabdian")
                                .html(
                                    '');
                            $.each(response.errors, function(field, messages) {
                                if (field === 'kontrak') {
                                    $("#error-kontrak_pengabdian").html(messages
                                        .join(
                                            '<br>'));
                                }
                            });
                            Swal.fire('Oops...',
                                'Terjadi Kesalahan Validasi, Pastikan file tidak lebih dari 3 mb',
                                'error');
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        $("#upload_sk_pengabdian").find("#error-kontrak_pengabdian").html(
                            '');
                        if (xhr.status === 403) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'info');
                        } else if (xhr.responseJSON.message === 'Validasi gagal') {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                if (field === 'kontrak') {
                                    $("#error-kontrak_pengabdian").html(messages
                                        .join(
                                            '<br>'));
                                }
                            });
                            Swal.fire('Oops...',
                                'Terjadi Kesalahan Validasi, Pastikan file tidak lebih dari 3 mb',
                                'error');
                        } else if ([500, 404, 405, 401, 403].includes(xhr.status)) {
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
