<script>
    // Validate correspondent checkbox on form submit
    $('#form_create').on("submit", function(e) {

        e.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Apakah data anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const action = "{{ route('laporan.pengabdian.luaran.prototype.store') }}";
                const formData = new FormData();

                @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')
                    const publishStatus = $("#publish").is(":checked") ? 'y' : 't';
                    formData.append("publish", publishStatus);
                @endif

                formData.append("arsip", $("#arsip").val());
                formData.append("dosen", $("#arsip").find('option:selected').data('dosen'));
                formData.append("judul", $("#judul").val());
                formData.append("tkt", $("#tkt").val());
                formData.append("level", $("#level").val());
                formData.append("ta", $("#ta").val());
                formData.append("tahun", $("#tahun").val());
                formData.append("deskripsi", $("#deskripsi").val());

                formData.append("file", $("#file")[0].files[0]);
                if ($("#file")[0].files.length > 0) {
                    formData.append("file", $("#file")[0].files[0]);
                }

                formData.append("cover", $("#cover")[0].files[0]);
                if ($("#cover")[0].files.length > 0) {
                    formData.append("cover", $("#cover")[0].files[0]);
                }

                DataManager.formData(action, formData, 'POST').then(response => {
                    if (response.success) {
                        Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                        setTimeout(function() {
                            // location.reload();
                            window.location.href =
                                "{{ route('laporan.pengabdian.luaran.prototype.index') }}";
                        }, 2000);
                    } else if (!response.success && response.errors) {
                        const validationErrorFilter = new ValidationErrorFilter();
                        validationErrorFilter.filterValidationErrors(response);
                        Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                    } else if (!response.success && !response.errors) {
                        Swal.fire('Oops...', response.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Oops...', 'Error', 'error');
                });
            }
        });
    });

    $(document).ready(function() {
        const urlJudul =
            '{{ route('global.arsip.peng.list.json') }}'; // Adjust the route name accordingly
        fetch(urlJudul)
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    let data = response.data;
                    $.each(data, function(key, item) {

                        let text = `${item.penulis} | ${item.judul}`;
                        let optionElement = $("<option></option>").attr("value", item.id_arsip)
                            .text(text);
                        @if (Auth::user()->user_role == 'admin' or Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi')

                            let optgroup = $(`#group-${item.nidn}`);

                            if (optgroup.length === 0) {
                                optgroup = $("<optgroup></optgroup>")
                                    .attr("label", item.penulis)
                                    .attr("id", `group-${item.nidn}`);
                                $("#arsip").append(optgroup);
                            }

                            optionElement.attr("data-dosen", item.id_dosen);
                            optgroup.append(optionElement);
                        @else
                            text = `${item.penulis} | ${item.judul}`;
                            optionElement.text(text);
                            optionElement.attr("data-dosen", item.id_dosen);
                            $("#arsip").append(optionElement);
                        @endif
                    });
                    $("#arsip").selectpicker("refresh");
                } else {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                }
            })
            .catch(error => {
                console.log(error);

                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });


        $('#arsip').on('change', function() {
            var arsip = $(this).val();
            // console.log($(this).find('option:selected').data('dosen'));

            const urlShow = '{{ route('global.penulis.by.arsip', [':id']) }}';

            const urlShowPenulis = urlShow.replace(':id', arsip);
            DataManager.fetchData(urlShowPenulis)
                .then(function(response) {
                    if (response.success) {
                        // Mengisi tabel penulis dalam
                        populateTable('#table_dosen_dalam', 'dosen_dalam', response.data
                            .penulis_dalam);
                        // Mengisi tabel penulis luar
                        populateTable('#table_dosen_luar', 'dosen_luar', response.data
                            .penulis_luar);
                        // Mengisi tabel penulis lain
                        populateTable('#table_dosen_lain', 'dosen_lain', response.data
                            .penulis_lain);
                    } else {
                        console.log(response);
                        $('#table_dosen_dalam').find('tbody').empty(); // Kosongkan tabel
                        $('#table_dosen_luar').find('tbody').empty(); // Kosongkan tabel
                        $('#table_dosen_lain').find('tbody').empty(); // Kosongkan tabel
                    }
                })
                .catch(function(error) {
                    // console.log(error);
                    $('#table_dosen_dalam').find('tbody').empty(); // Kosongkan tabel
                    $('#table_dosen_luar').find('tbody').empty(); // Kosongkan tabel
                    $('#table_dosen_lain').find('tbody').empty(); // Kosongkan tabel
                });
        });


        function populateTable(tableId, selectName, data) {
            var table = $(tableId);
            table.find('tbody').empty(); // Kosongkan tabel
            // console.log(data);
            data.forEach(function(item, index) {
                var row = `
                    <tr class="text-start fs-7 gs-0">
                        <td class="min-w-100px">
                        ${item.nama}
                        </td>
                        <td class="min-w-100px">
                        ${item.peran_umum}
                        </td>
                        <td class="min-w-100px">
                        ${item.peran_umum}
                        </td>
                        <td class="min-w-100px">
                            <label
                                class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                <input class="correspondent" type="checkbox" disabled name="aktif_${selectName}[]" value="1" ${item.koresponden == 1 ? 'checked' : ''}/>
                                <span>Author</span>
                            </label>
                        </td>
                    </tr>`;
                table.find('tbody').append(row);
            });
            $('.selectpicker').selectpicker('refresh');
        }

    });
</script>
