<script>
    const apiUrl = '{{ route('landpage.berita.list') }}'; // URL endpoint API Anda
    let currentPage = 1; // Halaman saat ini
    const itemsPerPage = 6; // Jumlah item per halaman

    // Variabel filter
    let filterJudul = '';

    // Fungsi untuk mengambil data dari API
    async function fetchData(page = 1) {
        try {
            // Buat query string dengan filter
            const query = new URLSearchParams({
                page,
                filter_judul: filterJudul,
            }).toString();

            // Fetch data dari API
            const response = await fetch(`${apiUrl}?${query}`);
            const data = await response.json();

            // Jika data ditemukan
            if (data.success && data.data.data.length > 0) {
                renderData(data.data.data); // Menampilkan data
                renderPagination(data.data); // Menampilkan pagination
                currentPage = data.data.current_page; // Update currentPage
            } else {
                renderNoData(); // Menangani jika data tidak ditemukan
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    // Fungsi untuk menampilkan data di dalam HTML
    function renderData(items) {
        const dataContainer = document.getElementById('berita-container');
        dataContainer.innerHTML = items.map(item => {
            urlDetailList = urlDetail.replace(':slug', item.slug);
            let imgBerita = '';
            if (item.img_berita !== null && item.img_berita !== '') {
                imgBerita = "{{ asset('imgs/berita/') }}" + "/" + item.img_berita;
            } else {
                imgBerita = "{{ asset('assets/media/illustrations/18.png') }}";
            }
            return `<div class="col-md-4">
                        <!--begin::Hot sales post-->
                        <div class="card-xl-stretch me-md-6">
                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="${urlDetailList}">
                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                    style="background-image:url('${imgBerita}')">
                                </div>
                            </a>
                            <div class="mt-5">
                                <div class="me-9 my-1">
                                    <i class="bi bi-calendar text-primary fs-6 me-1"></i>
                                    <span class="fw-bold text-gray-500">${item.created_at}</span>
                                </div>
                                <a href="${urlDetailList}" class="fs-4 text-gray-900 fw-bold text-hover-primary text-gray-900 lh-base">${item.judul}</a>
                                <div class="fw-semibold fs-5 text-gray-600 text-gray-900 mt-3 text-justify">${item.deskripsi}</div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Hot sales post-->
                    </div>`;
        }).join(''); // Gabungkan semua item menjadi satu string HTML
    }

    // Fungsi untuk menampilkan pagination di dalam HTML
    function renderPagination(pagination) {
        const paginationContainer = document.getElementById('pagination-container');
        const paginationList = paginationContainer.querySelector('.pagination');

        // Hapus tombol pagination yang ada
        paginationList.innerHTML = '';

        // Tombol "Previous"
        const prevButton = document.createElement('li');
        prevButton.className = 'page-item previous';
        prevButton.innerHTML = `<a href="#" class="page-link"><i class="previous"></i></a>`;
        prevButton.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault();
            if (pagination.prev_page_url) {
                fetchData(new URL(pagination.prev_page_url).searchParams.get('page'));
            }
        });
        paginationList.appendChild(prevButton);

        // Tombol angka halaman
        pagination.links.forEach(link => {
            if (link.label === 'pagination.previous' || link.label === 'pagination.next')
                return; // Lewati link non-numerik
            const pageItem = document.createElement('li');
            pageItem.className = `page-item ${link.active ? 'active' : ''}`;
            pageItem.innerHTML = `<a href="#" class="page-link">${link.label}</a>`;
            pageItem.querySelector('a').addEventListener('click', (e) => {
                e.preventDefault();
                fetchData(new URL(link.url).searchParams.get('page'));
            });
            paginationList.appendChild(pageItem);
        });

        // Tombol "Next"
        const nextButton = document.createElement('li');
        nextButton.className = 'page-item next';
        nextButton.innerHTML = `<a href="#" class="page-link"><i class="next"></i></a>`;
        nextButton.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault();
            if (pagination.next_page_url) {
                fetchData(new URL(pagination.next_page_url).searchParams.get('page'));
            }
        });
        paginationList.appendChild(nextButton);

        // Teks "Showing X to Y of Z entries"
        const showingText = `Showing ${pagination.from} to ${pagination.to} of ${pagination.total} entries`;
        paginationContainer.querySelector('.fs-6').textContent = showingText;
    }

    // Fungsi untuk menangani kasus di mana data tidak ditemukan
    function renderNoData() {
        const dataContainer = document.getElementById('berita-container');
        const paginationContainer = document.getElementById('pagination-container');

        // Tampilkan pesan bahwa data tidak ditemukan
        dataContainer.innerHTML = '<p>Data tidak ditemukan</p>';

        // Reset pagination ke kondisi awal atau menyembunyikannya
        const paginationList = paginationContainer.querySelector('.pagination');
        paginationList.innerHTML = ''; // Hapus semua item pagination

        paginationContainer.querySelector('.fs-6').textContent = ''; // Hapus teks "showing"

        // Opsi: tambahkan pagination minimal untuk halaman 1
        const pageItem = document.createElement('li');
        pageItem.className = 'page-item active';
        pageItem.innerHTML = `<a href="#" class="page-link">1</a>`;
        paginationList.appendChild(pageItem);
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Fungsi debounce untuk filter judul
    const handleFilterInput = debounce(function() {
        filterJudul = this.value;
        currentPage = 1; // Reset page ke 1
        fetchData(currentPage);
    }, 500); // Tunggu 500ms setelah input berhenti

    // Inisialisasi data awal
    fetchData(currentPage);

    // Event listener untuk filter Judul (filter_judul)
    document.getElementById('filter_judul').addEventListener('input', handleFilterInput);
</script>
