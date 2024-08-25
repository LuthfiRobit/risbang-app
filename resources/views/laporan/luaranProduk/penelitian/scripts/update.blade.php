<script>
    // Validate correspondent checkbox on form submit

    let id = '';
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
                id = '{{ Route::current()->parameter('id') }}';
                const update = '{{ route('laporan.penelitian.luaran.produk.update', [':id']) }}';
                const formData = new FormData();

                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
                    const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                    formData.append("publish", publishStatus);
                @endif

                formData.append("arsip", $("#arsip").find('option:selected').data('arsip'));
                formData.append("dosen", $("#arsip").find('option:selected').data('dosen'));
                formData.append("judul", $("#judul").val());
                formData.append("tkt", $("#tkt").val());
                formData.append("level", $("#level").val());
                formData.append("ta", $("#ta").val());
                formData.append("tahun", $("#tahun").val());
                formData.append("link", $("#link").val());
                formData.append("mitra", $("#mitra").val());
                formData.append("jenis_mitra", $("#jenis_mitra").val());
                formData.append("negara_mitra", $("#negara_mitra").val());
                formData.append("deskripsi", $("#deskripsi").val());

                formData.append("file", $("#file")[0].files[0]);
                if ($("#file")[0].files.length > 0) {
                    formData.append("file", $("#file")[0].files[0]);
                }

                formData.append("cover", $("#cover")[0].files[0]);
                if ($("#cover")[0].files.length > 0) {
                    formData.append("cover", $("#cover")[0].files[0]);
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
