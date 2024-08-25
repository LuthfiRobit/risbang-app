<script>
    $("#role").on("change", function() {
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


    $("#dosen").on('change', function() {
        console.log($(this).val());
    });

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
                const action = "{{ route('setting.dosen.management.store') }}";
                const input = {
                    "fakultas": $("#fakultas").val(),
                    "prodi": $("#prodi").val(),
                    "role": $("#role").val(),
                    "dosen": $("#dosen").val()
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
