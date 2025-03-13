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


    <script src="https://code.iconify.design/iconify-icon/2.3.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('page-scripts')
</body>

</html>
