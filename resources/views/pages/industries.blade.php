@extends('layouts.public')

@section('title', 'Industries We Serve - Geofence Attendance Portal')

@section('content')
<div class="bg-gray-100 border-b border-gray-300 py-2.5">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-blue-800 hover:text-blue-900 hover:underline font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-1 text-gray-400">»</span>
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">Industries We Serve</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-navy py-12 border-b-4 border-saffron relative z-10">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Industries We Serve</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Our robust geofencing attendance platform is engineered to meet the unique operational challenges of various sectors.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-[85rem]">
    <div class="p-8 md:p-12 rounded-xl shadow-sm border border-gray-200 bg-cover bg-center bg-no-repeat" style="background-color: white; background-image: url('{{ asset('world-map-bg.png') }}');">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Corporate Offices -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Corporate Offices</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Enforce strict on-premise attendance. Prevent buddy punching and remote check-ins effortlessly while maintaining digital records for compliance.</p>
            </div>

            <!-- Construction Sites -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Construction Sites</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Manage dynamic work zones. Create temporary geofences for shifting project sites to track contractor and daily wager attendance accurately.</p>
            </div>

            <!-- Healthcare & Hospitals -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Healthcare & Hospitals</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Ensure shift accountability. Track doctor and nursing staff availability within specific hospital wards and emergency perimeters.</p>
            </div>

            <!-- Educational Institutes -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Educational Institutes</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Automate faculty attendance. Set geofences around campus boundaries so professors and staff can seamlessly mark their presence.</p>
            </div>

            <!-- Manufacturing Plants -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Manufacturing Plants</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Streamline shift changes. Manage large volumes of factory workers with high-accuracy GPS check-ins at specific factory entry gates.</p>
            </div>

            <!-- Administration & Public Works -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Admin & Public Works</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Optimize government operations. Ensure civil servants and public workers are logging hours exclusively within designated municipal buildings.</p>
            </div>
            
            <!-- Logistics & Field Sales -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3m-1 4v-4m0 4h-4m4 0a2 2 0 100-4 2 2 0 000 4zm-8 0a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">Logistics & Field Sales</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Track dynamic movements. Verify field representatives' visits to client locations and monitor delivery routes with specialized dynamic geofencing constraints designed for mobile workforces.</p>
            </div>

            <!-- All Kinds of Industry & Business -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-md border border-gray-200 p-6 flex flex-col items-center text-center hover:shadow-xl hover:border-saffron transition-all duration-300 group">
                <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-saffron group-hover:text-white transition-colors duration-300 text-saffron">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-navy mb-2">All Businesses</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Universally adaptable. Whether you're a startup, retail chain, or NGO, our flexible geofencing parameters scale seamlessly to manage any type of business workforce globally.</p>
            </div>
        </div>
    </div>
</div>
@endsection
