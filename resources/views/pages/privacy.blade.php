@extends('layouts.public')

@section('title', 'Privacy Policy - Geofence Attendance Portal')

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
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">Privacy Policy</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Privacy Policy</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="p-8 md:p-12 rounded-xl shadow-sm border border-gray-200 bg-cover bg-center bg-no-repeat" style="background-color: white; background-image: url('{{ asset('world-map-bg.png') }}');">
        <div class="prose max-w-none text-gray-700">
            <p class="mb-6"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

            <h2 class="text-xl font-bold text-navy mb-4">Information We Collect</h2>
            <p class="mb-6">When you use the Geofence Attendance Portal, we securely collect device location data (GPS Lat/Long) exclusively during active working hours as defined by your organization. We also collect basic profile information (Name, Employee ID, Contact Info) required for attendance verification.</p>

            <h2 class="text-xl font-bold text-navy mb-4">How We Use Information</h2>
            <p class="mb-6">Your data is strictly isolated within your organization's multi-tenant database environment. Location data is used solely to verify presence within predefined geofence boundaries (Radius Geofencing) and for live operational tracking as mandated by your employer.</p>

            <h2 class="text-xl font-bold text-navy mb-4">Data Security</h2>
            <p class="mb-6">We implement robust, cryptographically secure logging mechanisms to ensure that attendance data is tamper-proof. We restrict unauthorized access, alteration, disclosure, or destruction of information stored on our servers.</p>

            <h2 class="text-xl font-bold text-navy mb-4">Battery Optimization</h2>
            <p class="mb-6">Our smart tracking system utilizes interval-based background pings (30-60 seconds) rather than continuous active tracking to protect your device's battery life while maintaining accurate compliance records.</p>
        </div>
    </div>
</div>
@endsection
