<script>
    $(document).ready(function() {
        function calculateTotalPenelitian() {
            let total = 0;
            $('.skor_pene').each(function() {
                const skor = parseFloat($(this).val()) || 0;
                const bobot = parseFloat($(this).data('bobot')) || 0;
                const nilai = Math.round(skor * bobot); // Membulatkan nilai
                $(this).closest('tr').find('.nilai').text(nilai); // Menampilkan nilai bulat
                total += nilai;
            });
            $('#nilai_kemajuan_pene').val(Math.round(total)); // Menyimpan total sebagai bilangan bulat
        }

        function calculateTotalPengabdian() {
            let total = 0;
            $('.skor_peng').each(function() {
                const skor = parseFloat($(this).val()) || 0;
                const bobot = parseFloat($(this).data('bobot')) || 0;
                const nilai = Math.round(skor * bobot); // Membulatkan nilai
                $(this).closest('tr').find('.nilai').text(nilai); // Menampilkan nilai bulat
                total += nilai;
            });
            $('#nilai_kemajuan_peng').val(Math.round(total)); // Menyimpan total sebagai bilangan bulat
        }

        $('.skor_pene').on('input', calculateTotalPenelitian);
        $('.skor_peng').on('input', calculateTotalPengabdian);

        function handleSubmit(formId, actionUrl) {
            $(formId).on('submit', function(e) {
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
                        const formData = {
                            "kemajuan_id": $(formId).data('kem'),
                            "komen": $(formId).find('textarea').val(),
                            "skor_publikasi": $(formId).find('input[name="skor_publikasi"]')
                                .val(),
                            "skor_pemakalah": $(formId).find('input[name="skor_pemakalah"]')
                                .val(),
                            "skor_bahan": $(formId).find('input[name="skor_bahan"]').val(),
                            "skor_ttg": $(formId).find('input[name="skor_ttg"]').val(),
                            "nilai": $(formId).find('input[name^="nilai_kemajuan"]').val(),
                            "status_review": $(formId).find('select').val(),
                        };
                        DataManager.postData(actionUrl, formData).then(response => {
                                if (response.success) {
                                    Swal.fire('Success', "Data telah berhasil dikirim",
                                        'success');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    handleError(response);
                                }
                            })
                            .catch(error => {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            });
                    }
                });
            });
        }

        function handleError(response) {
            if (!response.success && response.errors) {
                const validationErrorFilter = new ValidationErrorFilter();
                validationErrorFilter.filterValidationErrors(response);
                Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
            } else if (!response.success && !response.errors) {
                Swal.fire('Oops...', response.message, 'error');
            }
        }

        handleSubmit('#fm_submit_kemajuan_penelitian', "{{ route('review.kemajuan.store') }}");
        handleSubmit('#fm_submit_kemajuan_pengabdian', "{{ route('review.kemajuan.store') }}");
    });
</script>
