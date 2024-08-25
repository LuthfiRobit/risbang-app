<script>
    // let id = '';
    $(document).ready(function() {
        formPengabdian = $("#bt_submit_proposal_pengabdian");
        id = formPengabdian.data("id");
        // console.log(id);
        const detail = '{{ route('proposal.pengajuan.pengabdian.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.file_proposal !== null) {
                        urlPeng = "{{ asset('files/proposalPengabdian/') }}" + "/" + response.data
                            .file_proposal;
                        let ex_peng =
                            `<a href="${urlPeng}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File pengabdian</a>`
                        $("#exist-file-peng").append(ex_peng);
                    }
                    $("#pengabdian_dana").val(response.data.dana);
                    $("#pengabdian_judul").val(response.data.judul);
                    $("#pengabdian_abstrak").val(response.data.abstrak);
                    $("#pengabdian_kata_kunci").val(response.data.kata_kunci);
                    $("#pengabdian_latar_belakang").val(response.data.latar_belakang);
                    $("#pengabdian_metode").val(response.data.metode);
                    $("#pengabdian_rencana").val(response.data.rencana);
                    $("#pengabdian_dapus").val(response.data.dapus);
                    $("#pengabdian_jenis_pengabdian").val(response.data.jenis_pengabdian);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan proposal pengabdian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_proposal_pengabdian").on("submit", function(e) {
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
                const action = "{{ route('proposal.pengajuan.pengabdian.store') }}";
                const formData = new FormData();
                formData.append("id", $("#bt_submit_proposal_pengabdian").data("id"));
                formData.append("pengabdian_dana", $("#pengabdian_dana").val());
                formData.append("pengabdian_judul", $("#pengabdian_judul").val());
                formData.append("pengabdian_abstrak", $("#pengabdian_abstrak").val());
                formData.append("pengabdian_kata_kunci", $("#pengabdian_kata_kunci").val());
                formData.append("pengabdian_latar_belakang", $("#pengabdian_latar_belakang").val());
                formData.append("pengabdian_metode", $("#pengabdian_metode").val());
                formData.append("pengabdian_rencana", $("#pengabdian_rencana").val());
                formData.append("pengabdian_dapus", $("#pengabdian_dapus").val());
                formData.append("pengabdian_jenis_pengabdian", $("#pengabdian_jenis_pengabdian").val());
                if ($("#pengabdian_file_proposal")[0].files.length > 0) {
                    formData.append("pengabdian_file_proposal", $("#pengabdian_file_proposal")[0].files[
                        0]);
                }

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr(
                            'content') // Include the CSRF token in the request headers
                        // 'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the request headers
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        } else if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'info');
                        } else if (!xhr.responseJSON.success && xhr.responseJSON.message ===
                            'Validasi gagal') {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(xhr.responseJSON);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        } else if (!xhr.responseJSON.success && [500, 404, 405, 401, 403]
                            .includes(xhr.status)) {
                            Swal.fire('Oops...', xhr.responseJSON.message, 'error');
                        } else {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        }
                    }
                });
            }
        })

    });
</script>
