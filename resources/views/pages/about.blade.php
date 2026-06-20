@extends('layouts.public')

@section('title', 'About Us - Geofence Attendance Portal')

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
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">About Us</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">About the Platform</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Learn about our mission to revolutionize centralized workforce management.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="p-8 md:p-12 rounded-xl shadow-sm border border-gray-200 bg-cover bg-center bg-no-repeat" style="background-color: white; background-image: url('{{ asset('world-map-bg.png') }}');">
        <h2 class="text-2xl font-bold text-navy mb-6">Our Mission</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            The Official Geofence Attendance Portal was built with a singular vision: to bring absolute transparency and accountability to workforce management across all sectors. Whether you operate a corporate office, a construction site, or a public administration facility, ensuring that staff are exactly where they need to be is critical.
        </p>

        <h2 class="text-2xl font-bold text-navy mb-6 mt-10">How It Works</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            Our multi-tenant SaaS platform allows organizations to define strict geographic perimeters using highly accurate Lat/Long coordinates and a defined radius in meters. Once these geofences are established, employees can only log their attendance when they are physically inside the designated zones.
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-3 mb-8">
            <li><strong>Zero Hardware Required:</strong> Utilizes standard smartphones with GPS capabilities.</li>
            <li><strong>Smart Battery Optimization:</strong> Interval-based background pings for live tracking without draining devices.</li>
            <li><strong>Tamper-Proof Data:</strong> Cryptographically secure attendance logs ensure compliance and accuracy.</li>
        </ul>

        <h2 class="text-2xl font-bold text-navy mb-6 mt-10">Trusted By Industries</h2>
        <p class="text-gray-700 leading-relaxed">
            From healthcare to logistics, our platform scales to meet the rigorous demands of enterprise and government-level operations, offering both flexible subscription models and permanent lifetime licenses for complete ownership.
        </p>
    </div>
</div>
@endsection
