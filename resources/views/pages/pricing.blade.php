@extends('layouts.public')

@section('title', 'Subscription Plans - Geofence Attendance Portal')

@section('content')
<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Pricing & Subscription Models</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Scale at your own pace with our flexible multi-tenant SaaS plans, or take complete ownership with a Lifetime License.</p>
    </div>
</div>

<section class="py-16 md:py-24 bg-lightbg">
    <div class="container mx-auto px-4 max-w-7xl">
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

        <!-- Permanent Tier -->
        <div class="bg-white border-2 border-saffron rounded-xl p-8 md:p-12 max-w-5xl mx-auto shadow-xl text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-saffron"></div>
            <div class="inline-block px-4 py-1 rounded bg-orange-100 text-saffron text-sm font-bold uppercase tracking-widest mb-4">
                Enterprise Ownership
            </div>
            <h4 class="text-3xl md:text-4xl font-bold text-navy mb-4">Lifetime / Permanent License</h4>
            <p class="text-gray-600 mb-8 text-lg max-w-3xl mx-auto">Don't want to pay SaaS subscription fees forever? Purchase the fully-developed, production-ready software and mobile app entirely.</p>
            
            <div class="flex flex-col md:flex-row justify-center items-start md:items-center gap-8 mb-10 text-left max-w-3xl mx-auto">
                <div class="flex items-start bg-lightbg p-4 rounded-lg flex-1">
                    <svg class="w-8 h-8 text-saffron mr-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <div>
                        <h5 class="font-bold text-navy text-lg mb-1">Source Code Access</h5>
                        <p class="text-sm text-gray-600">Full ownership of backend logic, APIs, and frontend codebases.</p>
                    </div>
                </div>
                <div class="flex items-start bg-lightbg p-4 rounded-lg flex-1">
                    <svg class="w-8 h-8 text-saffron mr-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <div>
                        <h5 class="font-bold text-navy text-lg mb-1">White-Label Delivery</h5>
                        <p class="text-sm text-gray-600">We deploy it securely under your own brand, logo, and domains.</p>
                    </div>
                </div>
            </div>
            <a href="#" class="inline-block bg-navy text-white px-10 py-4 rounded text-xl font-bold shadow hover:bg-blue-800 transition">Contact Sales for Quote</a>
        </div>
    </div>
</section>
@endsection
