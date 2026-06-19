@extends('layouts.public')

@section('title', 'Privacy Policy - Geofence Attendance Portal')

@section('content')
<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Privacy Policy</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="bg-white p-8 md:p-12 rounded-xl shadow-sm border border-gray-200">
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
