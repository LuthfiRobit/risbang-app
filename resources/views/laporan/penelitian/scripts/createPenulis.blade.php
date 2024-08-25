<script>
    $("#create_penulis_luar").on("show.bs.modal", function(e) {
        document.getElementById("form_penulis_luar").reset();
    });

    $("#form_penulis_luar").on("submit", function(e) {
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
                const action = "{{ route('dosen.luar.store') }}";
                const input = {
                    "nidn": $("#nidn_luar").val(),
                    "nama": $("#nama_luar").val(),
                    "kampus": $("#kampus_luar").val(),
                    "alamat_kampus": $("#alamat_kampus_luar").val(),
                    "jk": $("#jk_luar").val(),
                    "pendidikan_terakhir": $("#pendidikan_terakhir_luar").val(),
                    "no_tlpn": $("#no_tlpn_luar").val()
                };
                DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                                document.getElementById("form_penulis_luar").reset();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }
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

    $("#create_penulis_lain").on("show.bs.modal", function(e) {
        document.getElementById("form_penulis_lain").reset();
    });

    $("#form_penulis_lain").on("submit", function(e) {
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
                const action = "{{ route('dosen.lain.store') }}";
                const input = {
                    "nik": $("#nik_lain").val(),
                    "nama": $("#nama_lain").val(),
                    "alamat": $("#alamat_lain").val(),
                    "jk": $("#jk_lain").val(),
                    "pendidikan_terakhir": $("#pendidikan_terakhir_lain").val(),
                    "no_tlpn": $("#no_tlpn_lain").val()
                };
                DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                                document.getElementById("form_penulis_lain").reset();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }
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
