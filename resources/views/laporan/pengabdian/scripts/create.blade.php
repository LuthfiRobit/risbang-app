<script>
    // Validate correspondent checkbox on form submit
    $('#form_create').on("submit", function(e) {

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
                const action = "{{ route('laporan.pengabdian.store') }}";
                const formData = new FormData();
                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
                    formData.append("id_owner", $("#id_owner").val());
                    const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                    formData.append("publish", publishStatus);
                @endif
                formData.append("ta", $("#ta").val());
                formData.append("judul", $("#judul").val());
                formData.append("sumber", $("#sumber").val());
                formData.append("jumlah", $("#jumlah").val());
                formData.append("tahun", $("#tahun").val());
                formData.append("abstrak", $("#abstrak").val());
                formData.append("file", $("#file")[0].files[0]);
                if ($("#file")[0].files.length > 0) {
                    formData.append("file", $("#file")[0].files[0]);
                }

                // Dosen Dalam
                $("#table_dosen_dalam tbody tr").each(function() {
                    const dosenDalam = $(this).find('select[name="penulis_dosen_dalam[]"]')
                        .val();
                    const statusDalam = $(this).find('select[name="peran_dosen_dalam[]"]')
                        .val();
                    const correspondentDalam = $(this).find('input[name="aktif_dosen_dalam[]"]')
                        .is(':checked') ? 1 : 0;
                    formData.append("penulis_dosen_dalam[]", dosenDalam);
                    formData.append("peran_dosen_dalam[]", statusDalam);
                    formData.append("aktif_dosen_dalam[]", correspondentDalam);
                });

                // Dosen Luar
                $("#table_dosen_luar tbody tr").each(function() {
                    const dosenLuar = $(this).find('select[name="penulis_dosen_luar[]"]')
                        .val();
                    const statusLuar = $(this).find('select[name="peran_dosen_luar[]"]')
                        .val();
                    const correspondentLuar = $(this).find('input[name="aktif_dosen_luar[]"]')
                        .is(':checked') ? 1 : 0;
                    formData.append("penulis_dosen_luar[]", dosenLuar);
                    formData.append("peran_dosen_luar[]", statusLuar);
                    formData.append("aktif_dosen_luar[]", correspondentLuar);
                });

                // Dosen Lain
                $("#table_dosen_lain tbody tr").each(function() {
                    const dosenLain = $(this).find('select[name="penulis_dosen_lain[]"]')
                        .val();
                    const statusLain = $(this).find('select[name="peran_dosen_lain[]"]')
                        .val();
                    const correspondentLain = $(this).find('input[name="aktif_dosen_lain[]"]')
                        .is(':checked') ? 1 : 0;
                    formData.append("penulis_dosen_lain[]", dosenLain);
                    formData.append("peran_dosen_lain[]", statusLain);
                    formData.append("aktif_dosen_lain[]", correspondentLain);
                });

                // Check if at least one correspondent is selected
                var correspondentChecked = false;
                $('.correspondent').each(function() {
                    if ($(this).prop('checked')) {
                        correspondentChecked = true;
                    }
                });

                if (!correspondentChecked) {
                    Swal.fire('Oops...', 'Pilih salah satu penulis aktif.', 'error');
                    return;
                }

                DataManager.formData(action, formData, 'POST').then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            // location.reload();
                            window.location.href =
                                "{{ route('laporan.pengabdian.index') }}";
                        }, 2000);
                    } else if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter();
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                    } else if (!response.success && !response.errors) {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Oops...', 'Error', 'error');
                });
            }
        });
    });


    $(document).ready(function() {
        @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
            const ownerUrl =
                '{{ route('global.dosen.has.proposal.peng') }}'; // Adjust the route name accordingly
            fetch(ownerUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $.each(data, function(key, item) {
                            $("#id_owner").append($("<option></option>")
                                .attr("value", item.id)
                                .text(item.show));
                        });
                        $("#id_owner").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        @endif
    });
</script>
