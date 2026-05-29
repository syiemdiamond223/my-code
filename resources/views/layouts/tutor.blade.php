<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tutor Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        <!-- HEADER -->
        <div class="px-6 py-6 border-b border-slate-700">

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-full
                            bg-blue-600
                            flex items-center justify-center
                            text-white font-bold text-2xl shadow-lg">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>

                <div>

                    <h2 class="text-2xl font-extrabold text-white">
                        Tutor Panel
                    </h2>

                    <p class="text-slate-300 text-sm mt-1">
                        Tutor Finder System
                    </p>

                </div>

            </div>

        </div>

        <!-- NAVIGATION -->
        <div class="flex-1 px-4 py-6 overflow-y-auto">

            <!-- DASHBOARD -->
            <div class="mb-8">

                <p class="text-xs uppercase tracking-[0.2em]
                          text-slate-400 font-semibold px-3 mb-3">

                    Dashboard

                </p>

                <a href="{{ route('tutor.dashboard') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('tutor.dashboard')
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

                <a href="{{ route('tutor.profile.form') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('tutor.profile.form')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    My Profile

                </a>

                <a href="{{ route('tutor.sessions') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('tutor.sessions')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    My Sessions

                </a>

                <a href="{{ route('tutor.reports') }}"
                   class="block px-4 py-3 rounded-2xl transition duration-200
                   {{ request()->routeIs('tutor.reports*')
                        ? 'bg-blue-600 text-white shadow-lg'
                        : 'text-slate-200 hover:bg-slate-700 hover:text-white' }}">

                    Reports

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

                    <div>

                        <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">
                            @yield('page-title')
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            @yield('page-subtitle')
                        </p>

                    </div>

                </div>

                <!-- PROFILE -->
                <div class="relative">

                    <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-3
                                   bg-white border border-gray-200
                                   px-4 py-2 rounded-full
                                   hover:shadow-md transition">

                        <div class="w-9 h-9 rounded-full
                                    bg-blue-600
                                    text-white flex items-center
                                    justify-center font-bold">

                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                        </div>

                        <span class="hidden sm:block text-sm font-medium text-gray-800">

                            {{ Auth::user()->name }}

                        </span>

                    </button>

                    <!-- DROPDOWN -->
                    <div x-show="profileOpen"
                         x-transition.origin.top.right
                         @click.away="profileOpen = false"
                         class="absolute right-0 mt-3 w-48
                                bg-white border border-gray-200
                                rounded-xl shadow-xl py-2 z-50">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm
                                  text-gray-700 hover:bg-gray-50">

                            Profile

                        </a>

                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="w-full text-left px-4 py-3
                                           text-sm text-red-600
                                           hover:bg-red-50">

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8">

            {{-- SUCCESS MESSAGE --}}
            @if(session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">

                    <ul class="list-disc list-inside space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>