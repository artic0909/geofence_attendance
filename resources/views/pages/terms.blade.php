@extends('layouts.public')

@section('title', 'Terms & Conditions - Geofence Attendance Portal')

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
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">Terms & Conditions</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Terms & Conditions</h1>
    </div>
</div>

<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="p-8 md:p-12 rounded-xl shadow-sm border border-gray-200 bg-cover bg-center bg-no-repeat" style="background-color: white; background-image: url('{{ asset('world-map-bg.png') }}');">
        <div class="prose max-w-none text-gray-700">
            <h2 class="text-xl font-bold text-navy mb-4">1. Acceptance of Terms</h2>
            <p class="mb-6">By accessing and using the Official Geofence Attendance Portal, you accept and agree to be bound by the terms and provision of this agreement. In addition, when using these particular services, you shall be subject to any posted guidelines or rules applicable to such services.</p>

            <h2 class="text-xl font-bold text-navy mb-4">2. Description of Service</h2>
            <p class="mb-6">The platform provides a Multi-tenant SaaS Geofence Attendance System that allows organizations to define geographic boundaries and track employee attendance securely. We reserve the right to modify or discontinue the service with or without notice to the user.</p>

            <h2 class="text-xl font-bold text-navy mb-4">3. User Conduct</h2>
            <p class="mb-6">You agree to use the service only for lawful purposes. You are strictly prohibited from spoofing GPS coordinates, tampering with attendance logs, or attempting to breach the secure multi-tenant architecture.</p>

            <h2 class="text-xl font-bold text-navy mb-4">4. Subscriptions and Licensing</h2>
            <p class="mb-6">We offer both SaaS subscriptions (6 months, 1 year, 2 years, 5 years) and a Permanent/Lifetime License. Subscription fees are non-refundable. For the Lifetime License, complete source code and white-label rights are transferred upon full payment.</p>

            <h2 class="text-xl font-bold text-navy mb-4">5. Disclaimer of Warranties</h2>
            <p class="mb-6">The service is provided on an "as is" and "as available" basis. We expressly disclaim all warranties of any kind, whether express or implied, including, but not limited to the implied warranties of merchantability, fitness for a particular purpose and non-infringement.</p>
        </div>
    </div>
</div>
@endsection
