<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Finder</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* Floating background blobs */
        .blob {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.35;
            z-index: 0;
            animation: float 10s infinite ease-in-out;
        }

        .blob1 {
            background: #60a5fa;
            top: -120px;
            left: -120px;
        }

        .blob2 {
            background: #a78bfa;
            top: 200px;
            right: -150px;
            animation-delay: 2s;
        }

        .blob3 {
            background: #34d399;
            bottom: -150px;
            left: 30%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }
    </style>
</head>

<body class="bg-white text-gray-900 overflow-x-hidden">

        <!-- NAVBAR -->
        <nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">

            <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">

                <a href="/" class="text-2xl font-bold text-blue-700">
                    Tutor Finder
                </a>

                <div class="flex gap-8 items-center">

                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition">Features</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 transition">About</a>

                    @auth
                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                        @elseif(auth()->user()->role === 'tutor')
                            <a href="{{ route('tutor.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="hover:text-red-500">Logout</button>
                        </form>
                    @endauth

                </div>

            </div>

        </nav>


        <!-- HERO SECTION -->
        <section class="relative pt-20 min-h-screen bg-gradient-to-br from-blue-50 via-white to-gray-100 overflow-hidden">

            <!--  Floating background blobs -->
            <div class="blob blob1"></div>
            <div class="blob blob2"></div>
            <div class="blob blob3"></div>

            <div class="max-w-7xl mx-auto px-8 relative z-10">

                <div class="grid md:grid-cols-2 gap-14 items-center min-h-[70vh]">

                    <!-- LEFT -->
                    <div data-aos="fade-right" data-aos-duration="1400">

                        <!--  NEW HERO BADGE -->
                        <div class="inline-flex items-center bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold mb-4 shadow-sm">
                            Student-Tutor Platform
                        </div>

                        <p class="text-blue-600 font-medium mb-5">
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

                    <!-- RIGHT -->
                    <div data-aos="fade-left" data-aos-duration="1600">

                        <div class="relative">
                            <div class="absolute -inset-4 bg-blue-200/40 blur-3xl rounded-3xl"></div>

                            <img src="{{ asset('images/main.jpeg') }}"
                                class="relative w-full rounded-3xl shadow-2xl object-cover">
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- FEATURES -->
        <section id="features" class="py-20 bg-white">

            <div class="max-w-6x1 mx-auto px-7">

                <div class="text-center mb-10" data-aos="fade-up">
                    <h2 class="text-4xl font-bold">Key Features</h2>
                    <p class="text-gray-600 mt-4">Everything you need for learning</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">

                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-xl transition"
                        data-aos="zoom-in" data-aos-delay="60">
                        🎓
                        <h3 class="text-xl font-semibold mt-3">Qualified Tutors</h3>
                        <p class="text-gray-600 mt-2">Expert verified tutors</p>
                    </div>

                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-xl transition"
                        data-aos="zoom-in" data-aos-delay="80">
                        📅
                        <h3 class="text-xl font-semibold mt-3">Easy Booking</h3>
                        <p class="text-gray-600 mt-2">Simple scheduling system</p>
                    </div>

                    <div class="p-8 rounded-2xl border shadow-sm hover:shadow-xl transition"
                        data-aos="zoom-in" data-aos-delay="120">
                        💻
                        <h3 class="text-xl font-semibold mt-3">Flexible Learning</h3>
                        <p class="text-gray-600 mt-2">Online & offline classes</p>
                    </div>

                </div>

            </div>

        </section>


        <!-- ABOUT -->
        <section id="about" class="py-20 bg-gray-50">

            <div class="max-w-6xl mx-auto px-8 grid md:grid-cols-2 gap-14 items-center">

                <div data-aos="fade-right">
                    <img src="{{ asset('images/back.jpg') }}"
                        class="rounded-3xl shadow-xl">
                </div>

                <div data-aos="fade-left">

                    <h2 class="text-4xl font-bold mb-6">About Tutor Finder</h2>

                    <p class="text-gray-600 mb-6">
                        Tutor Finder helps students connect with tutors quickly and easily.
                    </p>

                    <div class="space-y-3">
                        <p>✔ Verified Tutors</p>
                        <p>✔ Secure Booking</p>
                        <p>✔ Online & Offline Classes</p>
                    </div>

                </div>

            </div>

        </section>


        <!-- FOOTER -->
        <footer class="bg-gray-900 py-8">

            <div class="text-center text-gray-400">
                © 2026 Tutor Finder. All rights reserved.
            </div>

        </footer>


        <!-- AOS -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
        AOS.init({
            duration: 1300,
            easing: 'ease-in-out',
            once: true,
            offset: 120
        });
        </script>

</body>
</html>