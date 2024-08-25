<script>
    $(document).ready(function() {
        const formPenelitian = $("#fm_submit_luaran_penelitian");
        const formPengabdian = $("#fm_submit_luaran_pengabdian");
        const detailRoute = '{{ route('proposal.luaran.show', [':id']) }}';
        const assetPath = "{{ asset('files/luaranProposal/') }}";
        const textFile = '<span class="svg-icon svg-icon-4 me-1"><i class="bi bi-eye"></i></span> Lihat file';

        function getElementSuffix(jenis) {
            return jenis === 'Penelitian' ? 'pene' : 'peng';
        }

        function fetchDataAndPopulateForm(form, jenis) {
            const id = form.data("ta");
            const suffix = getElementSuffix(jenis);
            const detailUrl = detailRoute.replace(':id', id) + `?jenis=${jenis}`;

            DataManager.fetchData(detailUrl)
                .then(function(response) {
                    if (response.success) {
                        const data = response.data;
                        // const pdfUrl = `${assetPath}/${data.file_luaran}`;

                        $(`#judul_luaran_${suffix}`).val(data.judul);
                        $(`#publikasi_luaran_${suffix}`).val(data.penerbit);
                        $(`#jenis_publikasi_luaran_${suffix}`).val(data.jenis_publikasi);
                        $(`#tahun_luaran_${suffix}`).val(data.tahun_pelaksanaan);
                        $(`#volume_luaran_${suffix}`).val(data.volume);
                        $(`#nomor_luaran_${suffix}`).val(data.nomor);
                        $(`#url_luaran_${suffix}`).val(data.link);
                        $(`#issn_luaran_${suffix}`).val(data.issn);
                        $(`#jenis_publikasi_luaran_${suffix}`).selectpicker('refresh').selectpicker(
                            'render');
                        $(`#review_status_${suffix}`).text(data.status_review != null ? data.status_review :
                            'Belum Direview');
                        // $(`#view_file_luaran_${suffix}`).attr("href", pdfUrl).append(textFile);

                        // Handle file existence
                        if (data.file_luaran !== null) {
                            const urlPene = "{{ asset('files/luaranProposal/') }}" + "/" + data
                                .file_luaran;
                            let ex_file =
                                `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> Lihat File</a>`;
                            $(`#exist-file-${suffix}`).append(ex_file);
                        }
                    } else {
                        Swal.fire('Oops...', `Belum ada record luaran ${jenis}`, 'error');
                    }
                })
                .catch(function() {
                    // Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }

        fetchDataAndPopulateForm(formPenelitian, 'Penelitian');
        fetchDataAndPopulateForm(formPengabdian, 'Pengabdian');
    });
</script>
