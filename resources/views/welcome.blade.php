<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Finder</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-900">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="/" class="text-2xl font-bold text-blue-700">
            Tutor Finder
        </a>

        <!-- Menu -->
        <div class="flex gap-8 items-center">

            <a href="#features" class="text-gray-700 hover:text-blue-600 transition">
                Features
            </a>

            <a href="#about" class="text-gray-700 hover:text-blue-600 transition">
                About
            </a>

            @auth
                @if(auth()->user()->role === 'student')
                    <a href="{{ route('student.dashboard') }}"
                       class="text-gray-700 hover:text-blue-600 transition">
                        Dashboard
                    </a>
                @elseif(auth()->user()->role === 'tutor')
                    <a href="{{ route('tutor.dashboard') }}"
                       class="text-gray-700 hover:text-blue-600 transition">
                        Dashboard
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-gray-700 hover:text-red-500 transition">
                        Logout
                    </button>
                </form>
            @endauth

        </div>

    </div>

</nav>


<!-- HERO SECTION -->
<section class="pt-28 min-h-screen bg-gradient-to-br from-blue-50 via-white to-gray-100">

    <div class="max-w-7xl mx-auto px-8">

        <div class="grid md:grid-cols-2 gap-14 items-center min-h-[85vh]">

            <!-- LEFT CONTENT -->
            <div data-aos="fade-right">

                <p class="text-blue-600 font-semibold mb-4">
                    Learn Better. Achieve More.
                </p>

                <h1 class="text-5xl md:text-6xl font-bold leading-tight text-gray-900">
                    Find The Right Tutor <br>
                    For Your Academic Success
                </h1>

                <p class="text-gray-600 text-lg mt-6 leading-relaxed">
                    Connect with expert tutors for personalized learning,
                    book sessions easily, and improve your skills anytime.
                </p>

                <!-- Buttons -->
                <div class="mt-8 flex gap-4">

                    @guest

                        <a href="{{ route('register') }}"
                           class="bg-blue-600 text-white px-7 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                            Get Started
                        </a>

                        <a href="{{ route('login') }}"
                           class="border border-gray-300 px-7 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                            Login
                        </a>

                    @endguest

                    @auth

                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}"
                               class="bg-blue-600 text-white px-7 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'tutor')
                            <a href="{{ route('tutor.dashboard') }}"
                               class="bg-blue-600 text-white px-7 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                                Dashboard
                            </a>
                        @endif

                    @endauth

                </div>

            </div>

            <!-- RIGHT IMAGE -->
            <div data-aos="fade-left" data-aos-delay="200">
                <img src="{{ asset('images/main.jpeg') }}"
                     alt="Tutor Finder"
                     class="w-full rounded-3xl shadow-2xl object-cover">
            </div>

        </div>

    </div>

</section>


<!-- FEATURES -->
<section id="features" class="py-20 bg-white">

    <div class="max-w-6xl mx-auto px-8">

        <div class="text-center mb-14" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900">
                Key Features with Tutor Finder
            </h2>

            <p class="text-gray-600 mt-4">
                Easy tutor search and booking
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            <!-- Card 1 -->
            <div class="p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition"
                 data-aos="zoom-in" data-aos-delay="100">

                <div class="text-4xl mb-4">🎓</div>

                <h3 class="text-xl font-semibold mb-3">
                    Qualified Tutors
                </h3>

                <p class="text-gray-600">
                    Find experienced and trusted tutors for every subject.
                </p>

            </div>

            <!-- Card 2 -->
            <div class="p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition"
                 data-aos="zoom-in" data-aos-delay="200">

                <div class="text-4xl mb-4">📅</div>

                <h3 class="text-xl font-semibold mb-3">
                    Easy Booking
                </h3>

                <p class="text-gray-600">
                    Book classes quickly and manage schedules easily.
                </p>

            </div>

            <!-- Card 3 -->
            <div class="p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition"
                 data-aos="zoom-in" data-aos-delay="300">

                <div class="text-4xl mb-4">💻</div>

                <h3 class="text-xl font-semibold mb-3">
                    Flexible Learning
                </h3>

                <p class="text-gray-600">
                    Choose online or offline sessions based on your needs.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ABOUT -->
<section id="about" class="py-20 bg-gray-50">

    <div class="max-w-6xl mx-auto px-8">

        <div class="grid md:grid-cols-2 gap-14 items-center">

            <!-- Image -->
            <div data-aos="fade-right">
                <img src="{{ asset('images/back.jpeg') }}"
                     alt="About Tutor Finder"
                     class="rounded-3xl shadow-xl">
            </div>

            <!-- Content -->
            <div data-aos="fade-left" data-aos-delay="200">

                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    About Tutor Finder
                </h2>

                <p class="text-gray-600 leading-relaxed mb-6">
                    Tutor Finder helps students connect with tutors in a simple,
                    fast, and reliable way. Search tutors, compare profiles,
                    and start learning with confidence.
                </p>

                <div class="space-y-4">

                    <div class="flex items-center gap-3">
                        <span class="text-blue-600">✔</span>
                        <p>Verified Tutors</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-blue-600">✔</span>
                        <p>Secure Booking System</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-blue-600">✔</span>
                        <p>Online & Offline Classes</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- FOOTER -->
<footer class="bg-gray-900 py-8">

    <div class="max-w-6xl mx-auto px-8 text-center text-gray-400">

        <p>
            © 2026 Tutor Finder. All rights reserved.
        </p>

    </div>

</footer>


<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>

</body>
</html>