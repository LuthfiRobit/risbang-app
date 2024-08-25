<script>
    let id = '';
    $("#form_edit").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('setting.dosen.management.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                console.log(response);
                if (response.success) {
                    let idf = '';
                    let idp = '';

                    $("#select_fakultas").empty();
                    $("#select_prodi").empty();

                    if (response.data.dosen_role === 'dekan') {
                        idf = response.data.id_fakultas;
                        $("#select_fakultas").append(
                            "<select class='selectpicker form-control form-control-sm' name='fakultas' id='fakultas' data-live-search='true' title='Pilih Fakultas' required></select>" +
                            "<ul id='error-list' class='list-unstyled text-danger'></ul>"
                        );
                        // $("#select_prodi").hide();
                    } else if (response.data.dosen_role === 'kaprodi') {
                        idf = response.data.fakultas_id;
                        idp = response.data.id_prodi;
                        $("#select_fakultas").append(
                            "<select class='selectpicker form-control form-control-sm' name='fakultas' id='fakultas' data-live-search='true' title='Pilih Fakultas' required></select>" +
                            "<ul id='error-list' class='list-unstyled text-danger'></ul>"
                        );
                        $("#select_prodi").append(
                            "<select class='selectpicker form-control form-control-sm' name='prodi' id='prodi' data-live-search='true' title='Pilih Program Studi' required></select>" +
                            "<ul id='error-list' class='list-unstyled text-danger'></ul>"
                        ).show();
                    } else {
                        Swal.fire('Oops...', 'Dosen tidak memiliki jabatan', 'info');
                    }

                    const get = '{{ route('tendik.fakultas.list.json') }}';
                    DataManager.fetchData(get)
                        .then(function(response) {
                            if (response.success) {
                                let data = response.data;
                                $.each(data, function(key, item) {
                                    let selected = item.id_fakultas === idf ? 'selected' : '';
                                    $("#fakultas").append($("<option></option>")
                                        .attr("value", item.id_fakultas)
                                        .prop('selected', selected)
                                        .text(item.nama_fakultas));
                                });
                                $("#fakultas").selectpicker("refresh");
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(function(error) {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });

                    if (idf && response.data.dosen_role === 'kaprodi') {
                        const getd = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
                        DataManager.fetchData(getd.replace(':id', idf))
                            .then(function(response) {
                                if (response.success) {
                                    let data = response.data;
                                    // $("#prodi").empty();
                                    $.each(data, function(key, item) {
                                        let selected = item.id_prodi === idp ? 'selected' : '';
                                        $("#prodi").append($('<option></option>')
                                            .attr('value', item.id_prodi)
                                            .prop('selected', selected)
                                            .text(item.nama_prodi));
                                    });
                                    $("#prodi").selectpicker('refresh');
                                } else {
                                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                                }
                            })
                            .catch(function(error) {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            });
                    }

                    // $("#edit_data_role").on('change', function() {
                    //     const role = $(this).val();
                    //     if (role === 'dosen') {
                    //         $("#select_fakultas").hide();
                    //         $("#select_prodi").hide();
                    //     } else if (role === 'dekan') {
                    //         $("#select_fakultas").show();
                    //         $("#select_prodi").hide();
                    //     } else if (role === 'kaprodi') {
                    //         $("#select_fakultas").show();
                    //         $("#select_prodi").show();
                    //     }
                    // });

                    $("#fakultas").on('change', function() {
                        const id = $(this).val();
                        const getd = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
                        DataManager.fetchData(getd.replace(':id', id))
                            .then(function(response) {
                                if (response.success) {
                                    let data = response.data;
                                    $("#prodi").empty();
                                    $.each(data, function(key, item) {
                                        $("#prodi").append($('<option></option>')
                                            .attr('value', item.id_prodi)
                                            .text(item.nama_prodi));
                                    });
                                    $("#prodi").selectpicker('refresh');
                                } else {
                                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                                }
                            })
                            .catch(function(error) {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            });
                    });

                    $("#edit_data_dosen").val(response.data.id_user);
                    $("#edit_data_role").val(response.data.dosen_role);
                    // $("#edit_data_fakultas").val(response.data.id_fakultas);
                    // $("#edit_data_prodi").val(response.data.id_prodi);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });


    $("#edit_data_role").on("change", function() {
        role = $(this).val();
        $('#select_fakultas').empty();
        $('#select_prodi').empty();
        if (role === 'dekan') {

            $("#select_fakultas").append(
                "<select class='selectpicker form-control form-control-sm' name='fakultas' id='fakultas' data-live-search='true' title='Pilih Fakultas' required></select>" +
                "<ul id='error-list' class='list-unstyled text-danger'></ul>"
            );

        } else if (role === 'kaprodi') {

            $("#select_fakultas").append(
                "<select class='selectpicker form-control form-control-sm' name='fakultas' id='fakultas' data-live-search='true' title='Pilih Fakultas' required></select>" +
                "<ul id='error-list' class='list-unstyled text-danger'></ul>"
            );

            $("#select_prodi").append(
                "<select class='selectpicker form-control form-control-sm' name='prodi' id='prodi' data-live-search='true' title='Pilih Program Studi' required></select>" +
                "<ul id='error-list' class='list-unstyled text-danger'></ul>"
            );

        } else {

            Swal.fire('Oops...', 'Kesalahan server', 'error');

        }

        const get = '{{ route('tendik.fakultas.list.json') }}';
        DataManager.fetchData(get)
            .then(function(response) {
                if (response.success) {
                    var data = response.data;
                    // console.log(data);
                    $.each(data, function(key, item) {
                        $("#fakultas").append($("<option></option>").attr("value", item
                            .id_fakultas).text(item.nama_fakultas));
                    })
                    $("#fakultas").selectpicker("refresh");
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });

        $("#fakultas").on('change', function() {
            console.log($(this).val());
            $("#prodi").selectpicker('refresh');
            id = $(this).val();
            const getd = '{{ route('tendik.prodi.by.fakultas', [':id']) }}';
            DataManager.fetchData(getd.replace(':id', id))
                .then(function(response) {
                    if (response.success) {
                        var data = response.data;
                        // console.log(data);
                        $("#prodi").empty();
                        $.each(data, function(key, item) {
                            $("#prodi").append($('<option></option>').attr(
                                'value', item.id_prodi).text(item
                                .nama_prodi));
                        })
                        $("#prodi").selectpicker('refresh');
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        });

        $("#prodi").on('change', function() {
            console.log($(this).val());
        });

        $("#fakultas").selectpicker("refresh").selectpicker("render");
        $("#prodi").selectpicker("refresh").selectpicker("render");

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
                const action = "{{ route('setting.dosen.management.store') }}";
                const input = {
                    "fakultas": $("#fakultas").val(),
                    "prodi": $("#prodi").val(),
                    "role": $("#edit_data_role").val(),
                    "dosen": $("#edit_data_dosen").val()
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
                            // console.log(response.message);
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
