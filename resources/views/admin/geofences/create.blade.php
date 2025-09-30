@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Create Geofence</h2>
    
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.geofences.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                <input type="text" name="name" id="name" required 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">Latitude</label>
                    <input type="text" name="latitude" id="latitude" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           value="{{ old('latitude') }}">
                    @error('latitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">Longitude</label>
                    <input type="text" name="longitude" id="longitude" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           value="{{ old('longitude') }}">
                    @error('longitude')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="radius">Radius (meters)</label>
                <input type="number" name="radius" id="radius" required min="50" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       value="{{ old('radius') }}">
                @error('radius')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                <textarea name="address" id="address" required 
                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">How to get coordinates:</p>
                <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                    <li>Go to <a href="https://www.google.com/maps" target="_blank" class="text-blue-500">Google Maps</a></li>
                    <li>Right-click on your desired location</li>
                    <li>Click "What's here?"</li>
                    <li>Copy the coordinates (latitude, longitude)</li>
                </ol>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Create Geofence
                </button>
            </div>
        </form>
    </div>
</div>
@endsection