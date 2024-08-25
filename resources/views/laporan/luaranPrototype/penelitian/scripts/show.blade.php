<script>
    $(document).ready(function() {
        const id = '{{ Route::current()->parameter('id') }}';
        const urlShow = '{{ route('laporan.penelitian.luaran.prototype.show', [':id']) }}';

        // Fetch owner options and then populate form data
        fetchOwnerOptions()
            .then(() => fetchDataAndPopulateForm(id))
            .catch(error => console.error(error));

        function fetchOwnerOptions() {
            return new Promise((resolve, reject) => {
                const ownerUrl = '{{ route('global.arsip.pene.list.json') }}';
                fetch(ownerUrl)
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            populateOwnerOptions(response.data);
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
            });
        }

        function populateOwnerOptions(data) {
            data.forEach(item => {
                const optionElement = $("<option></option>")
                    .attr("value", item.id)
                    .text(`${item.penulis} | ${item.judul}`)
                    .attr({
                        "data-dosen": item.id_dosen,
                        "data-arsip": item.id_arsip
                    });

                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')

                    let optgroup = $(`#group-${item.nidn}`);
                    if (optgroup.length === 0) {
                        optgroup = $("<optgroup></optgroup>")
                            .attr("label", item.penulis)
                            .attr("id", `group-${item.nidn}`);
                        $("#arsip").append(optgroup);
                    }
                    optgroup.append(optionElement);
                @else
                    $("#arsip").append(optionElement);
                @endif
            });
            $("#arsip").selectpicker("refresh");
        }

        // function shouldGroupByNidn(nidn) {
        //     return
        //     @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
        //         true;
        //     @else
        //         false;
        //     @endif ;
        // }

        function fetchDataAndPopulateForm(id) {
            const urlShowReplaced = urlShow.replace(':id', id);
            DataManager.fetchData(urlShowReplaced)
                .then(response => {
                    if (response.success) {
                        handleFileAndCoverExistence(response.data);
                        populateFormFields(response.data);
                        fetchAndPopulatePenulis(response.data.id_arsip_cript);
                    } else {
                        console.log(response);
                    }
                })
                .catch(error => console.error(error));
        }

        function handleFileAndCoverExistence(data) {
            if (data.file_arsip_prototype) {
                appendLinkToElement("#exist-file", "files/arsipPrototype/", data.file_arsip_prototype,
                    "Lihat File");
            }
            if (data.cover_arsip_prototype) {
                appendLinkToElement("#exist-cover", "imgs/arsipPrototype/", data.cover_arsip_prototype,
                    "Lihat Cover");
            }
            if (data.publish === 'y') {
                $("#publish").prop('checked', true);
            }
        }

        function appendLinkToElement(selector, path, fileName, linkText) {
            const url = `{{ asset('${path}') }}/${fileName}`;
            const link =
                `<a href="${url}" target="_blank" class="d-flex align-items-center text-primary text-hover-success"><i class="bi bi-eye me-2"></i> ${linkText}</a>`;
            $(selector).append(link);
        }

        function populateFormFields(data) {
            $("#ta").val(data.tahun_akademik_id).selectpicker('refresh').selectpicker('render');
            $("#judul").val(data.judul);
            $("#tkt").val(data.tkt).selectpicker('refresh').selectpicker('render');
            $("#level").val(data.level).selectpicker('refresh').selectpicker('render');
            $("#tahun").val(data.tahun_pelaksanaan);
            $("#deskripsi").val(data.deskripsi);
            $("#arsip").val(data.arsip_id).selectpicker('refresh').selectpicker('render');
        }

        function fetchAndPopulatePenulis(arsipId) {
            const urlShowPenulis = '{{ route('global.penulis.by.arsip', [':id']) }}'.replace(':id', arsipId);
            DataManager.fetchData(urlShowPenulis)
                .then(response => {
                    if (response.success) {
                        populateTableChange('#table_dosen_dalam', 'dosen_dalam', response.data
                            .penulis_dalam);
                        populateTableChange('#table_dosen_luar', 'dosen_luar', response.data.penulis_luar);
                        populateTableChange('#table_dosen_lain', 'dosen_lain', response.data.penulis_lain);
                    } else {
                        clearTables();
                    }
                })
                .catch(() => clearTables());
        }

        function populateTableChange(tableId, selectName, data) {
            const table = $(tableId);
            table.find('tbody').empty();
            data.forEach(item => {
                const row = `
                    <tr class="text-start fs-7 gs-0">
                        <td class="min-w-100px">${item.nama}</td>
                        <td class="min-w-100px">${item.peran_umum}</td>
                        <td class="min-w-100px">${item.peran_umum}</td>
                        <td class="min-w-100px">
                            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                <input class="correspondent" type="checkbox" disabled name="aktif_${selectName}[]" value="1" ${item.koresponden == 1 ? 'checked' : ''}/>
                                <span>Author</span>
                            </label>
                        </td>
                    </tr>`;
                table.find('tbody').append(row);
            });
            $('.selectpicker').selectpicker('refresh');
        }

        function clearTables() {
            $('#table_dosen_dalam, #table_dosen_luar, #table_dosen_lain').find('tbody').empty();
        }

        $('#arsip').on('change', function() {
            const arsip = $(this).find('option:selected').data('arsip');
            fetchAndPopulatePenulis(arsip);
        });
    });
</script>
