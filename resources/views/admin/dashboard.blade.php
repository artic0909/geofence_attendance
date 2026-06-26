@extends('admin.layout')
@section('header_title', 'Dashboard')

@section('content')

<!-- Subscription Status Banner -->
<div class="bg-gradient-to-r from-navy via-[#233554] to-navy rounded-2xl shadow-xl border border-white/10 mb-8 overflow-hidden relative">
    <!-- Decorative background circle -->
    <div class="absolute -right-16 -top-24 w-64 h-64 rounded-full bg-saffron/10 blur-3xl"></div>
    <div class="absolute right-32 -bottom-24 w-48 h-48 rounded-full bg-white/5 blur-2xl"></div>

    <div class="p-8 md:flex md:items-center md:justify-between relative z-10">
        <div class="text-white">
            <h3 class="text-3xl font-extrabold tracking-tight mb-2">
                {{ auth()->user()->business_name }}
            </h3>
            <p class="text-gray-300 flex items-center text-sm md:text-base">
                <span class="inline-block w-2 h-2 rounded-full {{ auth()->user()->subscription_status === 'active' ? 'bg-green-400 shadow-[0_0_8px_#4ade80]' : 'bg-red-500 shadow-[0_0_8px_#ef4444]' }} mr-2"></span>
                Subscription Status: 
                <span class="font-bold ml-1 uppercase tracking-wider {{ auth()->user()->subscription_status === 'active' ? 'text-green-400' : 'text-red-400' }}">
                    {{ auth()->user()->subscription_status ?? 'Inactive' }}
                </span>
            </p>
        </div>
        
        <div class="mt-6 md:mt-0 flex flex-col md:items-end text-white">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-6 py-4 flex gap-8 shadow-inner">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Current Plan</p>
                    <p class="font-bold text-xl text-saffron">{{ $current_plan->plan_name ?? 'Free / Trial' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1">Expires On</p>
                    <p class="font-bold text-xl">
                        {{ auth()->user()->subscription_expires_at ? \Carbon\Carbon::parse(auth()->user()->subscription_expires_at)->format('M d, Y') : 'N/A' }}
                    </p>
                </div>
            </div>
            @if(auth()->user()->subscription_status !== 'active')
                <a href="{{ route('pricing') }}" class="mt-4 inline-flex items-center text-sm font-bold text-navy bg-saffron hover:bg-saffron-hover px-5 py-2 rounded-lg transition-colors shadow-lg">
                    Renew Subscription <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Subscription Progress Bar -->
    @if(!$subscription['is_expired'])
    <div class="px-8 pb-6 relative z-10">
        <div class="flex justify-between text-xs text-gray-300 mb-1 font-semibold">
            <span>Subscription Progress</span>
            <span>{{ $subscription['days_left'] }} Days Left</span>
        </div>
        <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden">
            <div class="h-2.5 rounded-full transition-all duration-500 
                {{ $subscription['percentage'] > 90 ? 'bg-red-500' : ($subscription['percentage'] > 70 ? 'bg-orange-400' : 'bg-green-400') }}" 
                style="width: {{ $subscription['percentage'] }}%">
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Employees -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Employees</p>
                <h3 class="text-3xl font-bold text-navy">{{ $stats['total_employees'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 2: Today's Check-ins -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Today's Check-ins</p>
                <h3 class="text-3xl font-bold text-navy">{{ $stats['today_attendances'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 3: Today's Absents -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Today's Absents</p>
                <h3 class="text-3xl font-bold text-navy">{{ $stats['today_absents'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Payments -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Payments</p>
                <h3 class="text-3xl font-bold text-navy">₹{{ number_format($stats['total_payments'], 2) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-saffron/20 text-saffron flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-bold text-navy mb-4">7-Day Attendance Trend</h3>
    <div class="relative h-72">
        <canvas id="attendanceChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: @json($stats['chart_dates']),
                datasets: [
                    {
                        label: 'Total Employees',
                        data: @json($stats['chart_totals']),
                        borderColor: '#9ca3af', // gray-400
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.1,
                        pointBackgroundColor: '#9ca3af',
                        pointBorderColor: '#fff',
                        pointRadius: 3
                    },
                    {
                        label: 'Present',
                        data: @json($stats['chart_presents']),
                        borderColor: '#4ade80', // green-400
                        backgroundColor: 'rgba(74, 222, 128, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#166534',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Absent',
                        data: @json($stats['chart_absents']),
                        borderColor: '#f87171', // red-400
                        backgroundColor: 'rgba(248, 113, 113, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#991b1b',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true, 
                        position: 'top',
                        labels: { usePointStyle: true, boxWidth: 8 }
                    },
                    tooltip: {
                        backgroundColor: '#1a2639',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#6b7280' },
                        grid: { color: '#f3f4f6', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#6b7280' },
                        grid: { display: false, drawBorder: false }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush

@endsection