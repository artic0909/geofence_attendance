@extends('layouts.public')

@section('title', 'Contact Us - Geofence Attendance')

@section('content')
<!-- Page Header (Optional Breadcrumb style like pricing) -->
<div class="bg-gray-100 border-b border-gray-300 py-2.5 relative z-20">
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
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">Contact Us</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="relative min-h-[calc(100vh-140px)] flex items-center justify-center py-12 px-4 overflow-hidden">
    <!-- Video Background -->
    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0 pointer-events-none">
        <source src="{{ asset('videos/big-hero.mp4') }}" type="video/mp4">
    </video>
    <!-- Dark Overlay for Readability -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <!-- Centered Form Container -->
    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl p-8 md:p-10 border border-gray-100">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center p-3 bg-navy/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-navy mb-2">Let's Connect</h2>
                <p class="text-gray-600 text-sm">Have questions? Send us a message and we'll respond promptly.</p>
            </div>
            
            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="John Doe" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-navy focus:border-navy transition" required>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@company.com" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-navy focus:border-navy transition" required>
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="How can we help?" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-navy focus:border-navy transition" required>
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4" placeholder="Tell us more about your needs..." class="block w-full border border-gray-300 rounded-lg shadow-sm py-2.5 px-4 focus:ring-navy focus:border-navy transition resize-none" required></textarea>
                </div>
                
                <button type="submit" class="w-full bg-navy text-white font-bold py-3.5 px-6 rounded-lg shadow-md hover:bg-blue-900 hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
