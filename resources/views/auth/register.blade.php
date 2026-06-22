@extends('layouts.public')

@section('title', 'Register | Geofence Attendance Portal')

@section('content')
<div class="hero-bg min-h-[calc(100vh-100px)] py-12 px-4 sm:px-6 lg:px-8 bg-cover bg-center">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden border-t-4 border-navy">
        <div class="px-8 py-10">
            <div class="border-b border-gray-200 pb-6 mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Register Your Business</h2>
                <p class="text-gray-600 mt-2">Please provide all required details to register your business with us</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-md">
                    <div class="flex items-center mb-2">
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold text-red-700">Please fix the following errors:</p>
                    </div>
                    <ul class="list-disc pl-5 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-8">
                @csrf
                
                <!-- Business Owner -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Business Owner <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <input type="text" name="first_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('first_name') }}">
                            <p class="text-xs text-gray-500 mt-1">First Name</p>
                        </div>
                        <div>
                            <input type="text" name="last_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('last_name') }}">
                            <p class="text-xs text-gray-500 mt-1">Last Name</p>
                        </div>
                    </div>
                </div>

                <!-- Business Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Business Name <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2">
                        <input type="text" name="business_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('business_name') }}">
                    </div>
                </div>

                <!-- GST Number -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">GST Number</label>
                    <div class="md:col-span-2">
                        <input type="text" name="gst_number" class="block w-full sm:w-2/3 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('gst_number') }}" placeholder="(Optional)">
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Contact Number <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2">
                        <input type="text" name="phone" required class="block w-full sm:w-1/2 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('phone') }}">
                    </div>
                </div>

                <!-- Email -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">E-mail <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2">
                        <input type="email" name="email" required placeholder="ex: myname@example.com" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('email') }}">
                        <p class="text-xs text-gray-500 mt-1">example@example.com</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Address <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <input type="text" name="address_line_1" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('address_line_1') }}">
                            <p class="text-xs text-gray-500 mt-1">Street Address</p>
                        </div>
                        <div>
                            <input type="text" name="address_line_2" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('address_line_2') }}">
                            <p class="text-xs text-gray-500 mt-1">Street Address Line 2</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="text" name="city" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('city') }}">
                                <p class="text-xs text-gray-500 mt-1">City</p>
                            </div>
                            <div>
                                <input type="text" name="state" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('state') }}">
                                <p class="text-xs text-gray-500 mt-1">State / Province</p>
                            </div>
                        </div>
                        <div>
                            <input type="text" name="zip_code" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('zip_code') }}">
                            <p class="text-xs text-gray-500 mt-1">Postal / Zip Code</p>
                        </div>
                    </div>
                </div>

                <!-- Type of Business -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8" id="business-type-container">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Type of Business <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2">
                        <select name="business_type" id="business_type" required class="block w-full sm:w-2/3 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border bg-white">
                            <option value="">Select an option</option>
                            <option value="Others" {{ old('business_type') == 'Others' ? 'selected' : '' }}>Others, please specify below.</option>
                            <option value="IT Services" {{ old('business_type') == 'IT Services' ? 'selected' : '' }}>IT Services</option>
                            <option value="Manufacturing" {{ old('business_type') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Retail" {{ old('business_type') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Healthcare" {{ old('business_type') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Education" {{ old('business_type') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Construction" {{ old('business_type') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Logistics" {{ old('business_type') == 'Logistics' ? 'selected' : '' }}>Logistics</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Business</p>
                    </div>
                </div>

                <!-- Others Business Type (Hidden by default) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start hidden" id="other_business_type_row">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Others <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2">
                        <input type="text" name="other_business_type" id="other_business_type" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border" value="{{ old('other_business_type') }}">
                    </div>
                </div>

                <!-- Account Security -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                    <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Account Security <span class="text-red-500">*</span></label>
                    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <input type="password" name="password" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border">
                            <p class="text-xs text-gray-500 mt-1">Password</p>
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border">
                            <p class="text-xs text-gray-500 mt-1">Confirm Password</p>
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex justify-end border-t border-gray-200">
                    <button type="submit" class="bg-navy text-white px-8 py-3 rounded text-lg font-bold shadow hover:bg-blue-800 transition-colors">
                        Submit Registration
                    </button>
                </div>
            </form>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                Already registered?
                <a href="{{ route('login') }}" class="font-bold text-navy hover:text-blue-900 transition-colors">Sign in here</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const businessTypeSelect = document.getElementById('business_type');
        const otherBusinessTypeRow = document.getElementById('other_business_type_row');
        const otherBusinessTypeInput = document.getElementById('other_business_type');

        function toggleOtherField() {
            if (businessTypeSelect.value === 'Others') {
                otherBusinessTypeRow.classList.remove('hidden');
                otherBusinessTypeInput.setAttribute('required', 'required');
            } else {
                otherBusinessTypeRow.classList.add('hidden');
                otherBusinessTypeInput.removeAttribute('required');
                otherBusinessTypeInput.value = '';
            }
        }

        // Run on load to handle old input correctly
        toggleOtherField();

        businessTypeSelect.addEventListener('change', toggleOtherField);
    });
</script>
@endpush
@endsection