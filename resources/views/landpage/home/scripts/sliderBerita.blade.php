<script>
    $(document).ready(function() {
        var apiUrl = '{{ route('landpage.berita.list.utama') }}';
        let urlDetail = '{{ route('landpage.berita.detail', ':slug') }}';

        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var items = response.data;
                    var $slider = $('#mySlider');

                    $slider.empty(); // Clear existing items

                    // Generate HTML for each item
                    items.forEach(function(item) {
                        let urlDetailUtama = urlDetail.replace(':slug', item.slug);
                        let html = `<div class="px-5 pt-5 pt-lg-5 px-lg-5">
                                        <div class="card shadow-sm border">
                                            <div class="d-flex align-items-center p-5 p-lg-5 mb-5">
                                                <div class="flex-shrink-0 me-5 me-lg-10">
                                                    <img src="${item.img_berita}" class="h-75px h-lg-150px" alt="${item.judul}">
                                                </div>
                                                <div class="mb-0 fs-6">
                                                    <div class="text-muted fw-bold lh-lg mb-2">
                                                        <span class="text-black fs-4">${item.judul}</span>
                                                        ${item.deskripsi}
                                                    </div>
                                                    <a href="${urlDetailUtama}" class="fw-bold link-primary">Lanjut baca</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                        $slider.append(html);
                    });

                    // Initialize the slider after content has been added
                    tns({
                        container: '#mySlider',
                        loop: $slider.data('tns-loop'),
                        swipeAngle: $slider.data('tns-swipe-angle'),
                        speed: $slider.data('tns-speed'),
                        autoplay: $slider.data('tns-autoplay'),
                        autoplayTimeout: $slider.data('tns-autoplay-timeout'),
                        controls: $slider.data('tns-controls'),
                        nav: $slider.data('tns-nav'),
                        items: $slider.data('tns-items'),
                        center: $slider.data('tns-center'),
                        dots: $slider.data('tns-dots'),
                        prevButton: $slider.data('tns-prev-button'),
                        nextButton: $slider.data('tns-next-button'),
                    });

                    // Remove stop button if present
                    $('button[data-action="stop"]').remove();
                } else {
                    console.error('Data tidak tersedia');
                }
            },
            error: function() {
                console.error('Terjadi kesalahan saat mengambil data');
            }
        });
    });
</script>
