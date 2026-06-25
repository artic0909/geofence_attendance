@extends('superadmin.layouts.app')

@section('title', 'Platform Settings')
@section('header', 'Platform Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">General Settings</h3>
            
            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <label for="platform_name" class="block text-sm font-medium text-gray-700">Platform Name</label>
                        <input type="text" name="platform_name" id="platform_name" value="Geofence Attendance" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Support Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="support@platform.com" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-navy border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
