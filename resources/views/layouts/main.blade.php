<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class=""
    style="background-image: url({{ asset('assets/images/main-bg.jpg') }}); background-size: cover; background-position: center; background-repeat: no-repeat;">

    @yield('content')
    <audio id="bg-music" loop>
        <source src="{{ asset('assets/music/bg-music.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/iconify-icon/2.3.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('page-scripts')


    <script>
        const bgMusic = document.getElementById('bg-music');
        const muteButton = document.getElementById('mute-button');
        const muteIcon = document.getElementById('mute-icon');

        // Get state from session (default true = muted)
        let isMuted = {{ session('is_muted', true) ? 'true' : 'false' }};

        // Apply muted by default
        bgMusic.muted = true;

        // User clicks mute button
        muteButton.addEventListener('click', function (e) {
            e.stopPropagation();

            if (bgMusic.paused) {
                bgMusic.play();
            }

            isMuted = !isMuted;
            bgMusic.muted = isMuted;
            // muteIcon.setAttribute('icon', isMuted ? 'solar:muted-outline' : 'solar:music-notes-outline');

            // Save to session
            fetch('{{ route('set-mute') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ muted: isMuted })
            });
        });

    </script>
</body>

</html>
