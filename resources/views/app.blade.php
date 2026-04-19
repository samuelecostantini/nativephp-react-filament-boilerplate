<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>
<body class="h-dvh max-h-dvh overflow-hidden flex flex-col bg-slate-50 text-slate-900 selection:bg-red-100 selection:text-red-700 nativephp-safe-area">
    @inertia('totem-ariston')
</body>
</html>
