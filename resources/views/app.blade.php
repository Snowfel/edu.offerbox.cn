<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title inertia>OfferBox 系统</title>
<head>
  @routes
  @vite('resources/js/app.js')
  @inertiaHead
</head>
<body class="antialiased bg-gray-50">
@inertia
</body>
</html>
