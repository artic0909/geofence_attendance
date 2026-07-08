@extends('layouts.public')

@section('meta_title', 'Pricing & Plans | Geofencing Employee Attendance Software | ProjectAttendance.com')
@section('meta_description', 'Flexible SaaS and lifetime license pricing for our enterprise-grade geofence location-based employee attendance system. Scale your workforce management effortlessly.')
@section('meta_keywords', 'attendance system pricing, geofencing software cost, employee tracking subscription, lifetime license attendance app, projectattendance.com')


@section('title', 'Subscription Plans - Geofence Attendance Portal')

@section('content')
<div class="bg-gray-100 border-b border-gray-300 py-2.5">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-blue-800 hover:text-blue-900 hover:underline font-medium">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-1 text-gray-400">»</span>
                        <span class="ml-1 text-gray-800 font-medium md:ml-2">Pricing</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-navy py-12 border-b-4 border-saffron">
    <div class="container mx-auto px-4 text-center">
        
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Pricing & Subscription Models</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Scale at your own pace with our flexible multi-tenant SaaS plans, or take complete ownership with a Lifetime License.</p>
    </div>
</div>

<section class="py-16 md:py-24 bg-lightbg">
    <div class="container mx-auto px-4 max-w-7xl">
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
                            <label for="employee_count" class="block text-sm font-bold text-gray-700 mb-3">2. Number of Employees</label>
                            <input type="number" id="employee_count" min="10" value="10" class="block w-full text-2xl font-bold text-center border-gray-300 rounded-md shadow-sm focus:ring-saffron focus:border-saffron py-3 bg-gray-50">
                            <p class="text-xs text-gray-500 mt-2 text-center">Minimum 10 employees recommended.</p>
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
                                <span>Employee Cost <span id="display_employee_calc" class="text-xs">(10 x ₹0.00)</span>:</span>
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
                        
                        <a href="{{ route('register') }}" id="btn_buy_now" class="w-full py-4 rounded text-center text-white bg-navy font-bold hover:bg-blue-900 transition-all shadow-lg transform hover:-translate-y-1 relative z-10 flex items-center justify-center">
                            Proceed to Register & Buy
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const durationBtns = document.querySelectorAll('.duration-btn');
                const employeeInput = document.getElementById('employee_count');
                
                const displayBase = document.getElementById('display_base_price');
                const displayEmpCalc = document.getElementById('display_employee_calc');
                const displayEmpTotal = document.getElementById('display_employee_total');
                const displayTotal = document.getElementById('display_total_price');
                
                let activePlan = null;
                
                if(durationBtns.length > 0) {
                    // Init with first plan
                    setActivePlan(durationBtns[0]);
                }
                
                durationBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Update UI
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
                        basePrice: parseFloat(btn.getAttribute('data-base-price')),
                        perEmployee: parseFloat(btn.getAttribute('data-per-employee')),
                        isTrial: btn.getAttribute('data-is-trial') === 'true'
                    };
                    calculateTotal();
                }
                
                function calculateTotal() {
                    if(!activePlan) return;
                    
                    let count = parseInt(employeeInput.value) || 0;
                    if(count < 0) count = 0;
                    
                    // Update button link
                    const btnBuyNow = document.getElementById('btn_buy_now');
                    btnBuyNow.href = `{{ route('register') }}?plan_id=${activePlan.id}&employees=${count}`;
                    
                    // If it's a trial, enforce 0 price
                    if(activePlan.isTrial) {
                        displayBase.innerText = "₹0.00 (Trial)";
                        displayEmpCalc.innerText = `(${count} Employees)`;
                        displayEmpTotal.innerText = "₹0.00";
                        displayTotal.innerText = "₹0.00";
                        return;
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
            });
        </script>

        <!-- Permanent Tier -->
        <div class="border-2 border-saffron rounded-xl p-8 md:p-12 max-w-5xl mx-auto shadow-xl text-center relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-color: white; background-image: url('{{ asset('world-map-bg.png') }}');">
            <div class="absolute top-0 left-0 w-full h-2 bg-saffron"></div>
            <div class="inline-block px-4 py-1 rounded bg-orange-100 text-saffron text-sm font-bold uppercase tracking-widest mb-4">
                Enterprise Ownership
            </div>
            <h4 class="text-3xl md:text-4xl font-bold text-navy mb-4">Lifetime / Permanent License</h4>
            <p class="text-gray-600 mb-8 text-lg max-w-3xl mx-auto">Don't want to pay SaaS subscription fees forever? Purchase the fully-developed, production-ready software and mobile app entirely.</p>
            
            <div class="flex flex-col md:flex-row justify-center items-start md:items-center gap-8 mb-10 text-left max-w-3xl mx-auto">
                <div class="flex items-start bg-lightbg p-4 rounded-lg flex-1">
                    <svg class="w-8 h-8 text-saffron mr-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <div>
                        <h5 class="font-bold text-navy text-lg mb-1">Source Code Access</h5>
                        <p class="text-sm text-gray-600">Full ownership of backend logic, APIs, and frontend codebases.</p>
                    </div>
                </div>
                <div class="flex items-start bg-lightbg p-4 rounded-lg flex-1">
                    <svg class="w-8 h-8 text-saffron mr-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <div>
                        <h5 class="font-bold text-navy text-lg mb-1">White-Label Delivery</h5>
                        <p class="text-sm text-gray-600">We deploy it securely under your own brand, logo, and domains.</p>
                    </div>
                </div>
            </div>
            <a href="#" class="inline-block bg-navy text-white px-10 py-4 rounded text-xl font-bold shadow hover:bg-blue-800 transition">Contact Sales for Quote</a>
        </div>
    </div>
</section>
@endsection
