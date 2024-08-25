<script>
    $(document).ready(function() {
        function getIdFromUrl() {
            const path = window.location.pathname;
            const segments = path.split('/');
            return segments[segments.length - 1];
        }

        const id = getIdFromUrl();

        const apiUrlDetail = `{{ route('cms.berita.show', ['id' => '__ID__']) }}`.replace('__ID__', id);

        // Fungsi untuk mengatur konten CKEditor setelah inisialisasi
        function setEditorData(data) {
            if (window.editorInstance) {
                window.editorInstance.setData(data);
            } else {
                console.error('CKEditor instance is not available.');
            }
        }

        DataManager.fetchData(apiUrlDetail)
            .then(function(response) {
                if (response.success) {
                    console.log(response);
                    const data = response.data;

                    // Handle file existence
                    if (data.img_berita !== null) {
                        const urlImg = "{{ asset('imgs/berita/') }}" + "/" + data
                            .img_berita;
                        let ex_file =
                            `<a href="${urlImg}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> Lihat File</a>`;
                        $("#exist-file").append(ex_file);
                    }
                    if (data.publish === 'y') {
                        $("#publish").prop('checked', true);
                    }

                    $("#judul").val(data.judul);
                    // Tunggu sampai CKEditor diinisialisasi dan baru set datanya
                    const checkEditorInterval = setInterval(function() {
                        if (window.editorInstance) {
                            clearInterval(checkEditorInterval);
                            setEditorData(data.deskripsi);
                        }
                    }, 100); // Cek setiap 100ms
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
