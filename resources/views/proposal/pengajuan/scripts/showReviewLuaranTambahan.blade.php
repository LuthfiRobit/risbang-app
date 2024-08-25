<script>
    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example_review_luaran_buku').DataTable({
            stateSave: true,
            stateDuration: -1,
            lengthmenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'noVis'
            }],
            language: {
                processing: '<p >Please wait...</p>'
            },
            processing: true,
            serverSide: true,
            // responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            scrollX: true, // Add this line for horizontal scrolling
            ajax: {
                url: '{{ route('review.proposal.show.review.luaran.tambahan', Route::current()->parameter('id')) }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                    data: "judul",
                    name: "judul"
                },
                {
                    data: "komen",
                    name: "komen"
                },
                {
                    data: "status_review",
                    name: "status_review"
                },
            ],
        });


        const performOptimizedSearch = _.debounce(function(query) {
            try {
                if (query.length >= 4 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error("Error during search:", error);
            }
        }, 500);

        $('#example_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });
    });
</script>
