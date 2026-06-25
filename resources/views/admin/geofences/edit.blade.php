@extends('admin.layout')
@section('header_title', 'Edit Site (Geofence)')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Site</h1>
        <p class="text-gray-600 mt-1">Update geographical boundaries and details.</p>
    </div>
    <a href="{{ route('admin.geofences.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Sites
    </a>
</div>

<form action="{{ route('admin.geofences.update', $geofence) }}" method="POST" class="space-y-8 max-w-4xl">
    @csrf
    @method('PUT')
    
    <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Site Details</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Site Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('name', $geofence->name) }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="address">Full Address <span class="text-red-500">*</span></label>
                    <textarea name="address" id="address" required rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all">{{ old('address', $geofence->address) }}</textarea>
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="latitude">Latitude <span class="text-red-500">*</span></label>
                    <input type="text" name="latitude" id="latitude" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all font-mono text-sm" value="{{ old('latitude', $geofence->latitude) }}">
                    @error('latitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="longitude">Longitude <span class="text-red-500">*</span></label>
                    <input type="text" name="longitude" id="longitude" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all font-mono text-sm" value="{{ old('longitude', $geofence->longitude) }}">
                    @error('longitude')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="md:col-span-2 bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="text-sm font-bold text-blue-800">How to get coordinates</h4>
                        <ol class="list-decimal list-inside text-sm text-blue-700 mt-1 space-y-1">
                            <li>Open <a href="https://www.google.com/maps" target="_blank" class="font-bold underline hover:text-blue-900">Google Maps</a></li>
                            <li>Right-click on your exact location</li>
                            <li>Click on the coordinates at the top to copy them</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Site Parameters</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="radius">Check-in Radius (meters) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="radius" id="radius" required min="50" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all pr-12" value="{{ old('radius', $geofence->radius) }}">
                        <span class="absolute right-4 top-2.5 text-gray-400 font-medium">m</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">The maximum distance allowed from the center to check in.</p>
                    @error('radius')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="tracking_radius">Tracking Radius (Optional)</label>
                    <div class="relative">
                        <input type="number" name="tracking_radius" id="tracking_radius" min="0" placeholder="e.g. 500" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all pr-12" value="{{ old('tracking_radius', $geofence->tracking_radius) }}">
                        <span class="absolute right-4 top-2.5 text-gray-400 font-medium">m</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty if outside tracking is disabled.</p>
                    @error('tracking_radius')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $geofence->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-navy focus:ring focus:ring-navy focus:ring-opacity-20">
                    <span class="ml-3 text-sm font-bold text-gray-700">Site is Active</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-2 pb-16 space-x-4">
        <a href="{{ route('admin.geofences.index') }}" class="px-6 py-3 bg-white text-gray-700 border border-gray-300 font-bold rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-300">
            Cancel
        </a>
        <button type="submit" class="px-8 py-3 bg-navy text-white font-bold rounded-xl shadow-lg hover:bg-[#233554] transition-all duration-300 transform hover:-translate-y-1 flex items-center">
            <svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Update Geofence
        </button>
    </div>
</form>
@endsection