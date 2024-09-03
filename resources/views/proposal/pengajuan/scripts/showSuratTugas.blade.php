<script>
    async function handleDownload(url) {
        try {
            // Fetch the PDF file as a blob
            const response = await fetch(url);

            if (response.ok) {
                const blob = await response.blob();
                const urlBlob = window.URL.createObjectURL(blob);

                // Retrieve filename from the response header
                const filename = response.headers.get('X-Filename') || 'SuratTugas.pdf';

                // Create a temporary link element and trigger the download
                const a = document.createElement('a');
                a.href = urlBlob;
                a.download = filename; // Use the filename from the header
                document.body.appendChild(a);
                a.click();

                // Clean up the temporary link
                document.body.removeChild(a);
                window.URL.revokeObjectURL(urlBlob);

                Swal.fire({
                    title: 'Unduhan Berhasil',
                    text: 'PDF telah diunduh.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Tutup'
                });
            } else {
                Swal.fire({
                    title: 'Unduhan Gagal',
                    text: 'Gagal mengunduh PDF, cek kembali kelengkapan surat.',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'Tutup'
                });
            }
        } catch (error) {
            Swal.fire({
                title: 'Terjadi Kesalahan',
                text: 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi nanti.',
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: 'Tutup'
            });
            console.error('Error during download:', error);
        }
    }

    async function fetchDataSurat(url, type) {
        try {
            const response = await fetch(url);
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                let exSurat = '';
                let downloadLink = '';

                if (data.file_surat !== null) {
                    const urlPene = `{{ asset('files/suratTugas/') }}/${data.file_surat}`;
                    exSurat = `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success">
                                <i class="bi bi-eye"></i> File Surat Tugas
                               </a>`;
                }

                const downloadUrl = `{{ route('surat.tugas.download', [':id']) }}`.replace(':id', data.id_cript);
                downloadLink = `<a href="javascript:void(0);" onclick="handleDownload('${downloadUrl}')" class="d-flex align-items-center text-primary text-hover-success">
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <i class="bi bi-download me-2"></i>
                                    </span> Download Surat Tugas
                                </a>`;

                const suffix = type === 'penelitian' ? 'penelitian' : 'pengabdian';

                // Safely select elements and update content using jQuery
                const $container = $(`#show_st_${suffix}`);
                if ($container.length) {
                    $container.find(`#show_st_judul_${suffix}`).text(data.judul || '---');
                    $container.find(`#show_st_tanggal_${suffix}`).text(data.tanggal || '---');
                    $container.find(`#show_st_tempat_${suffix}`).text(data.tempat || '---');
                    $container.find(`#show_surat_${suffix}`).html(exSurat);
                    $container.find(`#download_${suffix}`).html(downloadLink);

                    $container.find(`#btn_edit_st_${suffix}`).attr("data-proposal", data.id_cript);
                    $container.find(`#btn_edit_st_${suffix}`).attr("data-ta", data.tahun_akademik_id);

                    $container.find(`#upload_st_${suffix}`).attr("data-proposal", data.id_cript);
                    $container.find(`#upload_st_${suffix}`).attr("data-ta", data.tahun_akademik_id);
                } else {
                    console.error(`Container untuk ${suffix} tidak ditemukan.`);
                }
            } else {
                console.error("Gagal mendapatkan data:", result.message);
            }
        } catch (error) {
            console.error("Kesalahan saat mengambil data:", error);
        }
    }

    function getIdFromUrl() {
        return window.location.pathname.split('/').pop();
    }

    const ids = getIdFromUrl();

    // Define URLs and corresponding types
    const endpoints = [{
            url: `{{ route('proposal.pengajuan.penelitian.surat.tugas', ['id' => '__ID__']) }}`.replace('__ID__',
                ids),
            type: 'penelitian'
        },
        {
            url: `{{ route('proposal.pengajuan.pengabdian.surat.tugas', ['id' => '__ID__']) }}`.replace('__ID__',
                ids),
            type: 'pengabdian'
        }
    ];

    // Fetch data for both endpoints
    endpoints.forEach(endpoint => {
        fetchDataSurat(endpoint.url, endpoint.type);
    });
</script>
