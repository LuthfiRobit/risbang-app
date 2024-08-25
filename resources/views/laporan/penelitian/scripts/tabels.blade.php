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
                    <select class="selectpicker form-control form-control-sm form-select-sm status-select"
                        name="peran_${selectName}[]" id="peran_${selectName}[]" data-live-search="true"
                        title="Pilih Peran" required>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </td>
                <td class="min-w-100px">
                    <label
                        class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input class="correspondent" type="checkbox" name="aktif_${selectName}[]" value="1"/>
                        <span></span>
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
    });
</script>
