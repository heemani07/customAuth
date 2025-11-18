<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tour and Travel' }}</title>

    <link rel="icon" type="image/png"
          href="https://raw.githubusercontent.com/mustafadalga/tour-and-travel/master/assets/img/logo.svg">

    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
</head>

<body>

    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
