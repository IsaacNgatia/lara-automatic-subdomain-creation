<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" class="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'ISP Kenya') }}</title>

    <link rel="icon" href="{{ asset('build/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <link href="{{ asset('build/assets/iconfonts/icons.css') }}" rel="stylesheet">

    @vite(['resources/sass/app.scss'])


    <script src="{{ asset('build/assets/authentication-main.js') }}"></script>

    @yield('styles')

</head>

@yield('error-body')

@yield('content')

@yield('scripts')


</body>

</html>
