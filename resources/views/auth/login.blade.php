@extends('layouts.public')

@section('title', 'Login | Geofence Attendance Portal')

@section('content')
<div class="min-h-[calc(100vh-100px)] flex flex-col md:flex-row bg-gray-50">
    <!-- Left side: Form -->
    <div class="w-full md:w-1/2 lg:w-[45%] flex items-center justify-center p-8 lg:p-12 relative z-10">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-saffron">
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-navy/10 mb-4">
                        <svg class="w-8 h-8 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-navy">Portal Login</h2>
                    <p class="text-gray-500 mt-2 text-sm">Secure access to your organization's dashboard</p>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-md">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron sm:text-sm px-4 py-3 border bg-gray-50 transition-colors" placeholder="admin@example.com" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#" class="text-xs font-semibold text-saffron hover:text-orange-600 transition-colors">Forgot Password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron sm:text-sm px-4 py-3 border bg-gray-50 transition-colors" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-saffron focus:ring-saffron border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-sm font-bold text-white bg-navy hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-all duration-200 transform hover:-translate-y-0.5">
                            Sign In Securely
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    New to the platform?
                    <a href="{{ route('register') }}" class="font-bold text-saffron hover:text-orange-600 transition-colors">Create an Organization</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right side: Map Illustration / Hero -->
    <div class="hidden md:flex w-full md:w-1/2 lg:w-[55%] bg-navy relative items-center justify-center overflow-hidden">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-navy opacity-90 z-0"></div>
        <div class="absolute inset-0 hero-bg opacity-30 z-0 mix-blend-overlay"></div>
        
        <div class="relative z-10 w-full max-w-xl px-12 text-center">
            <!-- Animated Radar / Map Element -->
            <div class="relative w-64 h-64 mx-auto mb-10 flex items-center justify-center">
                <div class="absolute w-full h-full border-2 border-saffron rounded-full opacity-20 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]"></div>
                <div class="absolute w-3/4 h-3/4 border-2 border-saffron rounded-full opacity-40 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]" style="animation-delay: 1s;"></div>
                <div class="absolute w-1/2 h-1/2 border-2 border-saffron rounded-full opacity-60 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]" style="animation-delay: 2s;"></div>
                
                <div class="absolute w-full h-full animate-[spin_10s_linear_infinite]">
                    <div class="w-1/2 h-1/2 border-r-2 border-t-2 border-saffron/30 rounded-tr-full origin-bottom-left"></div>
                </div>

                <div class="w-20 h-20 bg-saffron rounded-full flex items-center justify-center z-10 shadow-[0_0_30px_rgba(255,153,51,0.6)] relative">
                    <svg class="w-10 h-10 text-white animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <!-- Small pulsating dot -->
                    <div class="absolute -bottom-1 w-3 h-3 bg-white rounded-full animate-ping"></div>
                </div>

                <!-- Floating Pins -->
                <div class="absolute top-10 left-10 w-4 h-4 bg-green rounded-full shadow-lg border-2 border-white animate-pulse"></div>
                <div class="absolute bottom-12 right-12 w-4 h-4 bg-saffron rounded-full shadow-lg border-2 border-white animate-pulse" style="animation-delay: 0.5s;"></div>
                <div class="absolute top-1/2 left-4 w-3 h-3 bg-blue-400 rounded-full shadow-lg border-2 border-white animate-pulse" style="animation-delay: 1.5s;"></div>
            </div>

            <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                Centralized Workforce Management
            </h2>
            <p class="text-lg md:text-xl text-blue-100 font-light">
                Track, manage, and optimize your field workforce with precision geofencing. Monitor attendance in real-time from anywhere in the world.
            </p>
        </div>
    </div>
</div>
@endsection