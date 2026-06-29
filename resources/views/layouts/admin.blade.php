<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-slate-100 text-gray-900">

<div x-data="{ sidebarOpen: false, profileOpen: false }"
     class="flex min-h-screen">

    <!-- dropdown backdrop -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside
        class="fixed inset-y-0 left-0 z-50
               w-72 bg-gradient-to-b
               from-slate-900 via-slate-800 to-blue-950
               text-white shadow-2xl flex flex-col
               transform transition-transform duration-300
               lg:translate-x-0"

        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <!-- LOGO  -->
        <div class="px-6 py-6 border-b border-slate-700">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-full
                            bg-violet-600
                            flex items-center justify-center
                            text-white font-bold text-2xl shadow-lg">

                    <!-- Display the first letter of the admin's name in the avatar -->
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <div>

                    <h2 class="text-2xl font-extrabold text-white">
                        Admin Panel
                    </h2>

                    <p class="text-slate-300 text-sm mt-1">
                        Tutor Finder System
                    </p>

                </div>

            </div>

        </div>

        <!-- MENU -->
        <div class="flex-1 px-4 py-6 overflow-y-auto">

            <!-- DASHBOARD -->
            <div class="mb-8">

                <p class="text-xs uppercase tracking-[0.2em]
                          text-slate-400 font-semibold px-3 mb-3">

                    Dashboard

                </p>

                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('admin.dashboard')
                        ? 'bg-violet-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Dashboard

                </a>

            </div>

            <!-- MANAGEMENT -->
            <div class="space-y-2">

                <p class="text-xs uppercase tracking-[0.2em]
                          text-slate-400 font-semibold px-3 mb-3">

                    Management

                </p>

                <a href="{{ route('admin.users') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('admin.users')
                        ? 'bg-violet-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Manage Users

                </a>

                <a href="{{ route('admin.tutors') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('admin.tutors')
                        ? 'bg-violet-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Approve Tutors

                </a>

                <a href="{{ route('admin.bookings') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('admin.bookings')
                        ? 'bg-violet-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Session Overview

                </a>

                <a href="{{ route('admin.payments') }}"
                    class="block px-4 py-3 rounded-2xl transition duration-200
                    {{ request()->routeIs('admin.payments')
                            ? 'bg-violet-600 text-white shadow-lg'
                            : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                        Payment Records

                    </a>

                <a href="{{ route('admin.reports') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('admin.reports')
                        ? 'bg-violet-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Booking Records

                </a>

            </div>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col lg:ml-72">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-slate-200
                       shadow-sm px-6 lg:px-8 py-5">

            <div class="flex items-center justify-between">

                <!-- LEFT -->
                <div class="flex items-center gap-4">

                    <button @click="sidebarOpen = true"
                            class="lg:hidden text-3xl text-slate-700">

                        ☰

                    </button>

                    <div class="border-l-4 border-violet-600 pl-4">

                        <h1 class="text-3xl font-bold text-purple-800">
                            @yield('page-title')
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            @yield('page-subtitle')
                        </p>

                    </div>

                </div>

                <!-- LOGOUT -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        class="bg-rose-500 hover:bg-rose-600
                               text-white px-5 py-2.5
                               rounded-xl transition shadow">

                        Logout

                    </button>

                </form>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-4 lg:p-8 overflow-y-auto">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>