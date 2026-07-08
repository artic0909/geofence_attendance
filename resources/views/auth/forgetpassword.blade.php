@extends('layouts.public')

@section('title', 'Forgot Password | Geofence Attendance Portal')

@section('content')
<div class="min-h-[calc(100vh-100px)] flex flex-col items-center justify-center bg-gray-50 p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-saffron relative">
        
        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex-col items-center justify-center hidden">
            <svg class="animate-spin h-10 w-10 text-saffron mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-navy font-semibold text-sm animate-pulse">Processing...</p>
        </div>

        <div class="p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-navy/10 mb-4 text-navy">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h2 id="stepTitle" class="text-3xl font-bold text-navy">Reset Password</h2>
                <p id="stepDescription" class="text-gray-500 mt-2 text-sm">Enter your email to receive an OTP.</p>
            </div>

            <!-- Error/Success Alert Box -->
            <div id="alertBox" class="hidden mb-6 p-4 rounded-md border-l-4">
                <p id="alertMessage" class="text-sm font-medium"></p>
            </div>

            <!-- STEP 1: Email Form -->
            <form id="step1Form" class="space-y-6" onsubmit="sendOtp(event)">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input id="email" name="email" type="email" required class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron sm:text-sm px-4 py-3 border bg-gray-50 transition-colors" placeholder="admin@example.com">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-sm font-bold text-white bg-navy hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-all duration-200 transform hover:-translate-y-0.5">
                        Send OTP
                    </button>
                </div>
            </form>

            <!-- STEP 2: Verify OTP Form -->
            <form id="step2Form" class="space-y-6 hidden" onsubmit="verifyOtp(event)">
                @csrf
                <div>
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-1">6-Digit OTP</label>
                    <div class="relative">
                        <input id="otp" name="otp" type="text" maxlength="6" pattern="\d{6}" required class="block w-full text-center tracking-widest text-xl font-bold border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron px-4 py-3 border bg-gray-50 transition-colors" placeholder="••••••">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-sm font-bold text-white bg-navy hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-all duration-200 transform hover:-translate-y-0.5">
                        Verify OTP
                    </button>
                </div>
                <div class="text-center mt-4">
                    <button type="button" onclick="sendOtp(event, true)" class="text-xs font-semibold text-saffron hover:text-orange-600 transition-colors">Didn't receive code? Resend</button>
                </div>
            </form>

            <!-- STEP 3: Reset Password Form -->
            <form id="step3Form" class="space-y-6 hidden" onsubmit="resetPassword(event)">
                @csrf
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" name="password" type="password" required minlength="8" class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron sm:text-sm px-4 py-3 border bg-gray-50 transition-colors" placeholder="••••••••">
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron sm:text-sm px-4 py-3 border bg-gray-50 transition-colors" placeholder="••••••••">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-sm font-bold text-white bg-navy hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-all duration-200 transform hover:-translate-y-0.5">
                        Set New Password
                    </button>
                </div>
            </form>

        </div>
        
        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}" class="font-bold text-saffron hover:text-orange-600 transition-colors">Back to Login</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentEmail = '';
    let currentOtp = '';

    const step1Form = document.getElementById('step1Form');
    const step2Form = document.getElementById('step2Form');
    const step3Form = document.getElementById('step3Form');
    
    const stepTitle = document.getElementById('stepTitle');
    const stepDescription = document.getElementById('stepDescription');
    
    const loadingOverlay = document.getElementById('loadingOverlay');
    const alertBox = document.getElementById('alertBox');
    const alertMessage = document.getElementById('alertMessage');

    function showLoading() {
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');
    }

    function hideLoading() {
        loadingOverlay.classList.add('hidden');
        loadingOverlay.classList.remove('flex');
    }

    function showAlert(message, type = 'error') {
        alertBox.classList.remove('hidden', 'bg-red-50', 'border-red-500', 'text-red-700', 'bg-green-50', 'border-green-500', 'text-green-700');
        if (type === 'error') {
            alertBox.classList.add('bg-red-50', 'border-red-500', 'text-red-700');
        } else {
            alertBox.classList.add('bg-green-50', 'border-green-500', 'text-green-700');
        }
        alertMessage.innerText = message;
    }

    function hideAlert() {
        alertBox.classList.add('hidden');
    }

    async function sendOtp(e, isResend = false) {
        if(e) e.preventDefault();
        
        const email = document.getElementById('email').value;
        if (!email) return showAlert('Please enter your email address.');

        currentEmail = email;
        hideAlert();
        showLoading();

        try {
            const response = await fetch('{{ route("password.email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: currentEmail })
            });
            const data = await response.json();
            hideLoading();

            if (response.ok) {
                showAlert(data.message, 'success');
                if(!isResend) {
                    step1Form.classList.add('hidden');
                    step2Form.classList.remove('hidden');
                    stepTitle.innerText = "Verify OTP";
                    stepDescription.innerText = `We sent a 6-digit code to ${currentEmail}`;
                }
            } else {
                showAlert(data.message || data.errors?.email?.[0] || 'An error occurred.');
            }
        } catch (error) {
            hideLoading();
            showAlert('A network error occurred. Please try again.');
        }
    }

    async function verifyOtp(e) {
        e.preventDefault();
        
        const otp = document.getElementById('otp').value;
        if (!otp || otp.length !== 6) return showAlert('Please enter a valid 6-digit OTP.');

        currentOtp = otp;
        hideAlert();
        showLoading();

        try {
            const response = await fetch('{{ route("password.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: currentEmail, otp: currentOtp })
            });
            const data = await response.json();
            hideLoading();

            if (response.ok) {
                showAlert(data.message, 'success');
                step2Form.classList.add('hidden');
                step3Form.classList.remove('hidden');
                stepTitle.innerText = "Set New Password";
                stepDescription.innerText = "Please enter a strong new password.";
            } else {
                showAlert(data.message || data.errors?.otp?.[0] || 'An error occurred.');
            }
        } catch (error) {
            hideLoading();
            showAlert('A network error occurred. Please try again.');
        }
    }

    async function resetPassword(e) {
        e.preventDefault();
        
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        if (password !== password_confirmation) {
            return showAlert('Passwords do not match.');
        }

        hideAlert();
        showLoading();

        try {
            const response = await fetch('{{ route("password.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    email: currentEmail, 
                    otp: currentOtp,
                    password: password,
                    password_confirmation: password_confirmation
                })
            });
            const data = await response.json();
            hideLoading();

            if (response.ok) {
                showAlert(data.message, 'success');
                step3Form.classList.add('hidden');
                stepTitle.innerText = "Success!";
                stepDescription.innerText = "Your password has been successfully reset.";
                
                // Redirect to login after 2 seconds
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 2000);
            } else {
                showAlert(data.message || data.errors?.password?.[0] || 'An error occurred.');
            }
        } catch (error) {
            hideLoading();
            showAlert('A network error occurred. Please try again.');
        }
    }
</script>
@endpush
@endsection
