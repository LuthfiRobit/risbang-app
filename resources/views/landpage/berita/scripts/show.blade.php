<script>
    // Fungsi untuk menampilkan spinner loading
    function showLoading() {
        document.getElementById('loading').style.display = 'flex';
    }

    // Fungsi untuk menyembunyikan spinner loading
    function hideLoading() {
        document.getElementById('loading').style.display = 'none';
    }

    // Fungsi untuk mendapatkan slug dari URL
    function getSlugFromUrl() {
        const path = window.location.pathname;
        const segments = path.split('/');
        return segments[segments.length - 1];
    }

    // Mendapatkan slug dari URL
    const slug = getSlugFromUrl();

    // URL endpoint API untuk mengambil detail berita
    const apiUrlDetail = `{{ route('landpage.berita.show', ['slug' => '__SLUG__']) }}`.replace('__SLUG__', slug);

    // Fungsi untuk mengambil data dari API
    async function fetchDetailData() {
        showLoading(); // Menampilkan spinner saat data sedang diambil
        try {
            const response = await fetch(apiUrlDetail);
            const data = await response.json();

            if (data.success) {
                renderDetailData(data.data); // Menampilkan data detail
            } else {
                renderNoDataDetail(); // Menangani jika data tidak ditemukan
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            hideLoading(); // Menyembunyikan spinner setelah data berhasil diambil atau terjadi error
        }
    }

    // Fungsi untuk menampilkan data detail di dalam HTML
    function renderDetailData(item) {
        const postContentContainer = document.getElementById('berita-detail-container');
        let imgBerita = '';

        if (item.img_berita) {
            imgBerita = `{{ asset('imgs/berita/') }}/${item.img_berita}`;
        } else {
            imgBerita = `{{ asset('assets/media/illustrations/18.png') }}`;
        }

        postContentContainer.innerHTML = `
            <div class="mb-8">
                <div class="d-flex flex-wrap mb-6">
                    <div class="me-9 my-1">
                        <i class="bi bi-calendar text-primary fs-3 me-1"></i>
                        <span class="fw-bold text-gray-500">${item.created_at}</span>
                    </div>
                </div>
                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold">${item.judul}</a>
                <div class="overlay mt-8">
                    <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                        style="background-image:url('${imgBerita}')">
                    </div>
                </div>
            </div>
            <div class="fs-5 fw-semibold text-gray-600" id="deskripsi-utama-container">
                ${item.deskripsi}
            </div>
        `;
    }

    // Fungsi untuk menangani kasus di mana data tidak ditemukan
    function renderNoDataDetail() {
        const postContentContainer = document.getElementById('berita-detail-container');
        postContentContainer.innerHTML = '<p>Data tidak ditemukan</p>';
    }

    // Inisialisasi data detail
    fetchDetailData();
</script>
