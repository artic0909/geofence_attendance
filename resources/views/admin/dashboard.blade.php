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
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
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

    <!-- Card 2 -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Geofences</p>
                <h3 class="text-3xl font-bold text-navy">{{ $stats['total_geofences'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
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

    <!-- Card 4 -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 p-6 border border-gray-100 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Accounts</p>
                <h3 class="text-3xl font-bold text-navy">{{ $stats['active_employees'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Pending Attendance Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:justify-between md:items-center gap-4 bg-gray-50/50">
        <div>
            <h2 class="text-lg font-bold text-navy flex items-center">
                Missing Check-ins Today
                <span class="ml-3 px-2.5 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ $pending_employees->total() }}</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">Employees who have not logged attendance yet.</p>
        </div>
        <a href="{{ route('admin.dashboard.export-pending') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-navy bg-saffron hover:bg-saffron-hover shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export CSV
        </a>
    </div>
    
    <div class="overflow-x-auto">
        @if($pending_employees->count() > 0)
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Employee</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Contact</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Assigned Sites</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pending_employees as $employee)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-navy">{{ $employee->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">ID: {{ $employee->employee_id ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $employee->phone }}</div>
                        <div class="text-xs text-gray-500">{{ $employee->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($employee->employeeGeofences as $geofence)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium border border-gray-200">
                                    {{ $geofence->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 italic text-xs">No Sites</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                            Absent
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $pending_employees->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 text-green-500 mb-4 shadow-sm border border-green-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-navy mb-1">Excellent!</h3>
            <p class="text-gray-500 text-sm">Every active employee has checked in today.</p>
        </div>
        @endif
    </div>
</div>

@endsection