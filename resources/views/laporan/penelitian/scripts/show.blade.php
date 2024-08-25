<script>
    function loadDosenOptions(selectElement, url, selectedValue) {
        DataManager.fetchData(url)
            .then(function(response) {
                // console.log(response);
                if (response.success) {
                    // $(selectElement).find('option')
                    //     .remove(); // Kosongkan select element sebelum menambahkan opsi baru
                    response.data.forEach(function(dosen) {
                        const isSelected = dosen.id == selectedValue ? 'selected' : '';
                        $(selectElement).append(new Option(dosen.show, dosen.id, false, isSelected));
                    });
                    $(selectElement).selectpicker('refresh');
                    $(selectElement).selectpicker('val', selectedValue);
                } else {
                    Swal.fire('Oops...', 'Gagal memuat data dosen', 'error');
                }
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            })
    }

    $(document).ready(function() {
        const id = '{{ Route::current()->parameter('id') }}';
        const urlShow = '{{ route('laporan.penelitian.show', [':id']) }}';

        // Fetch owner options first
        fetchOwnerOptions().then(function() {
            // Fetch and populate the form data
            fetchDataAndPopulateForm(id);
        });

        function fetchOwnerOptions() {
            return new Promise(function(resolve, reject) {
                @if (Auth::user()->user_role == 'admin' || (Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi'))
                    const ownerUrl =
                        '{{ route('global.dosen.has.proposal.pene') }}'; // Adjust the route name accordingly
                    fetch(ownerUrl)
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                let data = response.data;
                                $.each(data, function(key, item) {
                                    $("#id_owner").append($("<option></option>")
                                        .attr("value", item.id)
                                        .text(item.show));
                                });
                                $("#id_owner").selectpicker("refresh");
                                resolve();
                            } else {
                                Swal.fire('Oops...', 'Kesalahan server', 'error');
                                reject('Kesalahan server');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                            reject(error);
                        });
                @else
                    resolve();
                @endif
            });
        }

        function fetchDataAndPopulateForm(id) {
            const urlShowReplaced = urlShow.replace(':id', id);
            DataManager.fetchData(urlShowReplaced)
                .then(function(response) {
                    if (response.success) {
                        // Handle file existence
                        if (response.data.file_arsip !== null) {
                            const urlPene = "{{ asset('files/arsip/') }}" + "/" + response.data.file_arsip;
                            let ex_file =
                                `<a href="${urlPene}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> Lihat File</a>`;
                            $("#exist-file").append(ex_file);
                        }

                        // Handle publish checkbox
                        if (response.data.publish === 'y') {
                            $("#publish").prop('checked', true);
                        }

                        // Populate form fields
                        $("#ta").val(response.data.tahun_akademik_id);
                        $("#judul").val(response.data.judul);
                        $("#sumber").val(response.data.sumber_dana);
                        $("#jumlah").val(response.data.jumlah_dana);
                        $("#tahun").val(response.data.tahun_pelaksanaan);
                        $("#abstrak").val(response.data.abstrak);
                        $("#id_owner").val(response.data.dosen_id).selectpicker('refresh').selectpicker(
                            'render');

                        // Mengisi tabel penulis dalam, luar, dan lain
                        populateTable('#table_dosen_dalam', 'dosen_dalam', response.data.penulis_dalam);
                        populateTable('#table_dosen_luar', 'dosen_luar', response.data.penulis_luar);
                        populateTable('#table_dosen_lain', 'dosen_lain', response.data.penulis_lain);

                    } else {
                        console.log(response);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    });


    function populateTable(tableId, selectName, data) {
        var table = $(tableId);
        table.find('tbody').empty(); // Kosongkan tabel
        // console.log(data);
        data.forEach(function(item, index) {
            var row = `
            <tr class="text-start fs-7 gs-0">
                <td class="min-w-25px">
                    <button type="button" class="btn btn-icon btn-bg-danger btn-active-text-warning btn-sm m-1 delete-row-exist"
                        data-id="${item.id_penulis}" data-selectname="${selectName}">
                        <span class="bi bi-x-circle"></span>
                    </button>
                </td>
                <td class="min-w-100px">
                    <input type="hidden" name="id_penulis_${selectName}[]" value="${item.id_penulis}">
                    <div style="overflow:hidden;">
                        <select class="selectpicker form-control form-control-sm form-select-sm penulis_${selectName}"
                            name="penulis_${selectName}[]" data-live-search="true"
                            data-live-search="true" data-container="body" data-size="3"
                            title="Pilih Penulis" required>
                        </select>
                    </div>
                </td>
                <td class="min-w-100px">
                    <select class="selectpicker form-control form-control-sm form-select-sm status-select"
                        name="peran_${selectName}[]" id="peran_${selectName}[]" data-live-search="true"
                        title="Pilih Peran" required>
                    <option value="Ketua" ${item.peran_umum == 'Ketua' ? 'selected' : ''}>Ketua</option>
                    <option value="Anggota" ${item.peran_umum == 'Anggota' ? 'selected' : ''}>Anggota</option>
                    </select>
                </td>
                <td class="min-w-100px">
                    <label
                        class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input class="correspondent" type="checkbox" name="aktif_${selectName}[]" value="1" ${item.koresponden == 1 ? 'checked' : ''}/>
                        <span></span>
                    </label>
                </td>
            </tr>`;
            table.find('tbody').append(row);

            // // Load options for select picker

            let selectPicker = table.find(`select[name="penulis_${selectName}[]"]:last`);
            if (selectName === 'dosen_dalam') {
                loadDosenOptions(selectPicker,
                    '{{ route('dosen.list.public') }}', item.dosen_id);
            } else if (selectName === 'dosen_luar') {
                loadDosenOptions(selectPicker,
                    '{{ route('dosen.luar.list.public') }}', item.dosen_id);
            } else if (selectName === 'dosen_lain') {
                loadDosenOptions(selectPicker,
                    '{{ route('dosen.lain.list.public') }}', item.dosen_id);
            }
        });
        $('.selectpicker').selectpicker('refresh');
    }

    // Event listener for delete button
    $(document).on('click', '.delete-row-exist', function() {
        const idPenulis = $(this).data('id');
        const selectName = $(this).data('selectname');
        let deleteUrl = '';

        if (selectName === 'dosen_dalam') {
            deleteUrl = '{{ route('laporan.penulis.dalam.destroy', ':id') }}';
        } else if (selectName === 'dosen_luar') {
            deleteUrl = '{{ route('laporan.penulis.luar.destroy', ':id') }}';
        } else if (selectName === 'dosen_lain') {
            deleteUrl = '{{ route('laporan.penulis.lain.destroy', ':id') }}';
        }

        deleteUrl = deleteUrl.replace(':id', idPenulis);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Silakan tunggu',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading()
                    }
                });
                DataManager.deleteData(deleteUrl).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data berhasil dihapus", 'success');
                            // setTimeout(function() {
                            //     location.reload();
                            // }, 2000);
                            $(this).closest('tr').remove();
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });

            }
        });
    });
</script>
