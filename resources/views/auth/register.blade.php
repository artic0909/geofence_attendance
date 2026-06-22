@extends('layouts.public')

@section('title', 'Register | Geofence Attendance Portal')

@section('content')
<div class="min-h-[calc(100vh-100px)] flex flex-col xl:flex-row bg-gray-50">
    <!-- Left side: Form -->
    <div class="w-full xl:w-3/5 flex justify-center p-4 sm:p-8 lg:p-12 relative z-10">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-navy self-start">
            <div class="px-6 py-8 sm:px-10 sm:py-10">
                <div class="border-b border-gray-200 pb-6 mb-8 flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Register Your Business</h2>
                        <p class="text-gray-600 mt-2">Please provide all required details to register your business with us</p>
                    </div>
                    <div class="hidden sm:flex inline-flex items-center justify-center w-16 h-16 rounded-full bg-navy/10">
                        <svg class="w-8 h-8 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
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
                                <input type="text" name="first_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('first_name') }}">
                                <p class="text-xs text-gray-500 mt-1">First Name</p>
                            </div>
                            <div>
                                <input type="text" name="last_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('last_name') }}">
                                <p class="text-xs text-gray-500 mt-1">Last Name</p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Name -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Business Name <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2">
                            <input type="text" name="business_name" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('business_name') }}">
                        </div>
                    </div>

                    <!-- GST Number -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">GST Number</label>
                        <div class="md:col-span-2">
                            <input type="text" name="gst_number" class="block w-full sm:w-2/3 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('gst_number') }}" placeholder="(Optional)">
                        </div>
                    </div>

                    <!-- Contact Number -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Contact Number <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2">
                            <input type="text" name="phone" required class="block w-full sm:w-1/2 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">E-mail <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2">
                            <input type="email" name="email" required placeholder="ex: myname@example.com" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('email') }}">
                            <p class="text-xs text-gray-500 mt-1">example@example.com</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Address <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <input type="text" name="address_line_1" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('address_line_1') }}">
                                <p class="text-xs text-gray-500 mt-1">Street Address</p>
                            </div>
                            <div>
                                <input type="text" name="address_line_2" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('address_line_2') }}">
                                <p class="text-xs text-gray-500 mt-1">Street Address Line 2</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="city" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('city') }}">
                                    <p class="text-xs text-gray-500 mt-1">City</p>
                                </div>
                                <div>
                                    <input type="text" name="state" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('state') }}">
                                    <p class="text-xs text-gray-500 mt-1">State / Province</p>
                                </div>
                            </div>
                            <div>
                                <input type="text" name="zip_code" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('zip_code') }}">
                                <p class="text-xs text-gray-500 mt-1">Postal / Zip Code</p>
                            </div>
                        </div>
                    </div>

                    <!-- Type of Business -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8" id="business-type-container">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Type of Business <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2">
                            <select name="business_type" id="business_type" required class="block w-full sm:w-2/3 border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border bg-white transition-colors">
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
                            <input type="text" name="other_business_type" id="other_business_type" class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors" value="{{ old('other_business_type') }}">
                        </div>
                    </div>

                    <!-- Account Security -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-8">
                        <label class="block text-gray-800 font-semibold md:text-right md:pt-2">Account Security <span class="text-red-500">*</span></label>
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="password" name="password" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors">
                                <p class="text-xs text-gray-500 mt-1">Password</p>
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" required class="block w-full border-gray-300 rounded shadow-sm focus:ring-navy focus:border-navy sm:text-sm px-3 py-2 border transition-colors">
                                <p class="text-xs text-gray-500 mt-1">Confirm Password</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 flex justify-end border-t border-gray-200">
                        <button type="submit" class="bg-navy text-white px-8 py-3 rounded text-lg font-bold shadow hover:bg-blue-800 transition-all duration-200 transform hover:-translate-y-0.5">
                            Submit Registration
                        </button>
                    </div>
                </form>
            </div>
            <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 text-center sm:px-10">
                <p class="text-sm text-gray-600">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-bold text-navy hover:text-blue-900 transition-colors">Sign in here</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Right side: Map Illustration / Hero -->
    <div class="hidden xl:flex w-full xl:w-2/5 bg-navy relative items-center justify-center overflow-hidden fixed right-0 h-[calc(100vh-100px)]">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <!-- Small pulsating dot -->
                    <div class="absolute -bottom-1 w-3 h-3 bg-white rounded-full animate-ping"></div>
                </div>

                <!-- Floating Pins -->
                <div class="absolute top-10 left-10 w-4 h-4 bg-green rounded-full shadow-lg border-2 border-white animate-pulse"></div>
                <div class="absolute bottom-12 right-12 w-4 h-4 bg-saffron rounded-full shadow-lg border-2 border-white animate-pulse" style="animation-delay: 0.5s;"></div>
                <div class="absolute top-1/2 left-4 w-3 h-3 bg-blue-400 rounded-full shadow-lg border-2 border-white animate-pulse" style="animation-delay: 1.5s;"></div>
            </div>

            <h2 class="text-4xl font-extrabold text-white mb-6 leading-tight">
                Global Attendance System
            </h2>
            <p class="text-lg text-blue-100 font-light">
                Join hundreds of organizations managing their workforce seamlessly across multiple locations.
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