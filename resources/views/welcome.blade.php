<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Geofence Attendance Portal</title>
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
</head>
<body class="bg-lightbg text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Top Flag Strip -->
    <div class="flag-strip w-full"></div>

    <!-- Official Header -->
    <header class="bg-white shadow-md relative z-10">
        <div class="container mx-auto px-4 py-3 flex flex-wrap justify-between items-center">
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 mb-4 sm:mb-0 text-center sm:text-left w-full sm:w-auto">
                <img src="/logo.png" alt="Emblem" class="h-20 sm:h-24 md:h-28 w-auto mb-2 sm:mb-0">
                <div class="sm:border-l-2 sm:border-gray-300 sm:pl-4">
                    <h1 class="text-xl md:text-3xl font-bold text-navy uppercase tracking-wide">Geofence Attendance Portal</h1>
                    <p class="text-sm md:text-base text-gray-600 font-medium mt-1 sm:mt-0">Centralized Workforce Management</p>
                </div>
            </div>
            <div class="hidden lg:flex space-x-6">
                <a href="#features" class="text-navy hover:text-saffron font-semibold transition">Features</a>
                <a href="#pricing" class="text-navy hover:text-saffron font-semibold transition">Pricing</a>
            </div>
            <div class="w-full sm:w-auto flex justify-center mt-4 lg:mt-0">
                <a href="{{ route('admin.login') }}" class="bg-navy text-white px-5 py-2 md:px-6 md:py-3 rounded shadow hover:bg-blue-800 transition font-semibold text-sm md:text-base inline-flex items-center w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Admin Portal Login
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-20 md:py-32 flex-grow flex items-center">
        <div class="container mx-auto px-4 text-center md:text-left">
            <div class="max-w-3xl">
                <div class="inline-block bg-white/20 px-3 py-1 rounded-full text-xs font-semibold tracking-wider mb-6 border border-white/30 backdrop-blur-sm uppercase">
                    The Ultimate Multi-Tenant SaaS Platform
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Secure & Verifiable <br>
                    <span class="text-saffron">Location-Based</span> Attendance
                </h2>
                <p class="text-lg md:text-xl mb-10 text-gray-200 max-w-2xl">
                    Define strict geofence perimeters for your organization. Allow staff to check-in only when they are physically present, and track live locations effortlessly.
                </p>
                
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#pricing" class="bg-saffron text-white px-8 py-3 rounded text-lg font-bold shadow-lg hover:bg-orange-600 transition text-center flex items-center justify-center">
                        View Subscription Plans
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Carousel -->
    <section class="bg-navy py-4 border-b-4 border-saffron overflow-hidden">
        <div class="container mx-auto px-4 flex items-center">
            <span class="text-white font-bold text-sm uppercase tracking-wider shrink-0 mr-4 z-10 bg-navy pr-4 border-r border-blue-800">Trusted Across Sectors</span>
            <div class="relative flex overflow-hidden w-full">
                <!-- Moving marquee -->
                <div class="whitespace-nowrap animate-marquee flex space-x-12 items-center text-gray-300 font-medium">
                    <span>🏢 Corporate Offices</span>
                    <span>🏗️ Construction Sites</span>
                    <span>🏥 Healthcare & Hospitals</span>
                    <span>🎓 Educational Institutes</span>
                    <span>🏭 Manufacturing Plants</span>
                    <span>🚚 Logistics & Field Sales</span>
                    <span>🏛️ Administration & Public Works</span>
                    <!-- Duplicate for infinite effect -->
                    <span class="ml-12">🏢 Corporate Offices</span>
                    <span>🏗️ Construction Sites</span>
                    <span>🏥 Healthcare & Hospitals</span>
                    <span>🎓 Educational Institutes</span>
                    <span>🏭 Manufacturing Plants</span>
                    <span>🚚 Logistics & Field Sales</span>
                    <span>🏛️ Administration & Public Works</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Capabilities / Features Section -->
    <section id="features" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-navy mb-4">Powerful Core Capabilities</h3>
                <div class="w-24 h-1.5 bg-green mx-auto rounded"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">Designed for scale, accuracy, and reliability across all organizations.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-lightbg p-8 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="bg-navy text-white w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-navy mb-3">Radius Geofencing</h4>
                    <p class="text-sm text-gray-600">Define geofence boundaries via Lat/Long + radius in meters. Check-ins are strictly denied outside this perimeter.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-lightbg p-8 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-saffron transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="bg-saffron text-white w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-navy mb-3">Smart Live Tracking</h4>
                    <p class="text-sm text-gray-600">Tracks active employees via interval-based background pings (30-60s) for high accuracy while protecting battery life.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-lightbg p-8 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-green transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="bg-green text-white w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-navy mb-3">Multi-Tenant Arch</h4>
                    <p class="text-sm text-gray-600">Each organization gets a separate, secure tenant environment for their employees, geofences, and custom settings.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-lightbg p-8 rounded-xl border border-gray-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 text-center relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="bg-navy text-white w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-navy mb-3">Tamper-Proof Logs</h4>
                    <p class="text-sm text-gray-600">Attendance data is locked down securely. Export records easily for automated auditing and HR compliance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing & Subscriptions Section -->
    <section id="pricing" class="py-16 md:py-24 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-navy mb-4">Subscription Plans</h3>
                <div class="w-24 h-1.5 bg-saffron mx-auto rounded"></div>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Scale your attendance infrastructure seamlessly. Start small or secure a permanent enterprise license.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Plan: 6 Months -->
                <div class="bg-white rounded-xl border border-gray-200 shadow p-6 hover:border-navy hover:shadow-lg transition">
                    <h4 class="text-xl font-bold text-navy mb-2">Starter</h4>
                    <div class="text-sm text-gray-500 font-semibold mb-4 uppercase">6 Months License</div>
                    <p class="text-gray-600 text-sm mb-6 pb-6 border-b border-gray-100">Perfect for small teams testing the geofence tracking ecosystem.</p>
                    <ul class="text-sm space-y-3 mb-8">
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Multi-tenant SaaS</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Core Geofencing</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Standard Support</li>
                    </ul>
                    <a href="#" class="block w-full text-center bg-lightbg text-navy border border-navy hover:bg-navy hover:text-white transition font-semibold py-2 rounded">Choose Plan</a>
                </div>

                <!-- Plan: 1 Year -->
                <div class="bg-navy rounded-xl border border-blue-900 shadow-xl p-6 relative transform lg:-translate-y-4">
                    <div class="absolute top-0 right-0 bg-saffron text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-xl uppercase tracking-wider">Most Popular</div>
                    <h4 class="text-xl font-bold text-white mb-2">Annual</h4>
                    <div class="text-sm text-gray-300 font-semibold mb-4 uppercase">1 Year License</div>
                    <p class="text-gray-300 text-sm mb-6 pb-6 border-b border-blue-800">Ideal for growing companies needing reliable annual compliance.</p>
                    <ul class="text-sm space-y-3 mb-8">
                        <li class="flex items-center text-white"><svg class="w-4 h-4 text-saffron mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> All Starter Features</li>
                        <li class="flex items-center text-white"><svg class="w-4 h-4 text-saffron mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Live Location Tracking</li>
                        <li class="flex items-center text-white"><svg class="w-4 h-4 text-saffron mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priority Support</li>
                    </ul>
                    <a href="#" class="block w-full text-center bg-saffron text-white hover:bg-orange-600 transition font-bold py-2 rounded">Choose Plan</a>
                </div>

                <!-- Plan: 2 Years -->
                <div class="bg-white rounded-xl border border-gray-200 shadow p-6 hover:border-navy hover:shadow-lg transition">
                    <h4 class="text-xl font-bold text-navy mb-2">Growth</h4>
                    <div class="text-sm text-gray-500 font-semibold mb-4 uppercase">2 Years License</div>
                    <p class="text-gray-600 text-sm mb-6 pb-6 border-b border-gray-100">Best value for established organizations securing long-term ops.</p>
                    <ul class="text-sm space-y-3 mb-8">
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Discounted Rate</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Advanced Analytics</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Dedicated Manager</li>
                    </ul>
                    <a href="#" class="block w-full text-center bg-lightbg text-navy border border-navy hover:bg-navy hover:text-white transition font-semibold py-2 rounded">Choose Plan</a>
                </div>

                <!-- Plan: 5 Years -->
                <div class="bg-white rounded-xl border border-gray-200 shadow p-6 hover:border-navy hover:shadow-lg transition">
                    <h4 class="text-xl font-bold text-navy mb-2">Enterprise</h4>
                    <div class="text-sm text-gray-500 font-semibold mb-4 uppercase">5 Years License</div>
                    <p class="text-gray-600 text-sm mb-6 pb-6 border-b border-gray-100">Massive operational stability for large scale corporations.</p>
                    <ul class="text-sm space-y-3 mb-8">
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Highest SaaS Discount</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Custom Integrations</li>
                        <li class="flex items-center text-gray-700"><svg class="w-4 h-4 text-green mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 24/7 Phone Support</li>
                    </ul>
                    <a href="#" class="block w-full text-center bg-lightbg text-navy border border-navy hover:bg-navy hover:text-white transition font-semibold py-2 rounded">Choose Plan</a>
                </div>
            </div>

            <!-- Permanent Tier -->
            <div class="bg-white border-2 border-saffron rounded-xl p-8 max-w-4xl mx-auto shadow-xl text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-saffron"></div>
                <h4 class="text-2xl font-bold text-navy mb-2">Lifetime / Permanent License</h4>
                <p class="text-gray-600 mb-6 text-lg">Don't want SaaS? Get the fully-owned, ready-made software and mobile app.</p>
                
                <div class="flex flex-col md:flex-row justify-center items-center gap-8 mb-6 text-left">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-saffron mr-3 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        <div>
                            <h5 class="font-bold text-gray-800">Source Code Access</h5>
                            <p class="text-sm text-gray-500">Full ownership of backend and frontend code.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-saffron mr-3 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <div>
                            <h5 class="font-bold text-gray-800">White-Label Delivery</h5>
                            <p class="text-sm text-gray-500">Deploy under your own brand and domains.</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="inline-block bg-navy text-white px-8 py-3 rounded text-lg font-bold shadow hover:bg-blue-800 transition">Contact For Pricing</a>
            </div>
        </div>
    </section>

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
                    <a href="#" class="hover:text-white hover:underline transition">Terms & Conditions</a>
                    <a href="/admin/privacy-policy" class="hover:text-white hover:underline transition">Privacy Policy</a>
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

</body>
</html>
