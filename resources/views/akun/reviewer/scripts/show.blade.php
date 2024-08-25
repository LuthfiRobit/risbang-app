<script>
    $(document).ready(function() {
        const detail = '{{ route('akun.reviewer.show') }}';
        DataManager.fetchData(detail)
            .then(function(response) {
                if (response.success) {
                    let imgProfile = "";
                    if (response.data.profile_pict !== null) {
                        imgProfile = "background-image: url({{ asset('imgs/profileUser/') }}" + "/" +
                            response.data
                            .profile_pict + ")";
                    } else if (response.data.profile_pict === '') {
                        imgProfile =
                            "background-image: url({{ asset('assets/media/avatars/profil.png') }})";
                    } else {
                        imgProfile =
                            "background-image: url({{ asset('assets/media/avatars/profil.png') }})";
                    }
                    $("#name").val(response.data.nama_reviewer);
                    $("#username").val(response.data.username);
                    $("#email").val(response.data.email);
                    $("#phone_number").val(response.data.phone_number);
                    $("#avatar-show").attr('style', imgProfile);
                } else {
                    Swal.fire('Oops...', 'Data tidak ditemukan', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server' + error, 'error');
            });
    });
</script>
