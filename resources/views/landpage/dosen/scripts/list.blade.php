<script>
    const apiUrl = '{{ route('landpage.dosen.list') }}'; // URL endpoint API Anda
    let currentPage = 1; // Halaman saat ini
    const itemsPerPage = 8; // Jumlah item per halaman

    // Variabel filter
    let jafung = '';
    let filterFakultas = '';
    let filterProdi = '';

    // Fungsi untuk mengambil data dari API
    async function fetchData(page = 1) {
        try {
            // Buat query string dengan filter
            const query = new URLSearchParams({
                page,
                jafung,
                filter_fakultas: filterFakultas,
                filter_prodi: filterProdi
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
        const dataContainer = document.getElementById('data-container');
        dataContainer.innerHTML = items.map(item => {
            let imgProfile = '';
            if (item.profile_pict !== null && item.profile_pict !== '') {
                imgProfile = "{{ asset('imgs/profileUser/') }}" + "/" + item.profile_pict;
            } else {
                imgProfile = "{{ asset('assets/media/avatars/profil.png') }}";
            }
            return `
            <div class="col-xxl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="card card-bordered">
                    <div class="card-body d-flex flex-center flex-column pt-3 pb-3">
                        <div class="symbol symbol-75px symbol-circle mb-5">
                            <img src="${imgProfile}" alt="image" />
                        </div>
                        <a href="#" class="fs-7 text-gray-800 text-hover-primary fw-bolder mb-0">${item.nama_dosen}</a>
                        <div class="fw-bold text-gray-400 mb-0 fs-8">${item.jabatan || 'lecture'}</div>
                        <span class="badge badge-light-primary">${item.nidn}</span>
                        <div class="text-gray-600">
                            <a href="mailto:${item.email}" class="text-gray-600 text-hover-primary">${item.email}</a>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 text-center">
                                <a href="${item.link_google_scholar || '#'}" target="_blank" title="Google Scholar">
                                    <i class="bi bi-google"></i>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="${item.link_scopus || '#'}" target="_blank" title="Scopus">
                                    <i class="bi bi-book"></i>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="${item.link_sinta || '#'}" target="_blank" title="SINTA">
                                    <i class="bi bi-person-lines-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
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
                fetchData(pagination.prev_page_url.split('page=')[1]);
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
                fetchData(link.url.split('page=')[1]);
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
                fetchData(pagination.next_page_url.split('page=')[1]);
            }
        });
        paginationList.appendChild(nextButton);

        // Teks "Showing X to Y of Z entries"
        const showingText = `Showing ${pagination.from} to ${pagination.to} of ${pagination.total} entries`;
        paginationContainer.querySelector('.fs-6').textContent = showingText;
    }

    // Fungsi untuk menangani kasus di mana data tidak ditemukan
    function renderNoData() {
        const dataContainer = document.getElementById('data-container');
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

    // Inisialisasi data awal
    fetchData(currentPage);

    // Event listener untuk filter Jabatan Fungsional (jafung)
    document.getElementById('jafung').addEventListener('change', function() {
        jafung = this.value;
        currentPage = 1; // Reset page ke 1
        fetchData(currentPage);
    });

    // Event listener untuk filter Fakultas
    document.getElementById('filter_fakultas').addEventListener('change', function() {
        filterFakultas = this.value;
        currentPage = 1; // Reset page ke 1
        fetchData(currentPage);
    });

    // Event listener untuk filter Program Studi (Prodi)
    document.getElementById('filter_prodi').addEventListener('change', function() {
        filterProdi = this.value;
        currentPage = 1; // Reset page ke 1
        fetchData(currentPage);
    });

    // Fetch data Fakultas untuk filter dropdown
    const fakultasUrl = '{{ route('global.fakultas.list.json') }}';
    fetch(fakultasUrl)
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                let data = response.data;
                $("#filter_fakultas").append($("<option></option>")
                    .attr("value", "")
                    .text("Semua"));
                $.each(data, function(key, item) {
                    $("#filter_fakultas").append($("<option></option>")
                        .attr("value", item.id_fakultas)
                        .text(item.nama_fakultas));
                });
                $("#filter_fakultas").selectpicker("refresh");
            } else {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Oops...', 'Kesalahan server', 'error');
        });

    // Event listener untuk mengubah Prodi saat Fakultas berubah
    $('#filter_fakultas').on('change', function() {
        let fakultas = $(this).val();
        $("#filter_prodi").selectpicker('refresh');
        if (fakultas) {
            const prodiUrl = '{{ route('global.prodi.by.fakultas', [':id']) }}'.replace(':id', fakultas);
            fetch(prodiUrl)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let data = response.data;
                        $("#filter_prodi").empty();
                        $("#filter_prodi").append($("<option></option>")
                            .attr("value", "")
                            .text("Semua"));
                        $.each(data, function(key, item) {
                            $("#filter_prodi").append($("<option></option>")
                                .attr("value", item.id_prodi)
                                .text(item.nama_prodi));
                        });
                        $("#filter_prodi").selectpicker("refresh");
                    } else {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        } else {
            $("#filter_prodi").empty();
            $("#filter_prodi").selectpicker('refresh');
        }
    });
</script>
