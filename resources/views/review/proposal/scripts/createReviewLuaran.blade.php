<script>
    $("#review_luaran_penelitian").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_review_luaran_penelitian").reset();
        // const button = $(e.relatedTarget);
        id = $("#btn_review_luaran_penelitian").data("id");
        const detail = '{{ route('review.proposal.show.review.luaran', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_luaran_penelitian").val(response.data.komen);
                    $("#nilai_luaran_penelitian").val(response.data.nilai);
                    $("#keputusan_reviewer_luaran_penelitian").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_review_luaran_penelitian").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.luaran') }}";
                const input = {
                    "id": $("#btn_review_luaran_penelitian").data("id"),
                    "id_dosen": $("#btn_review_luaran_penelitian").data("dsn"),
                    "komen": $("#komen_luaran_penelitian").val(),
                    "nilai": $("#nilai_luaran_penelitian").val(),
                    "status_review": $("#keputusan_reviewer_luaran_penelitian").val(),
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

    $("#review_luaran_pengabdian").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_review_luaran_pengabdian").reset();
        // const button = $(e.relatedTarget);
        id = $("#btn_review_luaran_pengabdian").data("id");
        const detail = '{{ route('review.proposal.show.review.luaran', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_luaran_pengabdian").val(response.data.komen);
                    $("#nilai_luaran_pengabdian").val(response.data.nilai);
                    $("#keputusan_reviewer_luaran_pengabdian").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_review_luaran_pengabdian").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.luaran') }}";
                const input = {
                    "id": $("#btn_review_luaran_pengabdian").data("id"),
                    "id_dosen": $("#btn_review_luaran_pengabdian").data("dsn"),
                    "komen": $("#komen_luaran_pengabdian").val(),
                    "nilai": $("#nilai_luaran_pengabdian").val(),
                    "status_review": $("#keputusan_reviewer_luaran_pengabdian").val(),
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

    $("#review_luaran_haki").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_review_luaran_haki").reset();
        // const button = $(e.relatedTarget);
        id = $("#btn_review_luaran_haki").data("id");
        const detail = '{{ route('review.proposal.show.review.luaran', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_luaran_haki").val(response.data.komen);
                    $("#nilai_luaran_haki").val(response.data.nilai);
                    $("#keputusan_reviewer_luaran_haki").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_review_luaran_haki").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.luaran') }}";
                const input = {
                    "id": $("#btn_review_luaran_haki").data("id"),
                    "id_dosen": $("#btn_review_luaran_haki").data("dsn"),
                    "komen": $("#komen_luaran_haki").val(),
                    "nilai": $("#nilai_luaran_haki").val(),
                    "status_review": $("#keputusan_reviewer_luaran_haki").val(),
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

    $("#review_luaran_buku").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_review_luaran_buku").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        dsn = button.data("dsn")

        $("#bt_submit_review_luaran_buku").attr('data-id', id);
        $("#bt_submit_review_luaran_buku").attr('data-dsn', dsn);
        // const detail = '{{ route('proposal.pengajuan.luaran.show', [':id']) }}';
        const detail = '{{ route('review.proposal.show.review.luaran', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komen_luaran_buku").val(response.data.komen);
                    $("#nilai_luaran_buku").val(response.data.nilai);
                    $("#keputusan_reviewer_luaran_buku").val(response.data.status_review);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_review_luaran_buku").on("submit", function(e) {
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
                const action = "{{ route('review.proposal.store.review.luaran') }}";
                const input = {
                    "id": $(this).data("id"),
                    "id_dosen": $(this).data("dsn"),
                    "komen": $("#komen_luaran_buku").val(),
                    "nilai": $("#nilai_luaran_buku").val(),
                    "status_review": $("#keputusan_reviewer_luaran_buku").val(),
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
