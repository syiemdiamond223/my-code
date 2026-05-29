<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tutor Finder') }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="relative min-h-screen flex items-center justify-center
             bg-gradient-to-br from-blue-100 via-white to-gray-100 overflow-hidden">

    <!-- Soft Background Glow Effects -->
    <div class="absolute w-96 h-96 bg-blue-200/40 rounded-full blur-3xl top-10 left-10"></div>
    <div class="absolute w-96 h-96 bg-gray-300/30 rounded-full blur-3xl bottom-10 right-10"></div>

    <!-- Glass Card -->
    <div class="relative w-full max-w-md px-10 py-10
                bg-white/80 backdrop-blur-xl
                border border-gray-200
                shadow-2xl
                rounded-3xl">

        {{ $slot }}

    </div>

</body>
</html>