<script>
    $(document).ready(function() {
        function handleSubmitForm(formId, jenis) {
            const suffix = jenis === 'Penelitian' ? 'pene' : 'peng';
            const komenId = `#komen_akhir_${suffix}`;
            const nilaiId = `#nilai_akhir_${suffix}`;
            const keputusanId = `#keputusan_akhir_${suffix}`;

            $(formId).on("submit", function(e) {
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
                        const action = "{{ route('review.akhir.store') }}";
                        const input = {
                            "akhir_id": $(formId).data("kem"),
                            "komen": $(komenId).val(),
                            "nilai": $(nilaiId).val(),
                            "status_review": $(keputusanId).val(),
                        };
                        DataManager.postData(action, input)
                            .then(response => {
                                if (response.success) {
                                    Swal.fire('Success', "Data telah berhasil dikirim",
                                        'success');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    handleResponseErrors(response);
                                }
                            })
                            .catch(error => {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            });
                    }
                });
            });
        }

        function handleResponseErrors(response) {
            if (!response.success && response.errors) {
                const validationErrorFilter = new ValidationErrorFilter();
                validationErrorFilter.filterValidationErrors(response);
                Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
            } else if (!response.success && !response.errors) {
                Swal.fire('Oops...', response.message, 'error');
            }
        }

        // Inisialisasi untuk Penelitian dan Pengabdian
        handleSubmitForm('#fm_submit_akhir_penelitian', 'Penelitian');
        handleSubmitForm('#fm_submit_akhir_pengabdian', 'Pengabdian');
    });
</script>
