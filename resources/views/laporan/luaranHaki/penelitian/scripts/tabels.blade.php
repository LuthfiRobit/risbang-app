<script>
    $(document).ready(function() {
        const urlDosenDalam = '{{ route('dosen.list.public') }}';
        const urlDosenLuar = '{{ route('dosen.luar.list.public') }}';
        const urlDosenLain = '{{ route('dosen.lain.list.public') }}';

        // Function to load data for select pickers
        function loadData(url, selectElement) {
            DataManager.fetchData(url)
                .then(function(response) {
                    // Clear existing options
                    selectElement.find('option').remove();
                    // Add placeholder option
                    // selectElement.append('<option value="">Select Dosen</option>');
                    // Append new options
                    $.each(response.data, function(key, value) {
                        selectElement.append('<option value="' + value.id + '">' + value.show +
                            '</option>');
                    });
                    // Refresh selectpicker
                    selectElement.selectpicker('refresh');
                })
                .catch(function(error) {
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                })
        }

        // Load data for initial row in each table
        loadData(urlDosenDalam, $('#table_dosen_dalam select[name="penulis_dosen_dalam[]"]'));
        loadData(urlDosenLuar, $('#table_dosen_luar select[name="penulis_dosen_luar[]"]'));
        loadData(urlDosenLain, $('#table_dosen_lain select[name="penulis_dosen_lain[]"]'));

        // Function to add new rows
        function addRow(tableId, selectName, url) {

            var newRow = `
            <tr class="text-start fs-7 gs-0">
                <td class="min-w-25px">
                    <button type="button"
                        class="btn btn-icon btn-bg-danger btn-active-text-warning btn-sm m-1 delete-row">
                        <span class="bi bi-x-circle"></span></button>
                </td>
                <td class="min-w-100px">
                    <div style="overflow:hidden;">
                        <select class="selectpicker form-control form-control-sm form-select-sm"
                            name="penulis_${selectName}[]" id="penulis_${selectName}[]" data-live-search="true"
                            data-container="body" data-size="3" title="Pilih Penulis" required>
                        </select>
                    </div>
                </td>
                <td class="min-w-100px">
                    <input type="text" class="form-control form-control-sm"
                        name="afiliasi_${selectName}[]" id="afiliasi_${selectName}[]"
                        placeholder="Masukkan Afiliasi" required />
                </td>
                <td class="min-w-100px">
                    <div style="overflow:hidden;">
                        <select class="selectpicker form-control form-control-sm form-select-sm status-select"
                            name="peran_${selectName}[]" id="peran_${selectName}[]" data-live-search="true"
                            data-container="body" title="Pilih Peran" required>
                            <option value="Penulis">Penulis</option>
                            <option value="Editor">Editor</option>
                            <option value="Penerjemah">Penerjemah</option>
                            <option value="Penemu">Penemu</option>
                        </select>
                    </div>
                </td>
                <td class="min-w-100px">
                    <label
                        class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input class="correspondent" type="checkbox" name="aktif_${selectName}[]" value="1"/>
                        <span>Author</span>
                    </label>
                </td>
            </tr>`;
            $(tableId + " tbody").append(newRow);
            var newSelect = $(tableId + " tbody tr:last-child select[name='penulis_" + selectName + "[]']");
            loadData(url, newSelect);
            $('.selectpicker').selectpicker('refresh');
        }

        // Event listeners for add row buttons
        $("#add-dsn-dalam").click(function() {
            addRow("#table_dosen_dalam", "dosen_dalam", urlDosenDalam);
        });

        $("#add-dsn-luar").click(function() {
            addRow("#table_dosen_luar", "dosen_luar", urlDosenLuar);
        });

        $("#add-dsn-lain").click(function() {
            addRow("#table_dosen_lain", "dosen_lain", urlDosenLain);
        });

        // Function to ensure only one correspondent checkbox is checked across all tables
        $(document).on('change', '.correspondent', function() {
            $('.correspondent').not(this).prop('checked', false);
        });

        // Function to delete row
        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            // checkPenulisStatus(); // Recheck penulis status after deleting a row
        });

        $('#kategori').on('change', function() {
            var kategori = $(this).val();
            var jenis = $('#jenis');

            // Clear current options
            jenis.empty();

            if (kategori === 'Haki') {
                var options = ['Karya Tulis', 'Karya Seni', 'Komposisi Musik',
                    'Karya Audio Visual', 'Karya Fotografi', 'Karya Drama & Koreografi',
                    'Karya Rekaman', 'Program Komputer'
                ];
            } else if (kategori === 'Merk') {
                var options = ['Merk Dagang', 'Merk Jasa', 'Merk Dagang & Jasa'];
            } else if (kategori === 'Paten') {
                var options = ['Paten Biasa', 'Paten Sederhana'];
            } else if (kategori === 'Rahasia Dagang') {
                var options = ['Metode Produksi', 'Metode Penjualan', 'Metode Pengolahan'];
            } else if (kategori === 'Desain Industri') {
                var options = ['Komponen', 'Produk Kompleks', 'Produk Sederhana'];
            } else if (kategori === 'Indikasi Geografis') {
                var options = ['Hasil Industri', 'Sumber Daya Alam', 'Barang Kerajinan Tangan'];
            } else if (kategori === 'Desain Tata Letak Sirkuit Terpadu') {
                var options = ['DTLST Satu Elemen', 'DTLST Dua Elemen', 'DTLST Tiga Elemen'];
            } else {
                var options = [];
            }

            // Append new options
            options.forEach(function(option) {
                jenis.append(new Option(option, option));
            });

            // Refresh selectpicker to apply changes
            jenis.selectpicker('refresh');
        });

        // Initialize selectpickers
        $('.selectpicker').selectpicker();
    });
</script>
