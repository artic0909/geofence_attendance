@extends('superadmin.layouts.app')
@section('header_title', 'Create Employee')

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
        <h1 class="text-3xl font-bold text-gray-800">New Employee</h1>
        <p class="text-gray-600 mt-1">Add a new staff member and assign them to sites.</p>
    </div>
    <a href="{{ route('superadmin.organizations.employees.index', $org->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Directory
    </a>
</div>

<form action="{{ route('superadmin.organizations.employees.store', $org->id) }}" method="POST" id="employeeForm" class="space-y-8 max-w-5xl validate-form">
    @csrf
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-navy">Personal Details</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" data-rule-required="true" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('name') }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" data-rule-required="true" data-rule-email="true" autocomplete="off" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('email') }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" data-rule-required="true" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('phone') }}">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="employee_id">Employee ID <span class="text-red-500">*</span></label>
                    <input type="text" name="employee_id" id="employee_id" data-rule-required="true" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all" value="{{ old('employee_id') }}">
                    @error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="department_id">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" id="department_id" data-rule-required="true" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg select2">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="designation_id">Designation <span class="text-red-500">*</span></label>
                    <select name="designation_id" id="designation_id" data-rule-required="true" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg select2">
                        <option value="">Select Designation</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
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
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="password" data-rule-required="true" autocomplete="new-password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all pr-12">
                        <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-navy toggle-password" data-target="password">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirm Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" data-rule-required="true" autocomplete="new-password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-saffron focus:border-saffron outline-none transition-all pr-12">
                        <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-navy toggle-password" data-target="password_confirmation">
                            <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
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
                    <p class="text-sm text-orange-700 mt-1">You must <a href="{{ route('superadmin.organizations.geofences.create', $org->id) }}" class="font-bold underline">create a geofence</a> before you can assign one.</p>
                </div>
            </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-100">
                <label class="flex items-center cursor-pointer mb-4">
                    <input type="checkbox" name="phone_used_restricted" value="1" {{ old('phone_used_restricted') ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-navy focus:ring focus:ring-navy focus:ring-opacity-20">
                    <span class="ml-3 text-sm font-bold text-gray-700">Phone Use Restricted</span>
                </label>
                
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('.toggle-password').click(function() {
            var targetId = $(this).data('target');
            var input = $('#' + targetId);
            var icon = $(this).find('svg');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>');
            } else {
                input.attr('type', 'password');
                icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>');
            }
        });

        $('#employeeForm').submit(function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();
            if (password || confirmPassword) {
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Passwords Mismatch',
                        text: 'Password and Confirm Password must match.',
                        confirmButtonColor: '#1a2639'
                    });
                }
            }
        });
    });
</script>
@endpush