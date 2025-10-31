<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <!-- SB Admin 2 Styles -->
    <link href="{{ asset('theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->


    <div id="wrapper">

        {{-- Sidebar --}}

         <x-sidebar/>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Main Content -->
                <div class="container-fluid py-4">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>

    <!-- SB Admin 2 Scripts -->
    <script src="{{ asset('theme/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
