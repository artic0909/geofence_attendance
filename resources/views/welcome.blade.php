@extends('layouts.public')

@section('content')
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
                    <a href="{{ url('/pricing') }}" class="bg-saffron text-white px-8 py-3 rounded text-lg font-bold shadow-lg hover:bg-orange-600 transition text-center flex items-center justify-center">
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
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Corporate Offices</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Construction Sites</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Healthcare & Hospitals</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg> Educational Institutes</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Manufacturing Plants</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-1 4v-4m0 4h-4m4 0a2 2 0 100-4 2 2 0 000 4zm-8 0a2 2 0 100-4 2 2 0 000 4z"></path></svg> Logistics & Field Sales</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg> Administration & Public Works</span>
                    
                    <!-- Duplicate for infinite effect -->
                    <span class="flex items-center ml-12"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> Corporate Offices</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Construction Sites</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Healthcare & Hospitals</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg> Educational Institutes</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Manufacturing Plants</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-1 4v-4m0 4h-4m4 0a2 2 0 100-4 2 2 0 000 4zm-8 0a2 2 0 100-4 2 2 0 000 4z"></path></svg> Logistics & Field Sales</span>
                    <span class="flex items-center"><svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg> Administration & Public Works</span>
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
    <!-- Pricing & Subscriptions Section -->
    <section id="pricing" class="py-16 md:py-24 bg-lightbg border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-bold text-navy mb-4">Subscription Plans</h3>
                <div class="w-24 h-1.5 bg-saffron mx-auto rounded"></div>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">Scale at your own pace with our flexible multi-tenant SaaS plans, or take complete ownership with a Lifetime License.</p>
            </div>
            
            <!-- SaaS Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <!-- 6 Months -->
                <div class="bg-white rounded-xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <h4 class="text-xl font-bold text-navy mb-2">Starter</h4>
                    <div class="text-saffron font-bold mb-6 text-2xl">6 Months</div>
                    <div class="text-gray-600 text-sm mb-8 flex-grow">Perfect for small teams testing the ecosystem before scaling.</div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-700">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Multi-tenant Access</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Core Geofencing</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Standard Support</li>
                    </ul>
                    <button class="w-full py-3 rounded text-navy font-bold border-2 border-navy hover:bg-navy hover:text-white transition">Select Plan</button>
                </div>

                <!-- 1 Year -->
                <div class="bg-white rounded-xl p-8 border-2 border-saffron shadow-lg transform lg:-translate-y-4 flex flex-col relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-saffron text-white text-xs font-bold px-4 py-1 rounded-full uppercase tracking-wider">Most Popular</div>
                    <h4 class="text-xl font-bold text-navy mb-2">Annual</h4>
                    <div class="text-saffron font-bold mb-6 text-2xl">1 Year</div>
                    <div class="text-gray-600 text-sm mb-8 flex-grow">Ideal for growing companies needing reliable annual compliance.</div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-700">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> All Starter Features</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Live Location Tracking</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priority Support</li>
                    </ul>
                    <button class="w-full py-3 rounded bg-navy text-white font-bold hover:bg-blue-800 transition shadow">Select Plan</button>
                </div>

                <!-- 2 Years -->
                <div class="bg-white rounded-xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <h4 class="text-xl font-bold text-navy mb-2">Growth</h4>
                    <div class="text-saffron font-bold mb-6 text-2xl">2 Years</div>
                    <div class="text-gray-600 text-sm mb-8 flex-grow">Best value for established organizations securing long-term ops.</div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-700">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Discounted Rate</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Advanced Analytics</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Dedicated Manager</li>
                    </ul>
                    <button class="w-full py-3 rounded text-navy font-bold border-2 border-navy hover:bg-navy hover:text-white transition">Select Plan</button>
                </div>

                <!-- 5 Years -->
                <div class="bg-white rounded-xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-navy transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <h4 class="text-xl font-bold text-navy mb-2">Enterprise</h4>
                    <div class="text-saffron font-bold mb-6 text-2xl">5 Years</div>
                    <div class="text-gray-600 text-sm mb-8 flex-grow">Massive operational stability with maximum cost efficiency.</div>
                    <ul class="space-y-4 mb-8 text-sm text-gray-700">
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Maximum Discount</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Custom Integrations</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-green mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 24/7 SLA Support</li>
                    </ul>
                    <button class="w-full py-3 rounded text-navy font-bold border-2 border-navy hover:bg-navy hover:text-white transition">Select Plan</button>
                </div>
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
                <a href="#" class="inline-block bg-navy text-white px-8 py-3 rounded text-lg font-bold shadow hover:bg-blue-800 transition">Contact For Pricing</a>
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
    <section class="py-16 md:py-24 bg-white relative overflow-hidden">
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

    <!-- App Download Section -->
    <section class="py-16 md:py-24 bg-lightbg border-t border-gray-200 overflow-hidden relative">
        <div class="absolute inset-0 bg-navy opacity-5" style="background-image: repeating-linear-gradient(45deg, #000080 25%, transparent 25%, transparent 75%, #000080 75%, #000080), repeating-linear-gradient(45deg, #000080 25%, transparent 25%, transparent 75%, #000080 75%, #000080); background-position: 0 0, 10px 10px; background-size: 20px 20px;"></div>
        <div class="container mx-auto px-4 max-w-6xl relative z-10 flex flex-col lg:flex-row items-center justify-between">
            <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0">
                <div class="inline-block px-3 py-1 bg-green/20 text-green font-bold rounded-full text-xs uppercase tracking-wide mb-4 border border-green/30">Available Everywhere</div>
                <h3 class="text-3xl md:text-5xl font-bold text-navy mb-6 leading-tight">Take Control of Your <br><span class="text-saffron">Workforce On-The-Go</span></h3>
                <p class="text-gray-600 text-lg mb-8 max-w-lg mx-auto lg:mx-0">Empower your employees to check in instantly using our secure, battery-optimized mobile applications. Get real-time alerts and manage approvals directly from your pocket.</p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="flex items-center justify-center bg-navy hover:bg-blue-800 text-white rounded-lg px-6 py-3 transition shadow-lg transform hover:-translate-y-1">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12c0-5.523-4.477-10-10-10z" style="display:none;"/><path d="M16.365 7.043c-.458.74-1.268 1.258-2.186 1.298-.073-1.042.434-2.164 1.135-2.825.684-.64 1.632-1.036 2.457-1.002.083 1.066-.464 2.115-1.406 2.529M17.151 16.93c-1.144.02-2.19-.808-3.32-.808-1.128 0-2.02.828-3.318.828-1.506 0-2.873-1.282-3.774-2.617-1.85-2.73-2.223-7.556-.25-10.222.97-1.31 2.39-2.128 3.868-2.147 1.408-.02 2.68 1.01 3.54 1.01.86 0 2.4-1.251 4.108-1.05 1.765.207 3.32 1.082 4.198 2.378-3.415 1.95-2.825 6.786.666 8.163-.82 2.106-2.02 4.364-3.766 4.444-1.93.08-2.182-1.334-3.812-1.334-1.632 0-2.182 1.272-3.81 1.333z"/></svg>
                        <div class="text-left">
                            <div class="text-xs font-semibold text-gray-300">Download on the</div>
                            <div class="text-lg font-bold leading-none">App Store</div>
                        </div>
                    </a>
                    
                    <a href="#" class="flex items-center justify-center bg-white border-2 border-gray-200 hover:border-saffron hover:bg-gray-50 text-navy rounded-lg px-6 py-3 transition shadow transform hover:-translate-y-1 group">
                        <svg class="w-8 h-8 mr-3" viewBox="0 0 24 24"><path fill="#EA4335" d="M12.005 14.536L3.992 5.068C4.545 4.437 5.4 4 6.368 4h11.265c.968 0 1.823.437 2.376 1.068l-8.004 9.468z"/><path fill="#FBBC04" d="M20.008 5.068A3.498 3.498 0 0121.265 7v10c0 .968-.437 1.823-1.068 2.376l-8.192-9.689 8.003-4.619z"/><path fill="#34A853" d="M12.005 14.536l8.192-4.848a3.498 3.498 0 011.068 2.376v10c0 .968-.437 1.823-1.068 2.376H6.368a3.498 3.498 0 01-2.376-1.068l8.013-8.836z"/><path fill="#4285F4" d="M3.992 5.068L12.005 14.536 3.992 23.376A3.498 3.498 0 012.735 21V7c0-.968.437-1.823 1.068-2.376z"/></svg>
                        <div class="text-left">
                            <div class="text-xs font-semibold text-gray-500 group-hover:text-gray-700">GET IT ON</div>
                            <div class="text-lg font-bold leading-none">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="lg:w-1/2 flex justify-center lg:justify-end relative">
                <!-- Mockup Graphic -->
                <div class="relative w-64 md:w-80 h-[500px] bg-navy rounded-[3rem] border-[8px] border-gray-800 shadow-2xl overflow-hidden transform rotate-[-5deg] hover:rotate-0 transition-transform duration-500 z-10 flex flex-col">
                    <div class="absolute top-0 w-full h-6 bg-gray-800 rounded-b-xl flex justify-center z-20">
                        <div class="w-20 h-4 bg-black rounded-b-lg"></div>
                    </div>
                    <!-- App UI mock -->
                    <div class="flex-1 bg-lightbg pt-10 px-4 pb-4 overflow-hidden">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h4 class="font-bold text-navy text-lg leading-tight">Welcome back,</h4>
                                <p class="text-gray-500 text-xs">Rajiv K.</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-saffron text-white flex items-center justify-center font-bold text-sm">RK</div>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 shadow-sm mb-4 border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-gray-400 uppercase">Status</span>
                                <span class="px-2 py-1 bg-green/10 text-green text-[10px] font-bold rounded-full">Inside Geofence</span>
                            </div>
                            <div class="text-2xl font-bold text-navy">Ready to Check-in</div>
                            <p class="text-[10px] text-gray-500 mt-1">Lat: 28.6139, Long: 77.2090</p>
                        </div>
                        
                        <div class="w-full h-32 bg-blue-100 rounded-xl mb-6 relative overflow-hidden flex items-center justify-center">
                            <svg class="w-full h-full text-blue-200" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 50 Q 25 30, 50 50 T 100 50 L 100 100 L 0 100 Z"/></svg>
                            <div class="absolute w-12 h-12 bg-green/20 rounded-full flex items-center justify-center animate-ping"></div>
                            <div class="absolute w-6 h-6 bg-green rounded-full border-2 border-white shadow-md"></div>
                        </div>
                        
                        <button class="w-full py-3 bg-saffron text-white font-bold rounded-lg shadow hover:bg-orange-600 transition">SWIPE TO CHECK-IN</button>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute -right-10 top-20 w-32 h-32 bg-green/10 rounded-full blur-2xl"></div>
                <div class="absolute left-10 -bottom-10 w-40 h-40 bg-saffron/10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </section>
@endsection
