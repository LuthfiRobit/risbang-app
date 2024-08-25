<script>
    // let id = '';
    $(document).ready(function() {
        jurnalPenelitian = $("#show_review_luaran_wajib");
        id = jurnalPenelitian.data("id");
        const showLuaranPenelitian = document.getElementById("show_review_luaran_penelitian");
        const showLuaranPengabdian = document.getElementById("show_review_luaran_pengabdian");
        const showLuaranHaki = document.getElementById("show_review_luaran_haki");
        const emptyElement = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='notice d-flex bg-light-primary border-primary mb-3 rounded border border-dashed p-3'>" +
            "<div class='d-flex flex-stack'>" +
            "<div class='row'>" +
            "<span class='fs-12 text-gray-700'>Belum ada item.</span>" +
            "<div class='row'>" +
            "<span style='color: #a1081f; font-weight: 500;'>Silahkan tambah luaran</span>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
        const existElemet = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul : " +
            "<span class='text-gray-400' id='show_review_luaran_judul'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Komentar : " +
            "<span class='text-gray-400' id='komentar_review_luaran_jurnal'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Status Review : " +
            "<span class='text-gray-400' id='show_review_luaran_status'></span>" +
            "</div>";
        const existHaki = "<div class='fs-5' id='jenis_luaran'></div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Judul : " +
            "<span class='text-gray-400' id='show_review_luaran_judul'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Komentar : " +
            "<span class='text-gray-400' id='komentar_review_luaran_haki'></span>" +
            "</div>" +
            "<div class='fs-5 fw-bolder text-gray-800 mb-2'>Status Review : " +
            "<span class='text-gray-400' id='show_review_luaran_status'></span>" +
            "</div>";
        const luaranWajib = '{{ route('proposal.pengajuan.luaran.wajib', [':id']) }}';
        const reviewLuaranWajib = '{{ route('review.proposal.show.review.luaran', [':id']) }}';
        DataManager.fetchData(luaranWajib.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data !== null) {
                        // console.log(response.data);
                        if (response.jurnal_penelitian !== null) {
                            showLuaranPenelitian.innerHTML = existElemet;
                            const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                            const judulJurnal = showLuaranPenelitian.querySelector(
                                "#show_review_luaran_judul");
                            const komentarJurnal = showLuaranPenelitian.querySelector(
                                "#komentar_review_luaran_jurnal");
                            const statusJurnal = showLuaranPenelitian.querySelector(
                                "#show_review_luaran_status");
                            titleJenisJurnal.textContent = "Jurnal Penelitian";
                            judulJurnal.textContent = response.jurnal_penelitian.judul;
                            statusJurnal.textContent = response.jurnal_penelitian.status_review;
                            $("#show_review_luaran_penelitian").attr('data-idpl', response.jurnal_penelitian
                                .id_proposal_luaran);
                            idpl = $("#show_review_luaran_penelitian").data("idpl");
                            DataManager.fetchData(reviewLuaranWajib.replace(':id', idpl))
                                .then(function(response) {
                                    if (response.success) {
                                        komentarJurnal.textContent = response.data.komen;
                                    }
                                })
                                .catch(function(error) {});
                        } else {
                            showLuaranPenelitian.innerHTML = emptyElement;
                            const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                            titleJenisJurnal.textContent = "Jurnal Penelitian";
                        }

                        if (response.jurnal_pengabdian !== null) {
                            showLuaranPengabdian.innerHTML = existElemet;
                            const titleJenisJurnal = showLuaranPengabdian.querySelector("#jenis_luaran");
                            const judulJurnal = showLuaranPengabdian.querySelector(
                                "#show_review_luaran_judul");
                            const komentarJurnal = showLuaranPengabdian.querySelector(
                                "#komentar_review_luaran_jurnal");
                            const statusJurnal = showLuaranPengabdian.querySelector(
                                "#show_review_luaran_status");
                            titleJenisJurnal.textContent = "Jurnal Pengabdian";
                            judulJurnal.textContent = response.jurnal_pengabdian.judul;
                            statusJurnal.textContent = response.jurnal_pengabdian.status_review;
                            $("#show_review_luaran_pengabdian").attr('data-idpl', response.jurnal_pengabdian
                                .id_proposal_luaran);
                            idpl = $("#show_review_luaran_pengabdian").data("idpl");
                            DataManager.fetchData(reviewLuaranWajib.replace(':id', idpl))
                                .then(function(response) {
                                    if (response.success) {
                                        komentarJurnal.textContent = response.data.komen;
                                    }
                                })
                                .catch(function(error) {});
                        } else {
                            showLuaranPengabdian.innerHTML = emptyElement;
                            const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                            titlePengabdian.textContent = "Jurnal Pengabdian";
                        }
                        if (response.haki !== null) {
                            showLuaranHaki.innerHTML = existHaki;
                            const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                            const judulHaki = showLuaranHaki.querySelector(
                                "#show_review_luaran_judul");
                            const komentarHaki = showLuaranHaki.querySelector(
                                "#komentar_review_luaran_haki");
                            const statusHaki = showLuaranHaki.querySelector(
                                "#show_review_luaran_status");
                            titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                            judulHaki.textContent = response.haki.judul;
                            statusHaki.textContent = response.haki.status_review;
                            $("#show_review_luaran_haki").attr('data-idpl', response.haki
                                .id_proposal_luaran);
                            idpl = $("#show_review_luaran_haki").data("idpl");
                            DataManager.fetchData(reviewLuaranWajib.replace(':id', idpl))
                                .then(function(response) {
                                    if (response.success) {
                                        komentarHaki.textContent = response.data.komen;
                                    }
                                })
                                .catch(function(error) {});
                        } else {
                            showLuaranHaki.innerHTML = emptyElement;
                            const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                            titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                        }
                    } else {
                        showLuaranPenelitian.innerHTML = emptyElement;
                        const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                        titleJenisJurnal.textContent = "Jurnal Penelitian";

                        showLuaranPengabdian.innerHTML = emptyElement;
                        const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                        titlePengabdian.textContent = "Jurnal Pengabdian";

                        showLuaranHaki.innerHTML = emptyElement;
                        const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                        titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                    }
                } else {
                    Swal.fire('Oops...', 'Belum ada record pengajuan luaran wajib', 'error');
                    showLuaranPenelitian.innerHTML = emptyElement;
                    const titleJenisJurnal = showLuaranPenelitian.querySelector("#jenis_luaran");
                    titleJenisJurnal.textContent = "Jurnal Penelitian";

                    showLuaranPengabdian.innerHTML = emptyElement;
                    const titlePengabdian = showLuaranPengabdian.querySelector("#jenis_luaran");
                    titlePengabdian.textContent = "Jurnal Pengabdian";

                    showLuaranHaki.innerHTML = emptyElement;
                    const titleHaki = showLuaranHaki.querySelector("#jenis_luaran");
                    titleHaki.textContent = "Hak Kekayaan Intelektual (HKI)";
                }
            })
            .catch(function(error) {
                // Swal.fire('Oops...', 'Kesalahan server', 'error');
            });

    });
</script>
