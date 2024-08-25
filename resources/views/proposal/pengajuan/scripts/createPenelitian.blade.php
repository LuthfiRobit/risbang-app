<script>
    // let id = '';
    $(document).ready(function() {
        formPenelitian = $("#bt_submit_proposal_penelitian");
        id = formPenelitian.data("id");
        // console.log(id);
        const detail = '{{ route('proposal.pengajuan.penelitian.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.file_proposal !== null) {
                        urlPene = "{{ asset('files/proposalPenelitian/') }}" + "/" + response.data
                            .file_proposal;
                        let ex_pene =
                            `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File penelitian</a>`
                        $("#exist-file-pene").append(ex_pene);
                    }
                    $("#penelitian_dana").val(response.data.dana);
                    $("#penelitian_judul").val(response.data.judul);
                    $("#penelitian_abstrak").val(response.data.abstrak);
                    $("#penelitian_kata_kunci").val(response.data.kata_kunci);
                    $("#penelitian_latar_belakang").val(response.data.latar_belakang);
                    $("#penelitian_metode").val(response.data.metode);
                    $("#penelitian_rencana").val(response.data.rencana);
                    $("#penelitian_dapus").val(response.data.dapus);
                    $("#penelitian_jenis_penelitian").val(response.data.jenis_penelitian);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan proposal penelitian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_proposal_penelitian").on("submit", function(e) {
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
                const action = "{{ route('proposal.pengajuan.penelitian.store') }}";

                const formData = new FormData();
                // formData.append("_token", csrfToken);
                formData.append("id", $("#bt_submit_proposal_penelitian").data("id"));
                formData.append("penelitian_dana", $("#penelitian_dana").val());
                formData.append("penelitian_judul", $("#penelitian_judul").val());
                formData.append("penelitian_abstrak", $("#penelitian_abstrak").val());
                formData.append("penelitian_kata_kunci", $("#penelitian_kata_kunci").val());
                formData.append("penelitian_latar_belakang", $("#penelitian_latar_belakang").val());
                formData.append("penelitian_metode", $("#penelitian_metode").val());
                formData.append("penelitian_rencana", $("#penelitian_rencana").val());
                formData.append("penelitian_dapus", $("#penelitian_dapus").val());
                formData.append("penelitian_jenis_penelitian", $("#penelitian_jenis_penelitian").val());
                if ($("#penelitian_file_proposal")[0].files.length > 0) {
                    formData.append("penelitian_file_proposal", $("#penelitian_file_proposal")[0].files[
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
        });
    });
</script>
