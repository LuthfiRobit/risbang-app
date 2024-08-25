<script>
    $("#active").click(function() {
        if (rows_selected.length > 0) {
            $("#active").prop("disabled", true);
            const input = {
                "id_reviewer": rows_selected,
                "aktif": "y",
            };
            DataManager.postData('{{ route('master.reviewer.update.multiple') }}', input).then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                    $("#active").prop("disabled", false);
                })
                .catch(error => {
                    $("#active").prop("disabled", false);
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }
    });
    $("#block").click(function() {
        if (rows_selected.length > 0) {
            $("#block").prop("disabled", true);
            const input = {
                "id_reviewer": rows_selected,
                "aktif": "t",
            };
            DataManager.postData('{{ route('master.reviewer.update.multiple') }}', input).then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                    $("#block").prop("disabled", false);
                })
                .catch(error => {
                    $("#block").prop("disabled", false);
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }
    });
</script>
