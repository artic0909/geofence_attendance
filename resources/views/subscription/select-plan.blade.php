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

        <!-- Standard Plan Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 max-w-6xl mx-auto mt-8">
            @foreach($plans as $plan)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border {{ $plan->is_trial ? 'border-gray-200' : 'border-saffron' }} flex flex-col hover:-translate-y-2 transition-transform duration-300">
                <div class="p-8 {{ $plan->is_trial ? 'bg-gray-50 text-gray-800' : 'bg-navy text-white' }} text-center">
                    <h4 class="text-2xl font-bold mb-2">{{ $plan->name }}</h4>
                    <div class="text-sm {{ $plan->is_trial ? 'text-gray-500' : 'text-gray-300' }} mb-4">{{ $plan->duration_days }} Days Access</div>
                    @if($plan->is_trial)
                        <div class="text-4xl font-extrabold text-navy">Free</div>
                    @else
                        @php
                            $baseCardPrice = $plan->price + ($plan->price_per_employee * ($plan->employee_count ?? 10));
                            $gstCardPrice = $baseCardPrice * 0.18;
                            $totalCardPrice = $baseCardPrice + $gstCardPrice;
                        @endphp
                        <div class="text-4xl font-extrabold text-saffron">
                            ₹{{ number_format($totalCardPrice, 2) }}
                        </div>
                        <div class="text-xs {{ $plan->is_trial ? 'text-gray-500' : 'text-gray-300' }} mt-2">Includes {{ $plan->employee_count ?? 10 }} Employees (Base)</div>
                        <div class="text-[10px] {{ $plan->is_trial ? 'text-gray-400' : 'text-gray-400' }} mt-1">+ ₹{{ number_format($gstCardPrice, 2) }} (18% GST)</div>
                    @endif
                </div>
                <div class="p-8 flex-grow">
                    <ul class="space-y-4 mb-8">
                        @php $featuresList = is_array($plan->features) ? $plan->features : explode("\n", $plan->features ?? ''); @endphp
                        @foreach($featuresList as $feature)
                            @if(trim($feature))
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-gray-600 text-sm">{{ trim($feature) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="p-8 pt-0 mt-auto">
                    @php $minEmp = max($plan->employee_count ?? 10, $currentEmployees); @endphp
                    @if($plan->is_trial)
                        <button onclick="window.initiatePayment({{ $plan->id }}, {{ $minEmp }}, '{{ addslashes($plan->name) }}', this)" class="block w-full py-3 rounded text-center border-2 border-navy text-navy font-bold hover:bg-navy hover:text-white transition-colors">Select Plan</button>
                    @else
                        <button onclick="window.initiatePayment({{ $plan->id }}, {{ $minEmp }}, '{{ addslashes($plan->name) }}', this)" class="block w-full py-3 rounded text-center bg-saffron text-white font-bold hover:bg-orange-600 transition-colors shadow-md">Select Plan</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

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
                                @php $firstPaidPlan = true; @endphp
                                @foreach($plans as $plan)
                                    @if($plan->is_trial) @continue @endif
                                    <button type="button" 
                                        class="duration-btn py-3 px-2 border-2 rounded-lg text-center transition-all focus:outline-none {{ $firstPaidPlan ? 'border-saffron bg-orange-50 text-saffron font-bold' : 'border-gray-200 text-gray-600 hover:border-gray-300' }}"
                                        data-plan-id="{{ $plan->id }}"
                                        data-plan-name="{{ $plan->name }}"
                                        data-base-price="{{ $plan->price }}"
                                        data-per-employee="{{ $plan->price_per_employee }}"
                                        data-base-employees="{{ $plan->employee_count ?? 10 }}"
                                        data-is-trial="false">
                                        <span class="block text-lg">{{ $plan->duration_days }}</span>
                                        <span class="block text-xs uppercase">Days</span>
                                    </button>
                                    @php $firstPaidPlan = false; @endphp
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label for="employee_count" class="block text-sm font-bold text-gray-700 mb-3">2. Number of Employees</label>
                            <input type="number" id="employee_count" class="block w-full text-2xl font-bold text-center border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron py-3 bg-gray-50">
                            <p class="text-xs text-gray-500 mt-2 text-center" id="employee_min_help">
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
                                <span>Employee Cost <span id="display_employee_calc" class="text-xs"></span>:</span>
                                <span id="display_employee_total" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-500 text-sm border-b border-gray-200 pb-2">
                                <span>+ 18% GST:</span>
                                <span id="display_gst_amount" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between items-end pt-2">
                                <span class="text-lg font-bold text-navy">Total Value:</span>
                                <div class="text-right">
                                    <span id="display_total_price" class="text-4xl font-extrabold text-saffron block">₹0.00</span>
                                    <span class="text-xs text-gray-500">Including GST</span>
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
        
        const CURRENT_EMPLOYEES = {{ $currentEmployees ?? 0 }};
        let activePlan = null;
        let currentDynamicMin = 10;
        
        // Parse Query Params
        const urlParams = new URLSearchParams(window.location.search);
        const urlPlanId = urlParams.get('plan_id');
        const urlEmployees = urlParams.get('employees');
        
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
            
            setActivePlan(initialBtn, urlEmployees);
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
        
        function setActivePlan(btn, overrideEmployees = null) {
            activePlan = {
                id: btn.getAttribute('data-plan-id'),
                name: btn.getAttribute('data-plan-name'),
                basePrice: parseFloat(btn.getAttribute('data-base-price')),
                perEmployee: parseFloat(btn.getAttribute('data-per-employee')),
                baseEmployees: parseInt(btn.getAttribute('data-base-employees')) || 10,
                isTrial: btn.getAttribute('data-is-trial') === 'true'
            };
            
            currentDynamicMin = Math.max(activePlan.baseEmployees, CURRENT_EMPLOYEES);
            employeeInput.min = currentDynamicMin;
            
            if (CURRENT_EMPLOYEES > activePlan.baseEmployees) {
                document.getElementById('employee_min_help').innerText = `Minimum ${currentDynamicMin} employees required based on your current staff size.`;
            } else {
                document.getElementById('employee_min_help').innerText = `Minimum ${currentDynamicMin} employees recommended for this plan.`;
            }
            
            let val = parseInt(employeeInput.value) || 0;
            if (overrideEmployees) {
                val = parseInt(overrideEmployees);
            }
            if (val < currentDynamicMin) {
                val = currentDynamicMin;
            }
            employeeInput.value = val;
            
            calculateTotal();
        }
        
        function calculateTotal() {
            if(!activePlan) return;
            
            let count = parseInt(employeeInput.value) || 0;
            
            // Enforce minimum employee count dynamically
            if (count < currentDynamicMin) {
                count = currentDynamicMin;
            }
            
            if(activePlan.isTrial) {
                displayBase.innerText = "₹0.00 (Trial)";
                displayEmpCalc.innerText = `(${count} Employees)`;
                displayEmpTotal.innerText = "₹0.00";
                document.getElementById('display_gst_amount').innerText = "₹0.00";
                displayTotal.innerText = "₹0.00";
                payButton.innerText = "Start Free Trial";
                return;
            } else {
                payButton.innerHTML = `Proceed to Payment <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;
            }
            
            const base = activePlan.basePrice;
            const perEmp = activePlan.perEmployee;
            const empTotal = count * perEmp;
            const baseTotal = base + empTotal;
            const gstAmount = baseTotal * 0.18;
            const grandTotal = baseTotal + gstAmount;
            
            displayBase.innerText = "₹" + base.toLocaleString('en-IN', {minimumFractionDigits: 2});
            displayEmpCalc.innerText = `(${count} x ₹${perEmp})`;
            displayEmpTotal.innerText = "₹" + empTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
            document.getElementById('display_gst_amount').innerText = "₹" + gstAmount.toLocaleString('en-IN', {minimumFractionDigits: 2});
            displayTotal.innerText = "₹" + grandTotal.toLocaleString('en-IN', {minimumFractionDigits: 2});
        }

        // Add blur listener to correct the visual value if they leave it too low
        employeeInput.addEventListener('blur', function() {
            let count = parseInt(this.value) || 0;
            if (count < currentDynamicMin) {
                this.value = currentDynamicMin;
                calculateTotal();
            }
        });

        window.initiatePayment = function(planId, employeeCount, planName, btnElement) {
            const originalText = btnElement.innerHTML;
            btnElement.innerHTML = 'Processing...';
            btnElement.disabled = true;

            fetch('{{ route("pricing.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan_id: planId,
                    employee_count: employeeCount
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.is_free) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            confirmButtonColor: '#000080'
                        }).then(() => {
                            window.location.href = data.redirect_url;
                        });
                        return;
                    }
                    var options = {
                        "key": data.key,
                        "amount": data.amount,
                        "currency": "INR",
                        "name": "Geofence Attendance",
                        "description": "Subscription for " + planName,
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
                                    plan_id: planId
                                })
                            })
                            .then(res => res.json())
                            .then(resData => {
                                if (resData.success) {
                                    window.location.href = resData.redirect_url;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Verification Failed',
                                        text: 'Payment verification failed. Please contact support.',
                                        confirmButtonColor: '#000080'
                                    });
                                    btnElement.innerHTML = originalText;
                                    btnElement.disabled = false;
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
                                btnElement.innerHTML = originalText;
                                btnElement.disabled = false;
                            }
                        }
                    };
                    
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Error',
                        text: 'Error initializing payment: ' + data.message,
                        confirmButtonColor: '#000080'
                    });
                    btnElement.innerHTML = originalText;
                    btnElement.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong.',
                    confirmButtonColor: '#000080'
                });
                btnElement.innerHTML = originalText;
                btnElement.disabled = false;
            });
        };

        payButton.addEventListener('click', function() {
            if (!activePlan) return;
            
            let count = parseInt(employeeInput.value) || 0;
            if (count < currentDynamicMin) count = currentDynamicMin;
            
            window.initiatePayment(activePlan.id, count, activePlan.name, this);
        });
    });
</script>
@endpush
@endsection
