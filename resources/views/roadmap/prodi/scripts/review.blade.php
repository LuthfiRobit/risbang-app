<script>
    let id = '';
    $("#modal_review").on("show.bs.modal", function(e) {
        document.getElementById("from_review").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('roadmap.prodi.show', [':id']) }}';

        // Menampilkan tombol simpan review
        $("#btn_review_simpan").show();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#komentar").val(response.data.komentar);
                    $("#keputusan").val(response.data.status);
                    // Mengatur visibilitas tombol berdasarkan status
                    if (response.data.status == 'Acc') {
                        $("#btn_review_simpan").hide(); // Menyembunyikan tombol jika statusnya 'Acc'
                    } else {
                        $("#btn_review_simpan").show(); // Menampilkan tombol jika statusnya bukan 'Acc'
                    }
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#from_review").on("submit", function(e) {
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
                const update = '{{ route('roadmap.prodi.review', [':id']) }}';
                const input = {
                    "keputusan": $("#keputusan").val(),
                    "komentar": $("#komentar").val()
                };
                DataManager.putData(update.replace(':id', id), input).then(response => {
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
