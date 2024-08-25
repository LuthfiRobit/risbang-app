<script>
    $(document).ready(function() {
        dsn = $('#dsn_id').val();
        formPenelitian = $("#fm_submit_luaran_penelitian");
        id = formPenelitian.data("ta");
        const detail = '{{ route('proposal.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id) + '?jenis=Penelitian&dosen=' + dsn)
            .then(function(response) {
                if (response.success) {
                    var driveUrl = response.data.link;
                    var fileUrl = "{{ asset('files/luaranProposal/') }}" + "/" + response.data
                        .file_luaran;

                    // Pastikan driveUrl diawali dengan "http://" atau "https://"
                    if (!/^https?:\/\//i.test(driveUrl)) {
                        driveUrl = 'http://' + driveUrl;
                    }

                    var textDrive =
                        '<span class="svg-icon svg-icon-4 me-2"><i class="bi bi-google"></i></span> Lihat url luaran penelitian';
                    var textFile =
                        '<span class="svg-icon svg-icon-4 me-2"><i class="bi bi-eye"></i></span> Lihat file luaran penelitian';

                    $("#review_status_pene").text(response.data.status_review != null ? response.data
                        .status_review : 'Belum Direview');

                    $("#view_link_luaran_pene").attr("href", driveUrl).append(textDrive);
                    $("#view_file_luaran_pene").attr("href", fileUrl).append(textFile);
                    $("#view_judul_luaran_pene").text(response.data.judul != null ? response.data.judul :
                        'tidak ada record');
                    $("#view_publikasi_luaran_pene").text(response.data.penerbit != null ? response.data
                        .penerbit : 'tidak ada record');
                    $("#view_tingkat_luaran_pene").text(response.data.jenis_publikasi != null ? response
                        .data.jenis_publikasi : 'tidak ada record');
                    $("#view_tahun_luaran_pene").text(response.data.tahun_pelaksanaan != null ? response
                        .data.tahun_pelaksanaan : 'tidak ada record');
                    $("#view_volume_luaran_pene").text(response.data.volume != null ? response.data.volume :
                        'tidak ada record');
                    $("#view_nomor_luaran_pene").text(response.data.nomor != null ? response.data.nomor :
                        'tidak ada record');
                    $("#view_issn_luaran_pene").text(response.data.issn != null ? response.data.issn :
                        'tidak ada record');
                    formPenelitian.attr('data-kem', response.data.id_luaran_cript);
                    kemId = response.data.id_luaran_cript;
                    const detailRev = '{{ route('review.luaran.show', [':id']) }}';
                    DataManager.fetchData(detailRev.replace(':id', kemId))
                        .then(function(response) {
                            if (response.success) {
                                $("#komen_luaran_pene").val(response.data.komen);
                                $("#nilai_luaran_pene").val(response.data.nilai);
                                $("#keputusan_luaran_pene").val(response.data.status_review);
                                $('#keputusan_luaran_pene').selectpicker('refresh').selectpicker(
                                    'render');
                            } else {
                                Swal.fire('Oops...', 'Belum ada record review luaran penelitian',
                                    'error');
                            }
                        })
                        .catch(function(error) {
                            // Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    Swal.fire('Oops...', 'Belum ada record luaran penelitian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $(document).ready(function() {
        dsn = $('#dsn_id').val();
        formPengabdian = $("#fm_submit_luaran_pengabdian");
        id = formPengabdian.data("ta");
        const detail = '{{ route('proposal.luaran.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id) + '?jenis=Pengabdian&dosen=' + dsn)
            .then(function(response) {
                if (response.success) {
                    var driveUrl = response.data.link;
                    var fileUrl = "{{ asset('files/luaranProposal/') }}" + "/" + response.data
                        .file_luaran;

                    // Pastikan driveUrl diawali dengan "http://" atau "https://"
                    if (!/^https?:\/\//i.test(driveUrl)) {
                        driveUrl = 'http://' + driveUrl;
                    }

                    var textDrive =
                        '<span class="svg-icon svg-icon-4 me-2"><i class="bi bi-google"></i></span> Lihat url luaran pengabdian';
                    var textFile =
                        '<span class="svg-icon svg-icon-4 me-2"><i class="bi bi-eye"></i></span> Lihat file luaran pengabdian';

                    $("#review_status_peng").text(response.data.status_review != null ? response.data
                        .status_review : 'Belum Direview');

                    $("#view_link_luaran_peng").attr("href", driveUrl).append(textDrive);
                    $("#view_file_luaran_peng").attr("href", fileUrl).append(textFile);
                    $("#view_judul_luaran_peng").text(response.data.judul != null ? response.data.judul :
                        'tidak ada record');
                    $("#view_publikasi_luaran_peng").text(response.data.penerbit != null ? response.data
                        .penerbit : 'tidak ada record');
                    $("#view_tingkat_luaran_peng").text(response.data.jenis_publikasi != null ? response
                        .data.jenis_publikasi : 'tidak ada record');
                    $("#view_tahun_luaran_peng").text(response.data.tahun_pelaksanaan != null ? response
                        .data.tahun_pelaksanaan : 'tidak ada record');
                    $("#view_volume_luaran_peng").text(response.data.volume != null ? response.data.volume :
                        'tidak ada record');
                    $("#view_nomor_luaran_peng").text(response.data.nomor != null ? response.data.nomor :
                        'tidak ada record');
                    $("#view_issn_luaran_peng").text(response.data.issn != null ? response.data.issn :
                        'tidak ada record');
                    formPengabdian.attr('data-kem', response.data.id_luaran_cript);
                    kemId = response.data.id_luaran_cript;
                    const detailRev = '{{ route('review.luaran.show', [':id']) }}';
                    DataManager.fetchData(detailRev.replace(':id', kemId))
                        .then(function(response) {
                            if (response.success) {
                                $("#komen_luaran_peng").val(response.data.komen);
                                $("#nilai_luaran_peng").val(response.data.nilai);
                                $("#keputusan_luaran_peng").val(response.data.status_review);
                                $('#keputusan_luaran_peng').selectpicker('refresh').selectpicker(
                                    'render');
                            } else {
                                Swal.fire('Oops...', 'Belum ada record review luaran pengabdian',
                                    'error');
                            }
                        })
                        .catch(function(error) {
                            // Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                } else {
                    Swal.fire('Oops...', 'Belum ada record luaran pengabdian', 'error');
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
