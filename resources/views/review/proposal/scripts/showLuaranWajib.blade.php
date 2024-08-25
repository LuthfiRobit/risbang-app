<script>
    // let id = '';
    $(document).ready(function() {
        jurnalPenelitian = $("#show_luaran_wajib");
        id = jurnalPenelitian.data("dr");
        const showLuaranPenelitian = document.getElementById("show_luaran_penelitian");
        const showLuaranPengabdian = document.getElementById("show_luaran_pengabdian");
        const showLuaranHaki = document.getElementById("show_luaran_haki");
        const emptyElement = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3'>" +
            "<div class='d-flex flex-stack'>" +
            "<div class='row'>" +
            "<span class='fs-12 text-gray-700'>Belum ada item.</span>" +
            "<div class='row'>" +
            "<span style='color: #a1081f; font-weight: 500;'>Dosen belum menambahkan luaran</span>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
        const existElemet = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul : " +
            "<span class='text-gray-400' id='show_luaran_judul'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Rencana Penerbitan : " +
            "<span class='text-gray-400' id='show_luaran_penerbit'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Rencana Tingkat Publikasi : " +
            "<span class='text-gray-400' id='show_luaran_publikasi'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Status : " +
            "<span class='text-gray-400' id='show_status_review'></span>" +
            "</div>";
        const existHaki = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul : " +
            "<span class='text-gray-400' id='show_luaran_judul'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Kategori : " +
            "<span class='text-gray-400' id='show_luaran_jenis_haki'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Status : " +
            "<span class='text-gray-400' id='show_status_review'></span>" +
            "</div>";
        const detail = '{{ route('proposal.pengajuan.luaran.wajib', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data !== null) {
                        console.log(response.data);
                        if (response.jurnal_penelitian !== null) {
                            showLuaranPenelitian.innerHTML = existElemet;
                            const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                            const judulJurnal = showLuaranPenelitian.querySelector(
                                "#show_luaran_judul");
                            const penerbitJurnal = showLuaranPenelitian.querySelector(
                                "#show_luaran_penerbit");
                            const publikasiJurnal = showLuaranPenelitian.querySelector(
                                "#show_luaran_publikasi");
                            const statusJurnal = showLuaranPenelitian.querySelector(
                                "#show_status_review");
                            titleJenisJurnal.textContent = "Jurnal Penelitian";
                            judulJurnal.textContent = response.jurnal_penelitian.judul;
                            penerbitJurnal.textContent = response.jurnal_penelitian.penerbit;
                            publikasiJurnal.textContent = response.jurnal_penelitian.jenis_publikasi;
                            statusJurnal.textContent = response.jurnal_penelitian.status_review;
                            $("#btn_review_luaran_penelitian").attr('data-id', response
                                .jurnal_penelitian.id_proposal_luaran);
                            $("#btn_review_luaran_penelitian").attr('data-dsn', response
                                .jurnal_penelitian.dosen_id);
                            if (response.jurnal_penelitian.status_review == 'Diterima') {
                                $("#btn_review_luaran_penelitian").remove();
                            }
                        } else {
                            showLuaranPenelitian.innerHTML = emptyElement;
                            const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                            titleJenisJurnal.textContent = "Jurnal Penelitian";
                            $("#btn_review_luaran_penelitian").remove();
                        }

                        if (response.jurnal_pengabdian !== null) {
                            showLuaranPengabdian.innerHTML = existElemet;
                            const titleJenisJurnal = showLuaranPengabdian.querySelector("#jenis_luaran");
                            const judulJurnal = showLuaranPengabdian.querySelector(
                                "#show_luaran_judul");
                            const penerbitJurnal = showLuaranPengabdian.querySelector(
                                "#show_luaran_penerbit");
                            const publikasiJurnal = showLuaranPengabdian.querySelector(
                                "#show_luaran_publikasi");
                            const statusJurnal = showLuaranPengabdian.querySelector(
                                "#show_status_review");
                            titleJenisJurnal.textContent = "Jurnal Pengabdian";
                            judulJurnal.textContent = response.jurnal_pengabdian.judul;
                            penerbitJurnal.textContent = response.jurnal_pengabdian.penerbit;
                            publikasiJurnal.textContent = response.jurnal_pengabdian.jenis_publikasi;
                            statusJurnal.textContent = response.jurnal_pengabdian.status_review;
                            $("#btn_review_luaran_pengabdian").attr('data-id', response
                                .jurnal_pengabdian.id_proposal_luaran);
                            $("#btn_review_luaran_pengabdian").attr('data-dsn', response
                                .jurnal_pengabdian.dosen_id);
                            if (response.jurnal_pengabdian.status_review == 'Diterima') {
                                $("#btn_review_luaran_pengabdian").remove();
                            }
                        } else {
                            showLuaranPengabdian.innerHTML = emptyElement;
                            const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                            titlePengabdian.textContent = "Jurnal Pengabdian";
                            $("#btn_review_luaran_pengabdian").remove();
                        }

                        if (response.haki !== null) {
                            showLuaranHaki.innerHTML = existHaki;
                            const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                            const judulHaki = showLuaranHaki.querySelector(
                                "#show_luaran_judul");
                            const jenisHaki = showLuaranHaki.querySelector(
                                "#show_luaran_jenis_haki");
                            const statusHaki = showLuaranHaki.querySelector(
                                "#show_status_review");
                            judulHaki.textContent = response.haki.judul;
                            jenisHaki.textContent = response.haki.jenis_haki;
                            statusHaki.textContent = response.haki.status_review;
                            titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                            $("#btn_review_luaran_haki").attr('data-id', response
                                .haki.id_proposal_luaran);
                            $("#btn_review_luaran_haki").attr('data-dsn', response
                                .haki.dosen_id);
                            if (response.haki.status_review == 'Diterima') {
                                $("#btn_review_luaran_haki").remove();
                            }
                        } else {
                            showLuaranHaki.innerHTML = emptyElement;
                            const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                            titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                            $("#btn_review_luaran_haki").remove();
                        }
                    } else {
                        showLuaranPenelitian.innerHTML = emptyElement;
                        const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                        titleJenisJurnal.textContent = "Jurnal Penelitian";
                        $("#btn_review_luaran_penelitian").remove();

                        showLuaranPengabdian.innerHTML = emptyElement;
                        const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                        titlePengabdian.textContent = "Jurnal Pengabdian";
                        $("#btn_review_luaran_pengabdian").remove();

                        showLuaranHaki.innerHTML = emptyElement;
                        const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                        titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                        $("#btn_review_luaran_haki").remove();
                    }
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan luaran wajib', 'error');
                    showLuaranPenelitian.innerHTML = emptyElement;
                    const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                    titleJenisJurnal.textContent = "Jurnal Penelitian";
                    $("#btn_review_luaran_penelitian").remove();

                    showLuaranPengabdian.innerHTML = emptyElement;
                    const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                    titlePengabdian.textContent = "Jurnal Pengabdian";
                    $("#btn_review_luaran_pengabdian").remove();

                    showLuaranHaki.innerHTML = emptyElement;
                    const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                    titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                    $("#btn_review_luaran_haki").remove();
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });

    });
</script>
