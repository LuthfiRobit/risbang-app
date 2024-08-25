<script src="{{ asset('assets/plugins/global/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/request.js') }}"></script>
<script src="{{ asset('assets/js/filevalidator.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const formattedTime = new Intl.DateTimeFormat('id-ID', options).format(now);
        document.getElementById('real-time-clock').innerText = formattedTime;
    }

    setInterval(updateClock, 1000);
    updateClock(); // Initial call to set the clock immediately
</script>

<script>
    document.getElementById('logoutButton1').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default form submission
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutform1').submit();
            }
        });
    });

    document.getElementById('logoutButton2').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default form submission
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutform2').submit();
            }
        });
    });
</script>
