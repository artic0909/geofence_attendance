@extends('superadmin.layouts.guest')

@section('title', 'Superadmin Login')

@section('content')
<div class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cover bg-center bg-no-repeat overflow-hidden" style="background-image: url('{{ asset('world-map-bg.png') }}');">
    <!-- Dark/Navy Overlay -->
    <div class="absolute inset-0 bg-navy/90 sm:bg-navy/80 z-0 mix-blend-multiply"></div>
    
    <div class="max-w-md w-full space-y-8 z-10 relative bg-white/10 backdrop-blur-xl p-10 rounded-2xl shadow-2xl border border-white/20">
        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold text-white tracking-tight">
                Platform Administration
            </h2>
            <p class="mt-3 text-center text-sm text-gray-300 uppercase tracking-widest font-semibold">
                Superadmin Portal
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('superadmin.login.submit') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-1">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-4 py-3 bg-white/5 border border-white/20 rounded-xl shadow-sm placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-saffron focus:border-transparent transition-all sm:text-sm @error('email') border-red-400 focus:ring-red-500 @enderror" placeholder="admin@platform.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400 font-medium" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-4 py-3 bg-white/5 border border-white/20 rounded-xl shadow-sm placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-saffron focus:border-transparent transition-all sm:text-sm" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 bg-white/10 border-white/20 rounded text-saffron focus:ring-saffron">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-300">
                        Remember me
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-navy bg-saffron hover:bg-orange-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-saffron transition-all duration-200 shadow-lg hover:shadow-saffron/50">
                    Secure Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
