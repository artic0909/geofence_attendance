@extends('admin.layout')
@section('header_title', 'Missing Check-ins Today')

@section('content')

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
        <div class="flex gap-2">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.attendances.today-absent') }}" class="flex">
                <input type="text" name="employee_name" placeholder="Search by name..." value="{{ request('employee_name') }}" class="rounded-l-lg border-gray-300 border px-3 py-2 text-sm focus:ring-saffron focus:border-saffron">
                <button type="submit" class="bg-navy text-white px-3 py-2 rounded-r-lg text-sm hover:bg-navy/90">Search</button>
            </form>
            
            <a href="{{ route('admin.dashboard.export-pending') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-navy bg-saffron hover:bg-saffron-hover shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </a>
        </div>
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
            {{ $pending_employees->appends(request()->query())->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 text-green-500 mb-4 shadow-sm border border-green-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-navy mb-1">Excellent!</h3>
            <p class="text-gray-500 text-sm">Every active employee has checked in today or no employees match your search.</p>
        </div>
        @endif
    </div>
</div>

@endsection
