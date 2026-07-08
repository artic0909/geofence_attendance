@extends('layouts.public')

@section('title', 'Select Subscription Plan | Geofence Attendance Portal')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-navy sm:text-4xl">
                Choose the Right Plan for Your Business
            </h2>
            <p class="mt-4 text-xl text-gray-600">
                You're almost there! Select a subscription plan to access your Organization Panel.
            </p>
        </div>

        @if(session('success'))
            <div class="mt-8 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Custom Plan Calculator -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-saffron mb-16" id="pricing-calculator">
            <div class="p-8 md:p-12">
                <h4 class="text-2xl font-bold text-navy mb-8 text-center">Customize Your Subscription</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Left Column: Inputs -->
                    <div class="space-y-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">1. Select Duration</label>
                            <div class="grid grid-cols-3 gap-3" id="plan-duration-container">
                                @foreach($plans as $plan)
                                    <button type="button" 
                                        class="duration-btn py-3 px-2 border-2 rounded-lg text-center transition-all focus:outline-none {{ $loop->first ? 'border-saffron bg-orange-50 text-saffron font-bold' : 'border-gray-200 text-gray-600 hover:border-gray-300' }}"
                                        data-plan-id="{{ $plan->id }}"
                                        data-plan-name="{{ $plan->name }}"
                                        data-base-price="{{ $plan->price }}"
                                        data-per-employee="{{ $plan->price_per_employee }}"
                                        data-is-trial="{{ $plan->is_trial ? 'true' : 'false' }}">
                                        <span class="block text-lg">{{ $plan->duration_days }}</span>
                                        <span class="block text-xs uppercase">Days</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            @php
                                $minEmployees = max(10, $currentEmployees ?? 0);
                            @endphp
                            <label for="employee_count" class="block text-sm font-bold text-gray-700 mb-3">2. Number of Employees</label>
                            <input type="number" id="employee_count" min="{{ $minEmployees }}" value="{{ $minEmployees }}" class="block w-full text-2xl font-bold text-center border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron py-3 bg-gray-50">
                            <p class="text-xs text-gray-500 mt-2 text-center" id="employee_min_help">
                                @if(isset($currentEmployees) && $currentEmployees > 10)
                                    Minimum {{ $minEmployees }} employees required based on your current staff size.
                                @else
                                    Minimum 10 employees recommended.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Right Column: Calculation & Action -->
                    <div class="bg-gray-50 rounded-xl p-8 border border-gray-100 flex flex-col justify-center relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-navy opacity-5 rounded-full"></div>
                        
                        <div class="space-y-4 mb-8 relative z-10">
                            <div class="flex justify-between items-center text-gray-600 border-b border-gray-200 pb-2">
                                <span>Fixed Base Charge:</span>
                                <span id="display_base_price" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-600 border-b border-gray-200 pb-2">
                                <span>Employee Cost <span id="display_employee_calc" class="text-xs">({{ $minEmployees }} x ₹0.00)</span>:</span>
                                <span id="display_employee_total" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between items-end pt-2">
                                <span class="text-lg font-bold text-navy">Total Value:</span>
                                <div class="text-right">
                                    <span id="display_total_price" class="text-4xl font-extrabold text-saffron block">₹0.00</span>
                                    <span class="text-xs text-gray-500">Excluding GST</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="payButton" class="w-full py-4 rounded text-center text-white bg-navy font-bold hover:bg-blue-900 transition-all shadow-lg transform hover:-translate-y-1 relative z-10 flex items-center justify-center">
                            Proceed to Payment
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const durationBtns = document.querySelectorAll('.duration-btn');
        const employeeInput = document.getElementById('employee_count');
        const payButton = document.getElementById('payButton');
        
        const displayBase = document.getElementById('display_base_price');
        const displayEmpCalc = document.getElementById('display_employee_calc');
        const displayEmpTotal = document.getElementById('display_employee_total');
        const displayTotal = document.getElementById('display_total_price');
        
        const MIN_EMPLOYEES = {{ $minEmployees }};
        let activePlan = null;
        
        // Parse Query Params
        const urlParams = new URLSearchParams(window.location.search);
        const urlPlanId = urlParams.get('plan_id');
        const urlEmployees = urlParams.get('employees');
        
        if (urlEmployees) {
            let parsedEmployees = parseInt(urlEmployees) || MIN_EMPLOYEES;
            employeeInput.value = Math.max(parsedEmployees, MIN_EMPLOYEES);
        }
        
        if(durationBtns.length > 0) {
            let initialBtn = durationBtns[0];
            if (urlPlanId) {
                const foundBtn = Array.from(durationBtns).find(b => b.getAttribute('data-plan-id') === urlPlanId);
                if (foundBtn) {
                    initialBtn = foundBtn;
                }
            }
            
            // visually select
            durationBtns.forEach(b => {
                b.classList.remove('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
                b.classList.add('border-gray-200', 'text-gray-600');
            });
            initialBtn.classList.remove('border-gray-200', 'text-gray-600');
            initialBtn.classList.add('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
            
            setActivePlan(initialBtn);
        }
        
        durationBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                durationBtns.forEach(b => {
                    b.classList.remove('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
                    b.classList.add('border-gray-200', 'text-gray-600');
                });
                this.classList.remove('border-gray-200', 'text-gray-600');
                this.classList.add('border-saffron', 'bg-orange-50', 'text-saffron', 'font-bold');
                
                setActivePlan(this);
            });
        });
        
        employeeInput.addEventListener('input', calculateTotal);
        
        function setActivePlan(btn) {
            activePlan = {
                id: btn.getAttribute('data-plan-id'),
                name: btn.getAttribute('data-plan-name'),
                basePrice: parseFloat(btn.getAttribute('data-base-price')),
                perEmployee: parseFloat(btn.getAttribute('data-per-employee')),
                isTrial: btn.getAttribute('data-is-trial') === 'true'
            };
            calculateTotal();
        }
        
        function calculateTotal() {
            if(!activePlan) return;
            
            let count = parseInt(employeeInput.value) || 0;
            
            // Enforce minimum employee count dynamically
            if (count < MIN_EMPLOYEES) {
                // We shouldn't instantly overwrite their typing if they are clearing the box,
                // but when calculating the price, we will act as if it's the minimum.
                // Or we can just set count = MIN_EMPLOYEES for the math.
                count = MIN_EMPLOYEES;
            }
            
            if(activePlan.isTrial) {
                displayBase.innerText = "₹0.00 (Trial)";
                displayEmpCalc.innerText = `(${count} Employees)`;
                displayEmpTotal.innerText = "₹0.00";
                displayTotal.innerText = "₹0.00";
                payButton.innerText = "Start Free Trial";
                return;
            } else {
                payButton.innerHTML = `Proceed to Payment <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;
            }
            
            const base = activePlan.basePrice;
            const perEmp = activePlan.perEmployee;
            const empTotal = count * perEmp;
            const grandTotal = base + empTotal;
            
            displayBase.innerText = "₹" + base.toLocaleString('en-IN', {minimumFractionDigits: 2});
            displayEmpCalc.innerText = `(${count} x ₹${perEmp})`;
            displayEmpTotal.innerText = "₹" + empTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
            displayTotal.innerText = "₹" + grandTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        }

        // Add blur listener to correct the visual value if they leave it too low
        employeeInput.addEventListener('blur', function() {
            let count = parseInt(this.value) || 0;
            if (count < MIN_EMPLOYEES) {
                this.value = MIN_EMPLOYEES;
                calculateTotal();
            }
        });

        payButton.addEventListener('click', function() {
            if (!activePlan) return;
            
            let count = parseInt(employeeInput.value) || 0;
            if (count < MIN_EMPLOYEES) count = MIN_EMPLOYEES;
            
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Processing...';
            btn.disabled = true;

            fetch('{{ route("pricing.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan_id: activePlan.id,
                    employee_count: count
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_trial) {
                        // Directly verify since it's a trial and no Razorpay is needed. 
                        // Note: Our backend createOrder should probably handle trial directly or return a special flag.
                        // Wait, if it's a trial, maybe it shouldn't open Razorpay.
                    }
                    
                    var options = {
                        "key": data.key,
                        "amount": data.amount,
                        "currency": "INR",
                        "name": "Geofence Attendance",
                        "description": "Subscription for " + activePlan.name,
                        "order_id": data.order_id,
                        "handler": function (response){
                            // Verify Payment
                            fetch('{{ route("pricing.verify") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature,
                                    plan_id: activePlan.id
                                })
                            })
                            .then(res => res.json())
                            .then(resData => {
                                if (resData.success) {
                                    window.location.href = resData.redirect_url;
                                } else {
                                    alert('Payment verification failed. Please contact support.');
                                    btn.innerHTML = originalText;
                                    btn.disabled = false;
                                }
                            });
                        },
                        "prefill": {
                            "name": "{{ Auth::user()->name }}",
                            "email": "{{ Auth::user()->email }}",
                            "contact": "{{ Auth::user()->phone }}"
                        },
                        "theme": {
                            "color": "#1e3a8a"
                        },
                        "modal": {
                            "ondismiss": function() {
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            }
                        }
                    };
                    
                    if (data.amount == 0) {
                        // It's a trial or free!
                        // Let's call verify with a fake payment ID
                        fetch('{{ route("pricing.verify") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: 'FREE_TRIAL',
                                razorpay_order_id: data.order_id,
                                razorpay_signature: 'FREE_TRIAL',
                                plan_id: activePlan.id
                            })
                        }).then(res => res.json()).then(resData => {
                            if (resData.success) {
                                window.location.href = resData.redirect_url;
                            } else {
                                alert('Trial activation failed.');
                                btn.innerHTML = originalText;
                                btn.disabled = false;
                            }
                        });
                    } else {
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    }
                } else {
                    alert('Error initializing payment. ' + data.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    });
</script>
@endpush
@endsection
