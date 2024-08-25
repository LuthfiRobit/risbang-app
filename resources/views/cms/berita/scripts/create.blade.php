<script>
    "use strict";

    function handleFormSubmit() {
        var form = document.querySelector('#form_create');
        var submitButton = document.querySelector('#bt_submit_create');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!KTFormsCKEditorClassic.validateCKEditor()) {
                Swal.fire('Oops...', 'Deskripsi tidak boleh kosong', 'error');
                return;
            }

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
                if (result.isConfirmed) {
                    const action = "{{ route('cms.berita.store') }}";
                    const formData = new FormData();
                    formData.append("judul", $("#judul").val());
                    formData.append("deskripsi", $("#kt_docs_ckeditor_classic").val());
                    const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                    formData.append("publish", publishStatus);

                    if ($("#gambar")[0].files.length > 0) {
                        formData.append("gambar", $("#gambar")[0].files[0]);
                    }

                    DataManager.formData(action, formData, 'POST')
                        .then(response => {
                            if (response.success) {
                                Swal.fire('Success', 'Data telah berhasil dikirim', 'success');
                                setTimeout(function() {
                                    window.location.href =
                                    "{{ route('cms.berita.index') }}";
                                }, 2000);
                            } else if (response.errors) {
                                const validationErrorFilter = new ValidationErrorFilter();
                                validationErrorFilter.filterValidationErrors(response);
                                Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                            } else {
                                Swal.fire('Oops...', response.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        handleFormSubmit();
    });
</script>
