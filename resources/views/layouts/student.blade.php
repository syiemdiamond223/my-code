<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ALPINE JS -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-slate-100 text-gray-900">

<div x-data="{ sidebarOpen: false, profileOpen: false }"
     class="flex min-h-screen">

    <!-- MOBILE BACKDROP -->
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

        <!-- LOGO -->
        <div class="px-6 py-6 border-b border-slate-700">

            <div class="flex items-center gap-4">

                <!-- AVATAR -->
                <div class="w-14 h-14 rounded-full
                            bg-blue-600
                            flex items-center justify-center
                            text-white font-bold text-2xl shadow-lg">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <!-- TEXT -->
                <div>

                    <h2 class="text-2xl font-extrabold text-white">
                        Student Panel
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

                <a href="{{ route('student.dashboard') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200

                   {{ request()->routeIs('student.dashboard')
                        ? 'bg-blue-600 text-white shadow-lg'
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

                <!-- SEARCH -->
                <a href="{{ route('student.search') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200

                   {{ request()->routeIs('student.search')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Search Tutor

                </a>

                <!-- BOOKINGS -->
                <a href="{{ route('student.bookings') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200

                   {{ request()->routeIs('student.bookings')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    My Bookings

                </a>

                <!-- REPORTS -->
                <a href="{{ route('student.reports') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200

                   {{ request()->routeIs('student.reports')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Reports

                </a>

            </div>

        </div>

        <!-- BOTTOM USER -->
        <div class="border-t border-slate-700 p-4">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full
                            bg-blue-600
                            flex items-center justify-center
                            font-bold text-white">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <div>

                    <p class="text-sm font-semibold text-white">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Student
                    </p>

                </div>

            </div>

        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col lg:ml-72">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-slate-200
                       shadow-sm px-6 lg:px-8 py-5">

            <div class="flex items-center justify-between">

                <!-- LEFT -->
                <div class="flex items-center gap-4">

                    <!-- MOBILE MENU -->
                    <button @click="sidebarOpen = true"
                            class="lg:hidden text-3xl text-slate-700">

                        ☰

                    </button>

                    <!-- TITLE -->
                    <div>

                        <h1 class="text-2xl lg:text-3xl
                                   font-bold text-slate-800">

                            @yield('page-title')

                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            @yield('page-subtitle')
                        </p>

                    </div>

                </div>

                <!-- PROFILE -->
                <div class="relative">

                    <!-- BUTTON -->
                    <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-3
                                   bg-white border border-gray-200
                                   px-4 py-2 rounded-full
                                   hover:shadow-md transition">

                        <!-- AVATAR -->
                        <div class="w-9 h-9 rounded-full
                                    bg-blue-600
                                    flex items-center justify-center
                                    text-white font-bold">

                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                        </div>

                        <!-- NAME -->
                        <span class="hidden sm:block
                                     text-sm font-medium text-gray-800">

                            {{ Auth::user()->name }}

                        </span>

                        <!-- ICON -->
                        <svg class="w-4 h-4 text-gray-500"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7" />

                        </svg>

                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="profileOpen"
                         x-transition.origin.top.right
                         @click.away="profileOpen = false"

                         class="absolute right-0 mt-3 w-48
                                bg-white border border-gray-200
                                rounded-xl shadow-xl py-2 z-50">

                        <!-- PROFILE -->
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm
                                  text-gray-700 hover:bg-gray-50">

                            Profile

                        </a>

                        <div class="border-t border-gray-100"></div>

                        <!-- LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="w-full text-left
                                           px-4 py-3 text-sm
                                           text-red-600 hover:bg-red-50">

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-4 lg:p-8 overflow-y-auto">

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>