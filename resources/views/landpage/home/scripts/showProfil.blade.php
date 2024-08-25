<script>
    // Function to fetch data from URL and update HTML elements
    async function fetchDataProfil() {
        try {
            // Ganti 'URL_API_ANDA' dengan URL API yang sesuai
            const response = await fetch('{{ route('landpage.profil.show') }}');
            const result = await response.json();

            if (result.success) {
                // Ambil data dari JSON
                const data = result.data;

                // Update elemen slider
                document.querySelector('#visi .card-body').textContent = data.visi;
                document.querySelector('#misi .card-body').textContent = data.misi;
                document.querySelector('#tujuan .card-body').textContent = data.tujuan;

                // Update elemen info
                document.getElementById('email').textContent = `: ${data.email || 'Tidak tersedia'}`;
                document.getElementById('whatsapp').textContent = `: ${data.no_tlpn || 'Tidak tersedia'}`;
                document.getElementById('alamat').textContent = `: ${data.alamat || 'Tidak tersedia'}`;
            } else {
                console.error('Data tidak tersedia');
            }
        } catch (error) {
            console.error('Terjadi kesalahan:', error);
        }
    }

    // Panggil fungsi fetchData saat halaman dimuat
    window.onload = fetchDataProfil;
</script>
