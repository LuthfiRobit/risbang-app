<script>
    let id = '';

    $('#edit_data_fakultas').on('change', function() {
        $('#edit_data_prodi').selectpicker('refresh');
        idf = $(this).val();
        const get = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
        DataManager.fetchData(get.replace(':id', idf))
            .then(function(response) {
                if (response.success) {
                    var data = response.data;
                    // console.log(data);
                    $('#edit_data_prodi').empty();
                    $.each(data, function(key, item) {
                        $('#edit_data_prodi').append($('<option></option>').attr(
                            'value', item.id_prodi).text(item
                            .nama_prodi));
                    })
                    $('#edit_data_prodi').selectpicker('refresh');
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#form_edit").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('tendik.dosen.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    idf = response.data.id_fakultas;
                    idp = response.data.id_prodi;
                    const get = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
                    DataManager.fetchData(get.replace(':id', idf))
                        .then(function(response) {
                            if (response.success) {
                                var data = response.data;
                                // console.log(data);
                                $('#edit_data_prodi').empty();
                                $.each(data, function(key, item) {
                                    if (item.id_prodi === idp) {
                                        selected = 'selected';
                                    } else {
                                        selected = '';
                                    }
                                    // console.log(selected);
                                    $('#edit_data_prodi').append($('<option></option>').attr(
                                        'value', item.id_prodi).prop('selected',
                                        selected).text(item.nama_prodi));
                                })
                                $('#edit_data_prodi').selectpicker('refresh').selectpicker('render');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(function(error) {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });

                    $("#edit_data_fakultas").val(response.data.id_fakultas);
                    $("#edit_data_status_dosen").val(response.data.status_dosen);
                    $("#edit_data_prodi").val(response.data.id_prodi);
                    $("#edit_data_nidn").val(response.data.nidn);
                    $("#edit_data_nama_dosen").val(response.data.nama_dosen);
                    $("#edit_data_email").val(response.data.email);
                    $("#edit_data_username").val(response.data.username);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                    // console.log(idp);
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit").on("submit", function(e) {
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
                const update = '{{ route('tendik.dosen.update', [':id']) }}';
                const input = {
                    "fakultas": $("#edit_data_fakultas").val(),
                    "prodi": $("#edit_data_prodi").val(),
                    "status": $("#edit_data_status_dosen").val(),
                    "nama_dosen": $("#edit_data_nama_dosen").val(),
                    "nidn": $("#edit_data_nidn").val(),
                    "username": $("#edit_data_username").val(),
                    "email": $("#edit_data_email").val(),
                    "password": $("#edit_data_password").val(),
                    "password_confirmation": $("#edit_data_password_confirmation").val(),
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
