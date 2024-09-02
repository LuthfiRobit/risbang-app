<script>
    $("#edit_st_penelitian").on("show.bs.modal", function(e) {
        document.getElementById("form_st_penelitian").reset();
        const button = $(e.relatedTarget);
        $("#form_st_penelitian").attr('data-proposal', button.data('proposal'));
        $("#form_st_penelitian").attr('data-ta', button.data('ta'));
    });

    $("#form_st_penelitian").on("submit", function(e) {
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
                const action = "{{ route('surat.tugas.store') }}";
                const input = {
                    "id_proposal": $(this).data('proposal'),
                    "ta_id": $(this).data('ta'),
                    "jenis": 'Penelitian',
                    "tanggal_surat": $(this).find("#tanggal_surat").val(),
                    "tempat_surat": $(this).find("#tempat_surat").val(),
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
                            console.log(response.message);
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }

                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                        // console.log(response.message);
                    });
            }
        })

    });

    $("#edit_st_pengabdian").on("show.bs.modal", function(e) {
        document.getElementById("form_st_pengabdian").reset();
        const button = $(e.relatedTarget);
        $("#form_st_pengabdian").attr('data-proposal', button.data('proposal'));
        $("#form_st_pengabdian").attr('data-ta', button.data('ta'));
    });

    $("#form_st_pengabdian").on("submit", function(e) {
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
                const action = "{{ route('surat.tugas.store') }}";
                const input = {
                    "id_proposal": $(this).data('proposal'),
                    "ta_id": $(this).data('ta'),
                    "jenis": 'Pengabdian',
                    "tanggal_surat": $(this).find("#tanggal_surat").val(),
                    "tempat_surat": $(this).find("#tempat_surat").val(),
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
                            console.log(response.message);
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }

                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                        // console.log(response.message);
                    });
            }
        })

    });
</script>
