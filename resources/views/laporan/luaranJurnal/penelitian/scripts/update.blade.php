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
                const update = '{{ route('laporan.penelitian.luaran.jurnal.update', [':id']) }}';
                const formData = new FormData();
                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
                    formData.append("id_owner", $("#id_owner").val());
                    const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                    formData.append("publish", publishStatus);
                @endif
                formData.append("ta", $("#ta").val());
                formData.append("judul", $("#judul").val());
                formData.append("penerbit", $("#penerbit").val());
                formData.append("kategori", $("#kategori").val());
                formData.append("peringkat", $("#peringkat").val());
                formData.append("halaman", $("#halaman").val());
                formData.append("volume", $("#volume").val());
                formData.append("nomor", $("#nomor").val());
                formData.append("issn", $("#issn").val());
                formData.append("tahun", $("#tahun").val());
                formData.append("url", $("#url").val());
                formData.append("abstrak", $("#abstrak").val());
                formData.append("file", $("#file")[0].files[0]);
                if ($("#file")[0].files.length > 0) {
                    formData.append("file", $("#file")[0].files[0]);
                }

                // Dosen Dalam
                $("#table_dosen_dalam tbody tr").each(function() {
                    const idDosenDalam = $(this).find('select[name="id_penulis_dosen_dalam[]"]')
                        .val();
                    const dosenDalam = $(this).find('select[name="penulis_dosen_dalam[]"]')
                        .val();
                    const statusDalam = $(this).find('select[name="peran_dosen_dalam[]"]')
                        .val();
                    const correspondentDalam = $(this).find('input[name="aktif_dosen_dalam[]"]')
                        .is(':checked') ? 1 : 0;
                    const afiliasiDalam = $(this).find('input[name="afiliasi_dosen_dalam[]"]')
                        .val();
                    formData.append("id_penulis_dosen_dalam[]", idDosenDalam);
                    formData.append("penulis_dosen_dalam[]", dosenDalam);
                    formData.append("peran_dosen_dalam[]", statusDalam);
                    formData.append("aktif_dosen_dalam[]", correspondentDalam);
                    formData.append("afiliasi_dosen_dalam[]", afiliasiDalam);
                });

                // Dosen Luar
                $("#table_dosen_luar tbody tr").each(function() {
                    const idDosenLuar = $(this).find('select[name="id_penulis_dosen_luar[]"]')
                        .val();
                    const dosenLuar = $(this).find('select[name="penulis_dosen_luar[]"]')
                        .val();
                    const statusLuar = $(this).find('select[name="peran_dosen_luar[]"]')
                        .val();
                    const correspondentLuar = $(this).find('input[name="aktif_dosen_luar[]"]')
                        .is(':checked') ? 1 : 0;
                    const afiliasiLuar = $(this).find('input[name="afiliasi_dosen_luar[]"]')
                        .val();
                    formData.append("id_penulis_dosen_luar[]", idDosenLuar);
                    formData.append("penulis_dosen_luar[]", dosenLuar);
                    formData.append("peran_dosen_luar[]", statusLuar);
                    formData.append("aktif_dosen_luar[]", correspondentLuar);
                    formData.append("afiliasi_dosen_luar[]", afiliasiLuar);
                });

                // Dosen Lain
                $("#table_dosen_lain tbody tr").each(function() {
                    const idDosenLain = $(this).find('select[name="id_penulis_dosen_lain[]"]')
                        .val();
                    const dosenLain = $(this).find('select[name="penulis_dosen_lain[]"]')
                        .val();
                    const statusLain = $(this).find('select[name="peran_dosen_lain[]"]')
                        .val();
                    const correspondentLain = $(this).find('input[name="aktif_dosen_lain[]"]')
                        .is(':checked') ? 1 : 0;
                    const afiliasiLain = $(this).find('input[name="afiliasi_dosen_lain[]"]')
                        .val();
                    formData.append("id_penulis_dosen_lain[]", idDosenLain);
                    formData.append("penulis_dosen_lain[]", dosenLain);
                    formData.append("peran_dosen_lain[]", statusLain);
                    formData.append("aktif_dosen_lain[]", correspondentLain);
                    formData.append("afiliasi_dosen_lain[]", afiliasiLain);
                });

                // Check if at least one correspondent is selected
                var correspondentChecked = false;
                $('.correspondent').each(function() {
                    if ($(this).prop('checked')) {
                        correspondentChecked = true;
                    }
                });

                if (!correspondentChecked) {
                    Swal.fire('Oops...', 'Pilih salah satu penulis koresponden.', 'error');
                    return;
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
