@extends('admin.layout')
@section('header_title', 'Edit Employee')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 46px;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background-color: #f9fafb;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #f6c449;
        box-shadow: 0 0 0 2px rgba(246, 196, 73, 0.2);
    }
</style>
@endpush

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Edit Employee</h1>
        <p class="text-gray-600 mt-1">Update staff details and site assignments.</p>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Directory
    </a>
</div>

<form action="{{ route('admin.employees.update', $employee) }}" method="POST" class="space-y-8 max-w-5xl">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Personal Details</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('name', $employee->name) }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('email', $employee->email) }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('phone', $employee->phone) }}">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="employee_id">Employee ID <span class="text-red-500">*</span></label>
                    <input type="text" name="employee_id" id="employee_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('employee_id', $employee->employee_id) }}">
                    @error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg select2">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="designation_id">Designation</label>
                    <select name="designation_id" id="designation_id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg select2">
                        <option value="">Select Designation</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                        @endforeach
                    </select>
                    @error('designation_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Security Settings</h2>
            <p class="text-sm text-gray-500 mt-1">Leave blank if you do not wish to change the password.</p>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">New Password</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all">
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
                    <input type="checkbox" name="geofences[]" value="{{ $geofence->id }}" 
                        {{ $employee->employeeGeofences->contains($geofence->id) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-navy focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-20 cursor-pointer">
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
                <label class="flex items-center cursor-pointer mb-4">
                    <input type="checkbox" name="phone_used_restricted" value="1" {{ old('phone_used_restricted', $employee->phone_used_restricted) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-navy focus:ring focus:ring-navy focus:ring-opacity-20">
                    <span class="ml-3 text-sm font-bold text-gray-700">Phone Use Restricted</span>
                </label>

                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-navy focus:ring focus:ring-navy focus:ring-opacity-20">
                    <span class="ml-3 text-sm font-bold text-gray-700">Account is Active</span>
                </label>
                <p class="text-xs text-gray-500 ml-8 mt-1">If unchecked, the employee will not be able to log in or check in.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-2 pb-16 space-x-4">
        <a href="{{ route('admin.employees.index') }}" class="px-6 py-3 bg-white text-gray-700 border border-gray-300 font-bold rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-300">
            Cancel
        </a>
        <button type="submit" class="px-8 py-3 bg-navy text-white font-bold rounded-xl shadow-lg hover:bg-[#233554] transition-all duration-300 transform hover:-translate-y-1 flex items-center">
            <svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Update Employee
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
@endpush