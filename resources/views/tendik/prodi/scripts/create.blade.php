{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
<script>
    $("#form_create").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_create").reset();
    });

    $("#bt_submit_create").on("submit", function(e) {
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
                const action = "{{ route('tendik.prodi.store') }}";
                const input = {
                    "fakultas": $("#fakultas").val(),
                    "nama_prodi": $("#nama_prodi").val(),
                    "singkatan": $("#singkatan").val(),
                    // "nama_kaprodi": $("#nama_kaprodi").val(),
                    "aktifasi": $("#aktifasi").val(),
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

    $("#bt_submit_import").on("submit", function(e) {
        e.preventDefault();

        const fileInput = $("#file")[0];
        const file = fileInput.files[0];

        if (!file) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Silakan pilih file untuk diunggah.',
                icon: 'warning'
            });
            return;
        }

        const allowedExtensions = ['xlsx', 'xls'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                title: 'Peringatan',
                text: 'File harus memiliki ekstensi .xlsx atau .xls.',
                icon: 'warning'
            });
            return;
        }

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Apakah file anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const action = "{{ route('tendik.prodi.import.excel') }}";
                const formData = new FormData();
                formData.append("file", file);

                Swal.fire({
                    title: 'Mengimpor Data',
                    html: 'Proses impor data sedang berlangsung...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                DataManager.formData(action, formData, 'POST').then(response => {
                    Swal.close();

                    if (response.success) {
                        let message = '<strong>Data berhasil disimpan!</strong><br>';

                        // Tampilkan data yang berhasil
                        if (response.successes && response.successes.length > 0) {
                            message += '<strong>Data yang berhasil disimpan:</strong><br>';
                            response.successes.forEach((success, index) => {
                                message +=
                                    `Baris ${index + 1} -> ${success.nama_prodi}<br>`;
                            });
                        }

                        // Tampilkan data yang gagal
                        if (response.failures && response.failures.length > 0) {
                            message += '<br><strong>Data yang gagal disimpan:</strong><br>';
                            response.failures.forEach(failure => {
                                message += `Baris ${failure.row_number} -> `;
                                message += failure.errors.join(' | ') + '<br>';
                            });
                        }

                        Swal.fire({
                            title: 'Hasil Import',
                            html: message, // Menggunakan html untuk styling
                            icon: 'success'
                        }).then(result => {
                            if (result.isConfirmed) {
                                location.reload(); // Reload halaman setelah mengklik OK
                            }
                        });

                    } else {
                        Swal.fire({
                            title: 'Oops...',
                            text: response.message ||
                                'Terjadi kesalahan tidak terduga.',
                            icon: 'error'
                        });
                    }
                }).catch(error => {
                    Swal.close();
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim data',
                        icon: 'error'
                    });
                });
            }
        });
    });
</script>
