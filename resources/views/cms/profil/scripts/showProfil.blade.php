<script>
    $(document).ready(function() {

        const apiUrlDetail = `{{ route('cms.profil.show.profil') }}`;

        DataManager.fetchData(apiUrlDetail)
            .then(function(response) {
                if (response.success) {
                    console.log(response);
                    const data = response.data;
                    $("#visi").val(data.visi);
                    $("#misi").val(data.misi);
                    $("#tujuan").val(data.tujuan);
                    $("#tentang").val(data.tentang);
                    $("#email").val(data.email);
                    $("#phone").val(data.no_tlpn);
                    $("#alamat").val(data.alamat);
                } else {
                    Swal.fire('Oops...', 'Data profil tidak ditemukan', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
                console.error(error);
            });
    });
</script>
