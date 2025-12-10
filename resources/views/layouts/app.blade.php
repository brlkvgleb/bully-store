<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Bully store' }}</title>

    @vite(['resources/css/admin.css', 'resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<header class="header">
    <a class="brand" href="/products">Магазин</a>

    <nav class="nav">
        <a href="/admin/products">Админ</a>
    </nav>
</header>

<div class="container">
    <div class="main-card">
        @yield('content')
    </div>
</div>
</body>
</html>
