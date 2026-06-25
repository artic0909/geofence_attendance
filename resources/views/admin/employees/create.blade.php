@extends('admin.layout')
@section('header_title', 'Create Employee')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">New Employee</h1>
        <p class="text-gray-600 mt-1">Add a new staff member and assign them to sites.</p>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Directory
    </a>
</div>

<form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-8 max-w-5xl">
    @csrf
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Personal Details</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('name') }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('email') }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('phone') }}">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="employee_id">Employee ID <span class="text-red-500">*</span></label>
                    <input type="text" name="employee_id" id="employee_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('employee_id') }}">
                    @error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Security Settings</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Site Assignment</h2>
        </div>
        <div class="p-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">Assign Geofences <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto border border-gray-200 rounded-xl p-4 bg-gray-50/30">
                @foreach($geofences as $geofence)
                <label class="flex items-center space-x-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-saffron cursor-pointer transition-colors shadow-sm">
                    <input type="checkbox" name="geofences[]" value="{{ $geofence->id }}" class="w-4 h-4 rounded border-gray-300 text-navy focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-20 cursor-pointer">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-800">{{ $geofence->name }}</span>
                        <span class="text-xs text-gray-500">{{ $geofence->radius }}m Radius</span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('geofences')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
            
            @if($geofences->isEmpty())
            <div class="mt-4 p-4 rounded-lg bg-orange-50 border border-orange-200 flex items-start">
                <svg class="w-5 h-5 text-orange-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h3 class="text-sm font-medium text-orange-800">No sites available</h3>
                    <p class="text-sm text-orange-700 mt-1">You must <a href="{{ route('admin.geofences.create') }}" class="font-bold underline">create a geofence</a> before you can assign one.</p>
                </div>
            </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-100">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-navy focus:ring focus:ring-navy focus:ring-opacity-20">
                    <span class="ml-3 text-sm font-bold text-gray-700">Account is Active</span>
                </label>
                <p class="text-xs text-gray-500 ml-8 mt-1">If unchecked, the employee will not be able to log in or check in.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-2 pb-16">
        <button type="submit" class="px-8 py-3 bg-navy text-white font-bold rounded-xl shadow-lg hover:bg-[#233554] transition-all duration-300 transform hover:-translate-y-1 flex items-center">
            <svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Create Employee
        </button>
    </div>
</form>
@endsection