<script>
    $('#fakultas').on('change', function() {
        $('#prodi').selectpicker('refresh');
        id = $(this).val();
        const get = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
        DataManager.fetchData(get.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    var data = response.data;
                    console.log(data);
                    $('#prodi').empty();
                    $.each(data, function(key, item) {
                        $('#prodi').append($('<option></option>').attr(
                            'value', item.id_prodi).text(item
                            .nama_prodi));
                    })
                    $('#prodi').selectpicker('refresh');
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $('#prodi').on('change', function() {
        console.log($(this).val());
    });

    $("#form_create").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_create").reset();
    });

    $("#form_import").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_import").reset();
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
                const action = "{{ route('tendik.dosen.store') }}";
                const input = {
                    "fakultas": $("#fakultas").val(),
                    "prodi": $("#prodi").val(),
                    "status": $("#status").val(),
                    "nama_dosen": $("#nama_dosen").val(),
                    "nidn": $("#nidn").val(),
                    "username": $("#username").val(),
                    "email": $("#email").val(),
                    "password": $("#password").val(),
                    "password_confirmation": $("#password_confirmation").val(),
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

    $("#bt_submit_import").on("submit", function(e) {
        e.preventDefault();

        const fileInput = $("#file")[0];
        const file = fileInput.files[0];

        // Validasi file
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
                const action = "{{ route('tendik.dosen.import.excel') }}";
                const formData = new FormData();
                formData.append("file", file);

                // Show the SweetAlert loading popup
                Swal.fire({
                    title: 'Mengimpor Data',
                    html: 'Proses impor data sedang berlangsung...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Perform the import
                DataManager.formData(action, formData, 'POST').then(response => {
                    Swal.close(); // Hide the loading popup
                    if (response.success) {
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data telah berhasil dikirim',
                            icon: 'success'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        let errorMessage = 'Terjadi Kesalahan: ';
                        if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            errorMessage = 'Terjadi Kesalahan Validasi';
                        } else {
                            errorMessage = response.message;
                        }

                        Swal.fire({
                            title: 'Oops...',
                            text: errorMessage,
                            icon: 'error'
                        });
                    }
                }).catch(error => {
                    Swal.close(); // Hide the loading popup
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
