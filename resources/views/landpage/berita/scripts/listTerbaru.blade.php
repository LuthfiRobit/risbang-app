<script>
    const apiUrlTerbaru =
        '{{ route('landpage.berita.list.terbaru') }}'; // URL endpoint API Anda untuk mengambil data terbaru
    let urlDetail = '{{ route('landpage.berita.detail', ':slug') }}';


    // Fungsi untuk menampilkan spinner loading
    function showLoading() {
        document.getElementById('loading').style.display = 'flex';
    }

    // Fungsi untuk menyembunyikan spinner loading
    function hideLoading() {
        document.getElementById('loading').style.display = 'none';
    }

    // Fungsi untuk mengambil data dari API
    async function fetchData() {
        showLoading(); // Tampilkan spinner loading

        try {
            // Fetch data dari API
            const response = await fetch(apiUrlTerbaru);
            const data = await response.json();

            // Jika data ditemukan
            if (data.success) {
                // Menampilkan data utama
                if (data.data.utama) {
                    renderDataUtama(data.data.utama);
                }

                // Menampilkan data lainnya
                const lainnya = Object.values(data.data.lainnya);
                if (lainnya.length > 0) {
                    renderDataTerbaru(lainnya);
                } else {
                    renderNoDataTerbaru(); // Menangani jika data tidak ditemukan
                }
            } else {
                renderNoDataTerbaru(); // Menangani jika data tidak ditemukan
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        } finally {
            hideLoading(); // Sembunyikan spinner loading setelah data selesai di-fetch
        }
    }

    // Fungsi untuk menampilkan data utama di dalam HTML
    function renderDataUtama(item) {
        const postContentContainer = document.getElementById('berita-utama-container');
        let imgBerita = '';
        urlDetailUtama = urlDetail.replace(':slug', item.slug);

        if (item.img_berita) {
            imgBerita = "{{ asset('imgs/berita/') }}" + "/" + item.img_berita;
        } else {
            imgBerita = "{{ asset('assets/media/illustrations/18.png') }}";
        }

        postContentContainer.innerHTML = `
            <div class="mb-8">
                <div class="d-flex flex-wrap mb-6">
                    <div class="me-9 my-1">
                        <i class="bi bi-calendar text-primary fs-3 me-1"></i>
                        <span class="fw-bold text-gray-500">${item.created_at}</span>
                    </div>
                </div>
                <a href="${urlDetailUtama}" class="text-gray-900 text-hover-primary fs-2 fw-bold">${item.judul}</a>
                <div class="overlay mt-8">
                    <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                        style="background-image:url('${imgBerita}')">
                    </div>
                </div>
            </div>
            <div class="fs-5 fw-semibold text-gray-600" id="deskripsi-utama-container">
                <p class="mb-8">${item.deskripsi}</p>
                <a href="${urlDetailUtama}">Baca selengkapnya</a>
            </div>
        `;
    }

    // Fungsi untuk menampilkan data di dalam HTML
    function renderDataTerbaru(items) {
        const dataContainer = document.getElementById('berita-terbaru-container');
        dataContainer.innerHTML = items.map(item => {
            urlDetailTerbaru = urlDetail.replace(':slug', item.slug);
            let imgBerita = '';
            if (item.img_berita) {
                imgBerita = "{{ asset('imgs/berita/') }}" + "/" + item.img_berita;
            } else {
                imgBerita = "{{ asset('assets/media/illustrations/18.png') }}";
            }
            return `<div class="d-flex flex-stack mb-7">
                        <div class="symbol symbol-60px symbol-2by3 me-4">
                            <div class="symbol-label"
                                style="background-image: url('${imgBerita}')">
                            </div>
                        </div>
                        <div class="m-0">
                            <div class="me-9 my-1">
                                <i class="bi bi-calendar text-primary fs-3 me-1">
                                </i>
                                <span class="fw-bold text-gray-500">${item.created_at}</span>
                            </div>
                            <a href="${urlDetailTerbaru}" class="text-gray-900 fw-bold text-hover-primary fs-6">${item.judul}</a>
                        </div>
                    </div>`;
        }).join(''); // Gabungkan semua item menjadi satu string HTML
    }

    // Fungsi untuk menangani kasus di mana data tidak ditemukan
    function renderNoDataTerbaru() {
        const dataContainer = document.getElementById('berita-terbaru-container');
        dataContainer.innerHTML = '<p>Data tidak ditemukan</p>';
    }

    // Inisialisasi data awal
    fetchData();
</script>
