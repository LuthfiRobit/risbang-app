<script>
    // let id = '';
    $("#bt_submit_review_penelitian").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.proposal') }}";
                const input = {
                    "id": $("#bt_submit_review_penelitian").data("id"),
                    "id_dosen": $("#bt_submit_review_penelitian").data("dsn"),
                    "komen_judul": $("#komen_penelitian_judul").val(),
                    "nilai_judul": $("#nilai_penelitian_judul").val(),
                    "komen_abstrak": $("#komen_penelitian_abstrak").val(),
                    "nilai_abstrak": $("#nilai_penelitian_abstrak").val(),
                    "komen_kata_kunci": $("#komen_penelitian_kata_kunci").val(),
                    "nilai_kata_kunci": $("#nilai_penelitian_kata_kunci").val(),
                    "komen_latar_belakang": $("#komen_penelitian_latbel").val(),
                    "nilai_latar_belakang": $("#nilai_penelitian_latbel").val(),
                    "komen_metode": $("#komen_penelitian_metode").val(),
                    "nilai_metode": $("#nilai_penelitian_metode").val(),
                    "komen_rencana": $("#komen_penelitian_rencana").val(),
                    "nilai_rencana": $("#nilai_penelitian_rencana").val(),
                    "komen_dapus": $("#komen_penelitian_dapus").val(),
                    "nilai_dapus": $("#nilai_penelitian_dapus").val(),
                    "status_review": $("#keputusan_reviewer_penelitian").val(),
                };
                DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
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
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        })

    });

    $("#bt_submit_review_pengabdian").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.proposal') }}";
                const input = {
                    "id": $("#bt_submit_review_pengabdian").data("id"),
                    "id_dosen": $("#bt_submit_review_pengabdian").data("dsn"),
                    "komen_judul": $("#komen_pengabdian_judul").val(),
                    "nilai_judul": $("#nilai_pengabdian_judul").val(),
                    "komen_abstrak": $("#komen_pengabdian_abstrak").val(),
                    "nilai_abstrak": $("#nilai_pengabdian_abstrak").val(),
                    "komen_kata_kunci": $("#komen_pengabdian_kata_kunci").val(),
                    "nilai_kata_kunci": $("#nilai_pengabdian_kata_kunci").val(),
                    "komen_latar_belakang": $("#komen_pengabdian_latbel").val(),
                    "nilai_latar_belakang": $("#nilai_pengabdian_latbel").val(),
                    "komen_metode": $("#komen_pengabdian_metode").val(),
                    "nilai_metode": $("#nilai_pengabdian_metode").val(),
                    "komen_rencana": $("#komen_pengabdian_rencana").val(),
                    "nilai_rencana": $("#nilai_pengabdian_rencana").val(),
                    "komen_dapus": $("#komen_pengabdian_dapus").val(),
                    "nilai_dapus": $("#nilai_pengabdian_dapus").val(),
                    "status_review": $("#keputusan_reviewer_pengabdian").val(),
                };
                DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
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
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        })

    });
</script>
