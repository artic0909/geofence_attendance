@extends('layouts.public')

@section('meta_title', 'Geofence Employee Attendance System | Location-Based Tracking')
@section('meta_description', 'Secure, scalable, and tamper-proof geofencing attendance system for field forces, construction, healthcare, and corporate industries. ProjectAttendance.com provides the ultimate location-based employee tracking software.')
@section('meta_keywords', 'geofence attendance, location based tracking, employee attendance system, geofencing software, field sales tracking, construction attendance, projectattendance.com')


@section('content')
    <!-- Hero Section -->
    <section class="hero-bg text-white py-20 md:py-32 flex-grow flex items-center relative overflow-hidden">
        <!-- Desktop Video Background -->
        <video autoplay loop muted playsinline class="hidden md:block absolute top-0 left-0 w-full h-full object-cover z-0 pointer-events-none">
            <source src="{{ asset('videos/big-hero.mp4') }}" type="video/mp4">
        </video>
        <!-- Mobile Video Background -->
        <video autoplay loop muted playsinline class="block md:hidden absolute top-0 left-0 w-full h-full object-cover z-0 pointer-events-none">
            <source src="{{ asset('videos/mobile-hero.mp4') }}" type="video/mp4">
        </video>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50 z-0"></div>

        <div class="container mx-auto px-4 text-center md:text-left relative z-10">
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
                    <a href="{{ url('/pricing') }}" class="bg-saffron text-white px-8 py-3 rounded text-lg font-bold shadow-lg hover:bg-orange-600 transition text-center flex items-center justify-center">
                        View Subscription Plans
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Carousel -->
    <section class="bg-navy bg-india-map py-6 md:py-8 border-y-4 border-saffron overflow-hidden shadow-[0_10px_30px_rgba(0,0,128,0.5)] relative z-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center relative gap-4 md:gap-0">
            <div class="flex-shrink-0 z-10 bg-gradient-to-r from-saffron to-orange-600 text-white font-extrabold text-sm md:text-lg uppercase tracking-widest py-3 px-6 rounded-lg shadow-[0_0_20px_rgba(255,153,51,0.6)] border border-orange-400 md:mr-8 flex items-center">
                <svg class="w-6 h-6 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                Trusted Across Sectors
            </div>
            
            <div class="relative flex overflow-hidden w-full">
                <!-- Moving marquee -->
                <div class="whitespace-nowrap animate-marquee flex space-x-16 items-center text-white font-bold text-lg">
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Corporate Offices</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Construction Sites</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Healthcare & Hospitals</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg> Educational Institutes</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Manufacturing Plants</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-1 4v-4m0 4h-4m4 0a2 2 0 100-4 2 2 0 000 4zm-8 0a2 2 0 100-4 2 2 0 000 4z"></path></svg> Logistics & Field Sales</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg> Administration & Public Works</span>
                    
                    <!-- Duplicate for infinite effect -->
                    <span class="flex items-center ml-16"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Corporate Offices</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Construction Sites</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Healthcare & Hospitals</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg> Educational Institutes</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Manufacturing Plants</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-1 4v-4m0 4h-4m4 0a2 2 0 100-4 2 2 0 000 4zm-8 0a2 2 0 100-4 2 2 0 000 4z"></path></svg> Logistics & Field Sales</span>
                    <span class="flex items-center"><svg class="w-6 h-6 mr-3 text-saffron drop-shadow-[0_0_8px_rgba(255,153,51,0.8)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg> Administration & Public Works</span>
                </div>
            </div>
        </div>
    </section>

        <!-- App Download Section -->
    <section class="w-full border-t border-gray-200 py-16 md:py-24" style="background-color: #EAF0FD;">
        <div class="container mx-auto px-4 flex justify-center">
            <img src="{{ asset('mobileappsection.png') }}" alt="Geofence Attendance Mobile App" class="w-[95%] md:w-[85%] lg:w-[75%] max-w-6xl h-auto rounded-2xl shadow-xl border-4 border-white/50 block">
        </div>
    </section>

    <!-- Core Capabilities / Features Section -->
    <section id="features" class="py-16 md:py-24 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('world-map-bg.png') }}');">
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
    <!-- Pricing & Subscriptions Section -->
    <section id="pricing" class="py-16 md:py-24 border-t border-gray-200 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('world-map-bg.png') }}');">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-navy mb-4">Subscription Plans</h3>
                <div class="w-24 h-1.5 bg-saffron mx-auto rounded"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">Scale at your own pace with our flexible multi-tenant SaaS plans, or take complete ownership with a Lifetime License.</p>
            </div>
            
            <!-- Standard Plan Cards Carousel -->
            <div class="relative max-w-7xl mx-auto mb-16 px-4 sm:px-12">
                
                <!-- Slide Instruction (Mobile & Desktop) -->
                <div class="flex justify-end mb-3">
                    <span class="inline-block bg-saffron text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md animate-pulse whitespace-nowrap">
                        &larr; Slide to show &rarr;
                    </span>
                </div>

                <!-- Left Button -->
                <button onclick="document.getElementById('plans-carousel').scrollBy({left: -350, behavior: 'smooth'})" 
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center text-navy hover:bg-navy hover:text-white transition-colors border border-gray-100 hidden md:flex focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <div id="plans-carousel" class="flex overflow-x-auto gap-8 pb-8 pt-4 snap-x snap-mandatory hide-scrollbar" style="scroll-snap-type: x mandatory; scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .hide-scrollbar::-webkit-scrollbar { display: none; }
                    </style>
                    @foreach($plans as $plan)
                    <div class="min-w-[300px] max-w-[350px] w-full flex-none snap-center bg-white rounded-2xl shadow-xl overflow-hidden border {{ $plan->is_trial ? 'border-gray-200' : 'border-saffron' }} flex flex-col hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-8 {{ $plan->is_trial ? 'bg-gray-50 text-gray-800' : 'bg-navy text-white' }} text-center">
                        <h4 class="text-2xl font-bold mb-2">{{ $plan->name }}</h4>
                        <div class="text-sm {{ $plan->is_trial ? 'text-gray-500' : 'text-gray-300' }} mb-4">{{ $plan->duration_days }} Days Access</div>
                        @if($plan->is_trial)
                            <div class="text-4xl font-extrabold text-navy">Free</div>
                        @else
                            <div class="text-4xl font-extrabold text-saffron">
                                ₹{{ number_format($plan->price + ($plan->price_per_employee * ($plan->employee_count ?? 10)), 2) }}
                            </div>
                            <div class="text-xs {{ $plan->is_trial ? 'text-gray-500' : 'text-gray-300' }} mt-2">Includes {{ $plan->employee_count ?? 10 }} Employees (Base)</div>
                        @endif
                    </div>
                    <div class="p-8 flex-grow">
                        <ul class="space-y-4 mb-8">
                            @php $featuresList = is_array($plan->features) ? $plan->features : explode("\n", $plan->features ?? ''); @endphp
                            @foreach($featuresList as $feature)
                                @if(trim($feature))
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-gray-600 text-sm">{{ trim($feature) }}</span>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="p-8 pt-0 mt-auto">
                        @if($plan->is_trial)
                            <a href="{{ route('register', ['plan_id' => $plan->id, 'employees' => $plan->employee_count ?? 10]) }}" class="block w-full py-3 rounded text-center border-2 border-navy text-navy font-bold hover:bg-navy hover:text-white transition-colors">Start Free Trial</a>
                        @else
                            <a href="{{ route('register', ['plan_id' => $plan->id, 'employees' => $plan->employee_count ?? 10]) }}" class="block w-full py-3 rounded text-center bg-saffron text-white font-bold hover:bg-orange-600 transition-colors shadow-md">Buy Now</a>
                        @endif
                    </div>
                </div>
                    @endforeach
                </div>
                
                <!-- Right Button -->
                <button onclick="document.getElementById('plans-carousel').scrollBy({left: 350, behavior: 'smooth'})" 
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center text-navy hover:bg-navy hover:text-white transition-colors border border-gray-100 hidden md:flex focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
            
            <!-- Custom Plan Calculator -->
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-saffron mb-16" id="pricing-calculator">
                <div class="p-8 md:p-12">
                    <h4 class="text-2xl font-bold text-navy mb-8 text-center">Customize Your Subscription</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Left Column: Inputs -->
                        <div class="space-y-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">1. Select Duration</label>
                                <div class="grid grid-cols-3 gap-3" id="plan-duration-container">
                                    @php $firstPaidPlan = true; @endphp
                                    @foreach($plans as $plan)
                                        @if($plan->is_trial) @continue @endif
                                        <button type="button" 
                                            class="duration-btn py-3 px-2 border-2 rounded-lg text-center transition-all focus:outline-none {{ $firstPaidPlan ? 'border-saffron bg-orange-50 text-saffron font-bold' : 'border-gray-200 text-gray-600 hover:border-gray-300' }}"
                                            data-plan-id="{{ $plan->id }}"
                                            data-base-price="{{ $plan->price }}"
                                            data-per-employee="{{ $plan->price_per_employee }}"
                                            data-base-employees="{{ $plan->employee_count ?? 10 }}"
                                            data-is-trial="false">
                                            <span class="block text-lg">{{ $plan->duration_days }}</span>
                                            <span class="block text-xs uppercase">Days</span>
                                        </button>
                                        @php $firstPaidPlan = false; @endphp
                                    @endforeach
                                </div>
                            </div>
                            
                            <div>
                                <label for="employee_count" class="block text-sm font-bold text-gray-700 mb-3">2. Number of Employees</label>
                                <input type="number" id="employee_count" min="10" value="10" class="block w-full text-2xl font-bold text-center border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron py-3 bg-gray-50">
                                <p class="text-xs text-gray-500 mt-2 text-center" id="employee_min_help">Minimum 10 employees recommended.</p>
                            </div>
                        </div>

                        <!-- Right Column: Calculation & Action -->
                        <div class="bg-gray-50 rounded-xl p-8 border border-gray-100 flex flex-col justify-center relative overflow-hidden">
                            <!-- Background decoration -->
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-navy opacity-5 rounded-full"></div>
                            
                            <div class="space-y-4 mb-8 relative z-10">
                                <div class="flex justify-between items-center text-gray-600 border-b border-gray-200 pb-2">
                                    <span>Fixed Base Charge:</span>
                                    <span id="display_base_price" class="font-medium">₹0.00</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-600 border-b border-gray-200 pb-2">
                                    <span>Employee Cost <span id="display_employee_calc" class="text-xs"></span>:</span>
                                    <span id="display_employee_total" class="font-medium">₹0.00</span>
                                </div>
                                <div class="flex justify-between items-end pt-2">
                                    <span class="text-lg font-bold text-navy">Total Value:</span>
                                    <div class="text-right">
                                        <span id="display_total_price" class="text-4xl font-extrabold text-saffron block">₹0.00</span>
                                        <span class="text-xs text-gray-500">Excluding GST</span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('register') }}" id="btn_buy_now" class="w-full py-4 rounded text-center text-white bg-navy font-bold hover:bg-blue-900 transition-all shadow-lg transform hover:-translate-y-1 relative z-10 flex items-center justify-center">
                                Proceed to Register & Buy
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const durationBtns = document.querySelectorAll('.duration-btn');
                    const employeeInput = document.getElementById('employee_count');
                    
                    const displayBase = document.getElementById('display_base_price');
                    const displayEmpCalc = document.getElementById('display_employee_calc');
                    const displayEmpTotal = document.getElementById('display_employee_total');
                    const displayTotal = document.getElementById('display_total_price');
                    
                    let activePlan = null;
                    
                    if(durationBtns.length > 0) {
                        // Init with first plan
                        setActivePlan(durationBtns[0]);
                    }
                    
                    durationBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            // Update UI
                            durationBtns.forEach(b => {
                                b.classList.remove('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
                                b.classList.add('border-gray-200', 'text-gray-600');
                            });
                            this.classList.remove('border-gray-200', 'text-gray-600');
                            this.classList.add('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
                            
                            setActivePlan(this);
                        });
                    });
                    
                    employeeInput.addEventListener('input', calculateTotal);
                    
                    function setActivePlan(btn) {
                        activePlan = {
                            id: btn.getAttribute('data-plan-id'),
                            basePrice: parseFloat(btn.getAttribute('data-base-price')),
                            perEmployee: parseFloat(btn.getAttribute('data-per-employee')),
                            baseEmployees: parseInt(btn.getAttribute('data-base-employees')) || 10,
                            isTrial: btn.getAttribute('data-is-trial') === 'true'
                        };
                        
                        let minEmp = activePlan.baseEmployees;
                        employeeInput.min = minEmp;
                        document.getElementById('employee_min_help').innerText = `Minimum ${minEmp} employees recommended for this plan.`;
                        
                        if(parseInt(employeeInput.value) < minEmp) {
                            employeeInput.value = minEmp;
                        }

                        calculateTotal();
                    }
                    
                    employeeInput.addEventListener('blur', function() {
                        if (!activePlan) return;
                        let minEmp = activePlan.baseEmployees;
                        let count = parseInt(this.value) || 0;
                        if (count < minEmp) {
                            this.value = minEmp;
                            calculateTotal();
                        }
                    });

                    function calculateTotal() {
                        if(!activePlan) return;
                        
                        let minEmp = activePlan.baseEmployees;
                        let count = parseInt(employeeInput.value) || 0;
                        if(count < minEmp) count = minEmp;
                        
                        // Update button link
                        const btnBuyNow = document.getElementById('btn_buy_now');
                        btnBuyNow.href = `{{ route('register') }}?plan_id=${activePlan.id}&employees=${count}`;
                        
                        // If it's a trial, enforce 0 price
                        if(activePlan.isTrial) {
                            displayBase.innerText = "₹0.00 (Trial)";
                            displayEmpCalc.innerText = `(${count} Employees)`;
                            displayEmpTotal.innerText = "₹0.00";
                            displayTotal.innerText = "₹0.00";
                            return;
                        }
                        
                        const base = activePlan.basePrice;
                        const perEmp = activePlan.perEmployee;
                        const empTotal = count * perEmp;
                        const grandTotal = base + empTotal;
                        
                        displayBase.innerText = "₹" + base.toLocaleString('en-IN', {minimumFractionDigits: 2});
                        displayEmpCalc.innerText = `(${count} x ₹${perEmp})`;
                        displayEmpTotal.innerText = "₹" + empTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
                        displayTotal.innerText = "₹" + grandTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
                    }
                });
            </script>

            <!-- Permanent Tier Highlight -->
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
                <a href="/contact" class="inline-block bg-navy text-white px-8 py-3 rounded text-lg font-bold shadow hover:bg-blue-800 transition">Contact For Pricing</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us / Guarantees -->
    <section class="py-16 md:py-24 bg-navy text-white relative border-b-4 border-saffron">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Geofence Portal?</h3>
                <div class="w-24 h-1.5 bg-saffron mx-auto rounded"></div>
                <p class="mt-4 text-gray-300 max-w-2xl mx-auto">Enterprise-grade reliability and security tailored for seamless workforce management.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <div class="text-center p-6 bg-blue-900/40 rounded-xl border border-blue-800">
                    <div class="w-16 h-16 bg-saffron rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">99.9% Uptime Guarantee</h4>
                    <p class="text-sm text-gray-300">Built on highly available cloud infrastructure ensuring your attendance system is never down when your workforce needs it.</p>
                </div>
                
                <div class="text-center p-6 bg-blue-900/40 rounded-xl border border-blue-800">
                    <div class="w-16 h-16 bg-green rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Tamper-Proof Security</h4>
                    <p class="text-sm text-gray-300">GPS spoofing detection and cryptographically secure logs ensure that attendance data remains authentic and legally compliant.</p>
                </div>

                <div class="text-center p-6 bg-blue-900/40 rounded-xl border border-blue-800">
                    <div class="w-16 h-16 bg-saffron rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">24/7 Priority Support</h4>
                    <p class="text-sm text-gray-300">Our technical experts are available round the clock to assist your IT team with deployment, scaling, or troubleshooting.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel -->
    <section class="py-16 md:py-24 relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('world-map-bg.png') }}');">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-navy mb-4">What Our Clients Say</h3>
                <div class="w-24 h-1.5 bg-green mx-auto rounded"></div>
            </div>

            <!-- CSS Only Infinite Carousel -->
            <style>
                .testimonial-marquee {
                    display: flex;
                    width: max-content;
                    animation: scroll-left 40s linear infinite;
                }
                .testimonial-marquee:hover {
                    animation-play-state: paused;
                }
                @keyframes scroll-left {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .testimonial-card {
                    width: 350px;
                    flex-shrink: 0;
                }
            </style>
            
            <div class="relative overflow-hidden w-full py-4" style="mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);">
                <div class="testimonial-marquee flex space-x-6">
                    <!-- Original Set -->
                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"The geofence accuracy is phenomenal. We completely eliminated proxy attendance across our 15 construction sites within the first month."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-bold mr-3">RK</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Rajiv K.</h5>
                                <p class="text-xs text-gray-500">Operations Head, BuildCorp</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"Opting for the Lifetime License was the best IT decision. Full source code access and it was perfectly white-labeled for our hospital chain."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-saffron text-white flex items-center justify-center font-bold mr-3">SM</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Dr. Sarah M.</h5>
                                <p class="text-xs text-gray-500">Director, City Hospital</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"As an enterprise managing 5,000+ field sales executives, the multi-tenant SaaS model gave us separate portals for every region. Incredible scale."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green text-white flex items-center justify-center font-bold mr-3">AP</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Amit P.</h5>
                                <p class="text-xs text-gray-500">VP HR, LogiX Solutions</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Duplicate Set for Infinite Scroll -->
                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"The geofence accuracy is phenomenal. We completely eliminated proxy attendance across our 15 construction sites within the first month."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-bold mr-3">RK</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Rajiv K.</h5>
                                <p class="text-xs text-gray-500">Operations Head, BuildCorp</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"Opting for the Lifetime License was the best IT decision. Full source code access and it was perfectly white-labeled for our hospital chain."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-saffron text-white flex items-center justify-center font-bold mr-3">SM</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Dr. Sarah M.</h5>
                                <p class="text-xs text-gray-500">Director, City Hospital</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card bg-lightbg p-6 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex text-saffron mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"As an enterprise managing 5,000+ field sales executives, the multi-tenant SaaS model gave us separate portals for every region. Incredible scale."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green text-white flex items-center justify-center font-bold mr-3">AP</div>
                            <div>
                                <h5 class="font-bold text-navy text-sm">Amit P.</h5>
                                <p class="text-xs text-gray-500">VP HR, LogiX Solutions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
