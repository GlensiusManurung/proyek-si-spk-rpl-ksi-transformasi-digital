<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

{{-- GLOBAL CSS --}}
@vite([
'resources/css/global.css',
'resources/css/navbar.css',
'resources/css/footer.css',
'resources/js/navbar.js',
'resources/js/footer.js'
])

{{-- CSS KHUSUS HALAMAN --}}
@yield('vite')

</head>

<body>

@include('partials.navbar')

<main>
    @yield('content')
</main>

@include('partials.footer')

</body>
</html>