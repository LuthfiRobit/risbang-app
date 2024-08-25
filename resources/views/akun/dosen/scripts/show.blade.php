<script>
    $(document).ready(function() {
        const detail = '{{ route('akun.dosen.show') }}';
        DataManager.fetchData(detail)
            .then(function(response) {
                if (response.success) {
                    let imgProfile = "";
                    if (response.data.profile_pict !== null) {
                        imgProfile = "background-image: url({{ asset('imgs/profileUser/') }}" + "/" +
                            response.data
                            .profile_pict + ")";
                    } else if (response.data.profile_pict === '') {
                        imgProfile =
                            "background-image: url({{ asset('assets/media/avatars/profil.png') }})";
                    } else {
                        imgProfile =
                            "background-image: url({{ asset('assets/media/avatars/profil.png') }})";
                    }

                    idb = response.data.bidang_ilmu_id;
                    idk = response.data.kepakaran_id;
                    const getB = '{{ route('bidang.ilmu.list.json') }}';
                    DataManager.fetchData(getB)
                        .then(function(response) {
                            if (response.success) {
                                var data = response.data;
                                // console.log(data);
                                // $('#bidang_ilmu').empty();
                                $.each(data, function(key, item) {
                                    if (item.id_bidang_ilmu === idb) {
                                        selected = 'selected';
                                    } else {
                                        selected = '';
                                    }
                                    // console.log(selected);
                                    $('#bidang_ilmu').append($('<option></option>').attr(
                                        'value', item.id_bidang_ilmu).prop('selected',
                                        selected).text(item.nama_bidang_ilmu));
                                })
                                $('#bidang_ilmu').selectpicker('refresh').selectpicker('render');
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(function(error) {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });

                    const getK = '{{ route('kepakaran.list.json', [':id']) }}';
                    DataManager.fetchData(getK.replace(':id', idb))
                        .then(function(response) {
                            if (response.success) {
                                var data = response.data;
                                // console.log(data);
                                $.each(data, function(key, item) {
                                    let selected = item.id_kepakaran === idk ? 'selected' : '';
                                    $('#kepakaran').append($('<option></option>')
                                        .attr('value', item.id_kepakaran)
                                        .prop('selected', selected)
                                        .text(item.nama_kepakaran));
                                })
                                $('#kepakaran').selectpicker('refresh');
                            } else {
                                // Swal.fire('Oops...', 'Kesalahan server', 'error');
                            }
                        })
                        .catch(function(error) {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });

                    $("#name").val(response.data.nama_dosen);
                    $("#nik").val(response.data.nik);
                    $("#nidn").val(response.data.nidn);
                    $("#npwp").val(response.data.no_npwp);
                    $("#jafung").val(response.data.jabatan);
                    $("#status_serdos").val(response.data.status_serdos);
                    $("#pendidikan_terakhir").val(response.data.pendidikan_terakhir);
                    $("#perguruan").val(response.data.instansi_pendidikan_terakhir);
                    $("#alamat").val(response.data.alamat);
                    $("#kode_pos").val(response.data.kode_pos);

                    $("#username").val(response.data.username);
                    $("#email").val(response.data.email);
                    $("#phone_number").val(response.data.phone_number);
                    $("#avatar-show").attr('style', imgProfile);

                    /** bank */

                    $("#norek").val(response.data.rekening);
                    $("#nama_bank").val(response.data.namabank_kantorcabang);
                    $("#nama_akun").val(response.data.nama_akunbank);

                    /** research */
                    $("#link_scholar").val(response.data.link_google_scholar);
                    $("#link_sinta").val(response.data.link_sinta);
                    $("#link_scopus").val(response.data.link_scopus);
                    $("#link_orcid").val(response.data.link_orcid);
                    $("#link_publons").val(response.data.link_publons);
                    $("#link_garuda").val(response.data.link_garuda);

                    /** berkas */
                    if (response.data.file_ktp !== null) {
                        urlKtp = "{{ asset('imgs/pkt/') }}" + "/" + response.data.file_ktp;
                        let ex_ktp =
                            `<a href="${urlKtp}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File lama KTP</a>`
                        $("#exist-ktp").append(ex_ktp);
                    }
                    if (response.data.file_sk_dosen !== null) {
                        urlSk = "{{ asset('files/skDosen/') }}" + "/" + response.data.file_sk_dosen;
                        let ex_sk =
                            `<a href="${urlSk}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File lama SK</a>`;
                        $("#exist-sk").append(ex_sk);
                    }
                    if (response.data.file_npwp !== null) {
                        urlNpwp = "{{ asset('imgs/npwp/') }}" + "/" + response.data.file_npwp;
                        let ex_npwp =
                            `<a href="${urlNpwp}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File lama NPWP</a>`;
                        $("#exist-npwp").append(ex_npwp);
                    }
                    if (response.data.img_ttd !== null) {
                        urlTtd = "{{ asset('imgs/dtt/') }}" + "/" + response.data.img_ttd;
                        let ex_ttd =
                            `<a href="${urlTtd}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye"></i> File lama Tandatangan</a>`;
                        $("#exist-ttd").append(ex_ttd);
                    }


                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                } else {
                    Swal.fire('Oops...', 'Data tidak ditemukan', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server' + error, 'error');
            });
    });

    $('#bidang_ilmu').on('change', function() {
        $('#kepakaran').selectpicker('refresh');
        idb = $(this).val();
        const get = '{{ route('kepakaran.list.json', [':id']) }}';
        DataManager.fetchData(get.replace(':id', idb))
            .then(function(response) {
                if (response.success) {
                    var data = response.data;
                    // console.log(data);
                    $('#kepakaran').empty();
                    $.each(data, function(key, item) {
                        $('#kepakaran').append($('<option></option>').attr(
                            'value', item.id_kepakaran).text(item
                            .nama_kepakaran));
                    })
                    $('#kepakaran').selectpicker('refresh');
                } else {
                    // Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });
</script>
