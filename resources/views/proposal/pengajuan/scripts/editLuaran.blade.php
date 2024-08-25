<script>
    // let id = '';

    $("#edit_luaran_penelitian").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit_luaran_penelitian").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('proposal.pengajuan.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_judul_luaran_penelitian").val(response.data.judul);
                    $("#edit_rencana_penerbitan_luaran_penelitian").val(response.data.penerbit);
                    $("#edit_jenis_publikasi_luaran_penelitian").val(response.data.jenis_publikasi);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit_luaran_penelitian").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('proposal.pengajuan.luaran.update', [':id']) }}';
                const input = {
                    "jenis_luaran": 'jurnal',
                    "nama_jenis_luaran": 'Jurnal Penelitian',
                    "judul": $("#edit_judul_luaran_penelitian").val(),
                    "penerbit": $("#edit_rencana_penerbitan_luaran_penelitian").val(),
                    "jenis_publikasi": $("#edit_jenis_publikasi_luaran_penelitian").val()
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
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

    $("#edit_luaran_pengabdian").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit_luaran_pengabdian").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('proposal.pengajuan.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_judul_luaran_pengabdian").val(response.data.judul);
                    $("#edit_rencana_penerbitan_luaran_pengabdian").val(response.data.penerbit);
                    $("#edit_jenis_publikasi_luaran_pengabdian").val(response.data.jenis_publikasi);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit_luaran_pengabdian").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('proposal.pengajuan.luaran.update', [':id']) }}';
                const input = {
                    "jenis_luaran": 'jurnal',
                    "nama_jenis_luaran": 'Jurnal Pengabdian',
                    "judul": $("#edit_judul_luaran_pengabdian").val(),
                    "penerbit": $("#edit_rencana_penerbitan_luaran_pengabdian").val(),
                    "jenis_publikasi": $("#edit_jenis_publikasi_luaran_pengabdian").val()
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
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

    $("#edit_luaran_haki").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit_luaran_haki").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('proposal.pengajuan.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_judul_luaran_haki").val(response.data.judul);
                    $("#edit_jenis_luaran_haki").val(response.data.jenis_haki);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit_luaran_haki").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('proposal.pengajuan.luaran.update', [':id']) }}';
                const input = {
                    "jenis_luaran": 'haki',
                    "judul": $("#edit_judul_luaran_haki").val(),
                    "jenis_haki": $("#edit_jenis_luaran_haki").val(),
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
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

    $("#edit_luaran_buku").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit_luaran_buku").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('proposal.pengajuan.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_judul_luaran_buku").val(response.data.judul);
                    $("#edit_jenis_luaran_buku").val(response.data.jenis_buku);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit_luaran_buku").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah data anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('proposal.pengajuan.luaran.update', [':id']) }}';
                const input = {
                    "jenis_luaran": 'buku',
                    "judul": $("#edit_judul_luaran_buku").val(),
                    "jenis_buku": $("#edit_jenis_luaran_buku").val(),
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
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
