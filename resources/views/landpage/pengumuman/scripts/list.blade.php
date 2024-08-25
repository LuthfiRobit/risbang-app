<script>
    const apiUrl = '{{ route('landpage.pengumuman.list') }}'; // URL endpoint API Anda
    let currentPage = 1; // Halaman saat ini
    let filterJenis = ''; // Filter jenis pengumuman

    // Fungsi untuk mengambil data dari API
    async function fetchData(page = 1, filterJenis = '') {
        try {
            // Buat query string dengan filter
            const query = new URLSearchParams({
                page,
                filter_jenis: filterJenis
            }).toString();

            // Fetch data dari API
            const response = await fetch(`${apiUrl}?${query}`);
            const data = await response.json();

            // Jika data ditemukan
            if (data.success) {
                if (data.data.data.length > 0) {
                    renderData(data.data.data); // Menampilkan data
                    renderPagination(data.data); // Menampilkan pagination
                } else {
                    renderNoData(); // Menangani jika data tidak ditemukan
                }
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    // Fungsi untuk menampilkan data di dalam HTML
    function renderData(items) {
        const dataContainer = document.getElementById('pengumuman-container');
        dataContainer.innerHTML = items.map(item => {
            const tgl = formatTanggal(item.created_at); // Format tanggal dengan jam dan menit
            const isPengumuman = item.jenis === 'Pengumuman';
            const type = isPengumuman ? 'Pengumuman' : 'Pedoman';
            const color = isPengumuman ? 'primary' : 'danger';
            const icon = isPengumuman ? 'info-circle' : 'info-circle';
            const fileLabel = isPengumuman ? 'Download Berkas Pengumuman' : 'Download Berkas Pedoman';

            return `
            <div class="timeline-items mb-3 border-${color} rounded border border-dashed pt-3">
                <div class="timeline-item">
                    <div class="timeline-media m-3">
                        <span><i class="bi bi-${icon} text-${color} fs-1"></i></span>
                    </div>
                    <div class="timeline-content">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="mr-2">
                                <a href="#" class="text-${color} text-hover-${color} fw-bolder">${type}</a>
                                <span class="text-muted ml-2"> | ${tgl}</span>
                            </div>
                        </div>
                        <div class="row">
                            <span class="fs-12 text-gray-700 fw-bolder">${item.judul}</span>
                            <div class="row">
                                <a href="${item.url ? item.url : '{{ asset('files/pengumuman/') }}' + '/' + item.file_pengumuman}" target="_blank" class="d-flex align-items-center text-${color} text-hover-success me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <i class="bi bi-download"></i>
                                    </span>
                                    ${fileLabel}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
                fetchData(new URL(pagination.prev_page_url).searchParams.get('page'), filterJenis);
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
                fetchData(new URL(link.url).searchParams.get('page'), filterJenis);
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
                fetchData(new URL(pagination.next_page_url).searchParams.get('page'), filterJenis);
            }
        });
        paginationList.appendChild(nextButton);

        // Teks "Showing X to Y of Z entries"
        const showingText = `Showing ${pagination.from} to ${pagination.to} of ${pagination.total} entries`;
        paginationContainer.querySelector('.fs-6').textContent = showingText;
    }

    // Fungsi untuk menangani kasus di mana data tidak ditemukan
    function renderNoData() {
        const dataContainer = document.getElementById('pengumuman-container');
        const paginationContainer = document.getElementById('pagination-container');

        // Tampilkan pesan bahwa data tidak ditemukan
        dataContainer.innerHTML = '<p>No announcements available.</p>';

        // Reset pagination ke kondisi awal atau menyembunyikannya
        const paginationList = paginationContainer.querySelector('.pagination');
        paginationList.innerHTML = ''; // Hapus semua item pagination

        paginationContainer.querySelector('.fs-6').textContent = ''; // Hapus teks "showing"
    }

    // Fungsi untuk memformat tanggal dengan jam dan menit
    function formatTanggal(tanggal) {
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
            'Oktober', 'November', 'Desember'
        ];
        const dateObj = new Date(tanggal);
        const tanggalHari = dateObj.getUTCDate();
        const bulan = dateObj.getUTCMonth();
        const tahun = dateObj.getUTCFullYear();
        const jam = dateObj.getUTCHours().toString().padStart(2, '0'); // Format jam dengan dua digit
        const menit = dateObj.getUTCMinutes().toString().padStart(2, '0'); // Format menit dengan dua digit
        return `${tanggalHari} ${bulanIndo[bulan]} ${tahun} ${jam}:${menit}`;
    }

    // Inisialisasi data awal
    fetchData(currentPage, filterJenis);

    // Event listener untuk filter jenis
    document.getElementById('filter_jenis').addEventListener('change', function() {
        filterJenis = this.value;
        currentPage = 1; // Reset page ke 1
        fetchData(currentPage, filterJenis);
    });

    // Event listener untuk navigasi pagination
    document.addEventListener('click', function(event) {
        if (event.target.matches('.pagination a')) {
            event.preventDefault();
            const page = new URL(event.target.href).searchParams.get('page');
            if (page) {
                fetchData(page, filterJenis);
            }
        }
    });
</script>
