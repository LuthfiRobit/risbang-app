<script>
    let id = '';
    $("#modal_edit").on("show.bs.modal", function(e) {
        document.getElementById("form_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('roadmap.dosen.show', [':id']) }}';
        // Menampilkan tombol simpan review
        $("#btn_edit_simpan").show();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_rentan").val(response.data.rentan_waktu_id);
                    $("#edit_jenis").val(response.data.jenis);
                    $("#show_review").val(response.data.komentar);
                    $("#show_status").text(response.data.status);
                    // Mengatur visibilitas tombol berdasarkan status
                    if (response.data.status == 'Acc') {
                        $("#btn_edit_simpan").hide(); // Menyembunyikan tombol jika statusnya 'Acc'
                    } else {
                        $("#btn_edit_simpan").show(); // Menampilkan tombol jika statusnya bukan 'Acc'
                    }
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $('#form_edit').on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Apakah data anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('roadmap.dosen.update', [':id']) }}';
                const formData = new FormData();
                formData.append("edit_rentan", $("#edit_rentan").val());
                formData.append("edit_jenis", $("#edit_jenis").val());
                formData.append("edit_file", $("#edit_file")[0].files[0]);
                if ($("#edit_file")[0].files.length > 0) {
                    formData.append("edit_file", $("#edit_file")[0].files[0]);
                }

                formData.append("_method", "PUT");
                DataManager.formData(update.replace(':id', id), formData, "POST").then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            Swal.fire({
                                title: 'Menyimpan data...',
                                text: 'Silakan tunggu',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            location.reload();
                            // window.location.href =
                            //     "{{ route('laporan.penelitian.index') }}";
                        }, 2000);

                    } else if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter();
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                    } else if (!response.success && !response.errors) {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                }).catch(error => {
                    console.log(error);
                    Swal.fire('Oops...', 'Error', 'error');
                });
            }
        });
    });
</script>
