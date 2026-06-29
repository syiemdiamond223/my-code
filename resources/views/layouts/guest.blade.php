<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tutor Finder') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex">

    <!-- LEFT SIDE (IMAGE SECTION) -->
    <div class="hidden md:flex w-1/2 bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/login.png') }}');">

        <!-- overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 to-black/60"></div>

        <!-- text -->
        <div class="relative z-10 flex flex-col justify-center px-12 text-white">
            <h1 class="text-4xl font-bold">Tutor Finder</h1>
            <p class="mt-3 text-lg text-gray-200">
                Learn Better, Connect with Tutors, and Grow Faster. 
            </p>
        </div>
    </div>

 <!-- RIGHT SIDE (FORM AREA) -->
<div class="w-full md:w-1/2 flex items-center justify-center bg-gradient-to-br from-gray-50 via-white to-blue-50 p-8">

    <div class="w-full max-w-md">

        <div class="bg-white/95 backdrop-blur rounded-3xl shadow-2xl border border-gray-200 p-10">

            {{ $slot }}

        </div>

    </div>

</div>

</body>
</html>