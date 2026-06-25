@extends('layouts.public')

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
        <div class="container mx-auto px-4 flex items-center relative">
            <div class="flex-shrink-0 z-10 bg-gradient-to-r from-saffron to-orange-600 text-white font-extrabold text-sm md:text-lg uppercase tracking-widest py-3 px-6 rounded-lg shadow-[0_0_20px_rgba(255,153,51,0.6)] border border-orange-400 mr-8 flex items-center">
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
            
            <!-- SaaS Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                @forelse($plans as $plan)
                <div class="bg-white rounded-xl p-8 border {{ $plan->is_popular ? 'border-saffron shadow-xl -translate-y-2 relative z-10' : 'border-gray-200 shadow-sm' }} hover:shadow-lg transition-all flex flex-col relative overflow-hidden group">
                    @if($plan->is_popular)
                        <div class="absolute top-0 right-0 bg-saffron text-white text-xs font-bold px-3 py-1 rounded-bl-lg">MOST POPULAR</div>
                        <div class="absolute top-0 left-0 w-full h-1 bg-saffron"></div>
                    @else
                        <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    @endif
                    <h4 class="text-xl font-bold text-navy mb-2 mt-2">{{ $plan->name }}</h4>
                    <div class="text-saffron font-bold mb-6 text-3xl">₹{{ number_format($plan->price, 2) }}</div>
                    <div class="text-gray-600 text-sm mb-8 flex-grow">{{ $plan->description }}</div>
                    @if($plan->features)
                    <ul class="space-y-4 mb-8 text-sm text-gray-700">
                        @foreach($plan->features as $feature)
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <a href="{{ route('register') }}" class="w-full py-3 rounded text-center text-navy font-bold border-2 border-navy hover:bg-navy hover:text-white transition">Get Started</a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">No subscription plans available at the moment. Please contact support.</p>
                </div>
                @endforelse
            </div>

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
