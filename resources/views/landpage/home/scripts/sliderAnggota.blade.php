<script>
    $(document).ready(function() {
        // URL endpoint untuk mendapatkan data anggota
        var urlAnggota = '{{ route('landpage.profil.list.anggota') }}';

        $.ajax({
            url: urlAnggota,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var items = response.data;
                    var $slider = $('#slider-anggota');

                    $slider.empty(); // Clear existing items

                    // Generate HTML for each item
                    items.forEach(function(item) {
                        let html = `<div class="text-center">
                                        <div class="octagon mx-auto mb-5 d-flex w-175px h-175px bgi-no-repeat bgi-size-contain bgi-position-center"
                                            style="background-image:url('${item.profil}')"></div>
                                        <div class="mb-0">
                                            <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-3">${item.nama}</a>
                                            <div class="text-muted fs-6 fw-semibold mt-1">${item.jabatan}</div>
                                        </div>
                                    </div>`;
                        $slider.append(html);
                    });

                    // Initialize the slider after content has been added
                    tns({
                        container: '#slider-anggota',
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
