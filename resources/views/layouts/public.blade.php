<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Official Geofence Attendance Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        saffron: '#FF9933',
                        navy: '#000080',
                        green: '#138808',
                        lightbg: '#F4F6F9'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        marquee: 'marquee 25s linear infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-50%)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .flag-strip {
            height: 6px;
            background: linear-gradient(to right, #FF9933 33.33%, #ffffff 33.33%, #ffffff 66.66%, #138808 66.66%);
        }
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 128, 0.85), rgba(0, 0, 128, 0.95)), url('https://images.unsplash.com/photo-1532375810709-75b1d3119b4b?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-lightbg text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Top Flag Strip -->
    <div class="flag-strip w-full"></div>

    <!-- Official Header -->
    <header class="bg-white shadow-md relative z-50">
        <div class="container mx-auto px-4 py-3 flex flex-wrap justify-between items-center">
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 mb-4 sm:mb-0 text-center sm:text-left w-full sm:w-auto">
                <a href="{{ url('/') }}">
                    <img src="/logo.png" alt="Emblem" class="h-16 sm:h-20 md:h-24 w-auto mb-2 sm:mb-0">
                </a>
                <div class="sm:border-l-2 sm:border-gray-300 sm:pl-4">
                    <h1 class="text-xl md:text-3xl font-bold text-navy uppercase tracking-wide"><a href="{{ url('/') }}">Geofence Attendance Portal</a></h1>
                    <p class="text-sm md:text-base text-gray-600 font-medium mt-1 sm:mt-0">Centralized Workforce Management</p>
                </div>
            </div>
            
            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ url('/about') }}" class="text-navy hover:text-saffron font-semibold transition">About</a>
                <a href="{{ url('/industries') }}" class="text-navy hover:text-saffron font-semibold transition">Industries</a>
                <a href="{{ url('/#features') }}" class="text-navy hover:text-saffron font-semibold transition">Features</a>
                <a href="{{ url('/pricing') }}" class="text-navy hover:text-saffron font-semibold transition">Pricing</a>
                
                <!-- Account Dropdown like MilesWeb -->
                <div class="relative group">
                    <button class="text-navy hover:text-saffron font-semibold transition flex items-center bg-gray-100 px-4 py-2 rounded-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        My Account
                        <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-2 z-50 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-300 border border-gray-100 origin-top">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-saffron font-medium">Login</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-saffron font-medium">Create Account</a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div class="w-full lg:hidden flex justify-center mt-2 space-x-4">
                <a href="{{ url('/about') }}" class="text-navy font-semibold">About</a>
                <a href="{{ url('/industries') }}" class="text-navy font-semibold">Industries</a>
                <a href="{{ route('login') }}" class="text-navy font-semibold">Login</a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-navy text-white pt-12 pb-6 border-t-4 border-saffron mt-auto relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 22H22L12 2Z"></path>
            </svg>
        </div>
        <div class="container mx-auto px-4 max-w-6xl relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">
                <div class="flex flex-col sm:flex-row items-center sm:space-x-4 bg-blue-900/40 p-5 rounded-lg border border-blue-800 text-center sm:text-left w-full md:w-auto">
                    <div class="bg-white p-2 rounded-md mb-3 sm:mb-0">
                        <img src="/logo.png" alt="Emblem" class="h-16 sm:h-20 w-auto">
                    </div>
                    <div>
                        <p class="font-bold text-xl md:text-2xl">Geofence Attendance Portal</p>
                        <p class="text-sm md:text-base text-saffron font-medium mt-1 sm:mt-0">Digital Compliance Initiative</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:flex sm:space-x-8 text-sm text-gray-300 gap-y-4">
                    <a href="{{ url('/terms') }}" class="hover:text-white hover:underline transition">Terms & Conditions</a>
                    <a href="{{ url('/privacy-policy') }}" class="hover:text-white hover:underline transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white hover:underline transition">Copyright Policy</a>
                    <a href="#" class="hover:text-white hover:underline transition">Disclaimer</a>
                </div>
            </div>
            
            <div class="text-center text-xs text-gray-400 border-t border-blue-900 pt-8 max-w-4xl mx-auto">
                <p>Content owned, maintained and updated by the Administration Department. All queries/comments regarding the content on this site may be sent to the Web Information Manager.</p>
                <p class="mt-3 font-semibold text-gray-300">&copy; {{ date('Y') }} All Rights Reserved. Designed & Developed for Digital Compliance.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
