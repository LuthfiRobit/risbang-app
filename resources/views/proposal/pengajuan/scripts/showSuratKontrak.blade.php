<script>
    async function fetchDataSuratKontrak(url, type) {
        try {
            const response = await fetch(url);
            const result = await response.json();

            if (result.success) {
                const data = result.data;
                // console.log(data);

                let exSurat = '';

                if (data.file_moa !== null) {
                    const urlPene = `{{ asset('files/suratMoa/') }}/${data.file_moa}`;
                    exSurat = `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success">
                                <i class="bi bi-eye"></i> File Surat Kontrak/Moa
                               </a>`;
                }

                const suffix = type === 'penelitian' ? 'penelitian' : 'pengabdian';

                // Safely select elements and update content using jQuery
                const $container = $(`#show_sk_${suffix}`);
                if ($container.length) {
                    $container.find(`#show_kontrak_${suffix}`).html(exSurat);

                    $container.find(`#upload_sk_${suffix}`).attr("data-proposal", data.id_cript);
                    $container.find(`#upload_sk_${suffix}`).attr("data-ta", data.tahun_akademik_id);
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

    const idm = getIdFromUrl();

    // Define URLs and corresponding types
    const endpointk = [{
            url: `{{ route('proposal.pengajuan.penelitian.surat.moa', ['id' => '__ID__']) }}`.replace('__ID__',
                idm),
            type: 'penelitian'
        },
        {
            url: `{{ route('proposal.pengajuan.pengabdian.surat.moa', ['id' => '__ID__']) }}`.replace('__ID__',
                idm),
            type: 'pengabdian'
        }
    ];

    // Fetch data for both endpointk
    endpointk.forEach(endpoint => {
        fetchDataSuratKontrak(endpoint.url, endpoint.type);
    });
</script>
