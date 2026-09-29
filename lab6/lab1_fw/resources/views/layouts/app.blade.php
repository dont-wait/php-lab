<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Lab 01')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table { border-collapse: collapse; width: 100%; }
      th, td { border: 1px solid #ddd; padding: 8px; }
      th { background: #f3f4f6; text-align: left; }
      .adult { font-weight: 600; }
    </style>
</head>
<body>
<header>
    @include('partials.header')
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <small>&copy; HUIT – Khoa CNTT</small>
</footer>
</body>
</html>
