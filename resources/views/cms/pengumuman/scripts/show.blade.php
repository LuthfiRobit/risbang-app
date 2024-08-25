<script>
    $(document).ready(function() {
        function getIdFromUrl() {
            const path = window.location.pathname;
            const segments = path.split('/');
            return segments[segments.length - 1];
        }

        const id = getIdFromUrl();

        const apiUrlDetail = `{{ route('cms.pengumuman.show', ['id' => '__ID__']) }}`.replace('__ID__', id);

        DataManager.fetchData(apiUrlDetail)
            .then(function(response) {
                if (response.success) {
                    console.log(response);
                    const data = response.data;
                    // Handle file existence
                    if (data.file_pengumuman !== null) {
                        const urlImg = "{{ asset('files/pengumuman/') }}" + "/" + data
                            .file_pengumuman;
                        let ex_file =
                            `<a href="${urlImg}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> Lihat File</a>`;
                        $("#exist-file").append(ex_file);
                    }

                    if (data.publish === 'y') {
                        $("#publish").prop('checked', true);
                    }

                    $("#judul").val(data.judul);
                    $("#jenis").val(data.jenis);
                    $("#deskripsi").val(data.deskripsi);
                    $("#url").val(data.url);

                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Data tidak ditemukan', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
                console.error(error);
            });
    });
</script>
