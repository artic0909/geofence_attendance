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

        <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
            @forelse($plans as $plan)
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                    <div class="p-6">
                        <h2 class="text-2xl leading-6 font-semibold text-gray-900">{{ $plan->name }}</h2>
                        <p class="mt-4 text-sm text-gray-500">{{ $plan->description }}</p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">₹{{ number_format($plan->monthly_price, 2) }}</span>
                            <span class="text-base font-medium text-gray-500">/mo</span>
                        </p>
                        <button type="button" onclick="confirmSubscription({{ $plan->id }}, 'monthly', {{ $plan->monthly_price }}, '{{ $plan->name }}')" class="mt-8 block w-full bg-navy border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-blue-900">
                            Select Monthly
                        </button>
                        <button type="button" onclick="confirmSubscription({{ $plan->id }}, 'yearly', {{ $plan->yearly_price }}, '{{ $plan->name }}')" class="mt-4 block w-full bg-saffron border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-orange-600">
                            Select Yearly (₹{{ number_format($plan->yearly_price, 2) }}/yr)
                        </button>
                    </div>
                    @if($plan->features)
                    <div class="pt-6 pb-8 px-6">
                        <h3 class="text-xs font-medium text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            @foreach($plan->features as $feature)
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-sm text-gray-500">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">No subscription plans available at the moment. Please contact support.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="subscriptionModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-navy/10 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Confirm Subscription
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500" id="modal-description">
                            Yes, I want to purchase this subscription.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" id="payButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-navy text-base font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy sm:ml-3 sm:w-auto sm:text-sm">
                    Proceed to Payment
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy sm:mt-0 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    let selectedPlan = null;

    function confirmSubscription(planId, cycle, price, name) {
        selectedPlan = { planId, cycle, price, name };
        document.getElementById('modal-description').innerText = `Yes, I want to purchase the ${name} subscription (${cycle}) for ₹${price}.`;
        document.getElementById('subscriptionModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('subscriptionModal').classList.add('hidden');
        selectedPlan = null;
    }

    document.getElementById('payButton').addEventListener('click', function() {
        if (!selectedPlan) return;
        
        const btn = this;
        btn.innerHTML = 'Processing...';
        btn.disabled = true;

        fetch('{{ route("pricing.checkout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                plan_id: selectedPlan.planId,
                billing_cycle: selectedPlan.cycle
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var options = {
                    "key": data.key,
                    "amount": data.amount,
                    "currency": "INR",
                    "name": "Geofence Attendance",
                    "description": "Subscription for " + selectedPlan.name,
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
                                plan_id: selectedPlan.planId,
                                billing_cycle: selectedPlan.cycle
                            })
                        })
                        .then(res => res.json())
                        .then(resData => {
                            if (resData.success) {
                                window.location.href = resData.redirect_url;
                            } else {
                                alert('Payment verification failed. Please contact support.');
                                closeModal();
                                btn.innerHTML = 'Proceed to Payment';
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
                        "color": "#1e3a8a" // navy
                    },
                    "modal": {
                        "ondismiss": function() {
                            closeModal();
                            btn.innerHTML = 'Proceed to Payment';
                            btn.disabled = false;
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                alert('Error initializing payment. ' + data.message);
                closeModal();
                btn.innerHTML = 'Proceed to Payment';
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong.');
            closeModal();
            btn.innerHTML = 'Proceed to Payment';
            btn.disabled = false;
        });
    });
</script>
@endpush
@endsection
