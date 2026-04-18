@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Welcome to Site Sync <span class="font-bold text-danger" style="text-transform: capitalize;">{{ auth()->guard('admin')->user()->name }}</span> Panel</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Employees</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_employees'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Geofences</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_geofences'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Today's Attendance</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['today_attendances'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Active Employees</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_employees'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Pending Attendance Activity Section -->
<div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 mt-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Pending Attendance Today ({{ $pending_employees->total() }})</h2>
            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase tracking-wider">Absent / Not Checked In</span>
        </div>
        <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-success btn-sm flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Export to Excel
        </a>
    </div>
    
    <div class="overflow-x-auto">
        @if($pending_employees->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SL</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Assigned Geofences</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pending_employees as $employee)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ($pending_employees->currentPage() - 1) * $pending_employees->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $employee->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $employee->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $employee->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $employee->employee_id ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex flex-wrap gap-1">
                            @forelse($employee->geofences as $geofence)
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-xs border border-blue-100">{{ $geofence->name }}</span>
                            @empty
                                <span class="text-gray-400 italic">No Geofence</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-bold rounded bg-red-50 text-red-600 border border-red-100 italic">
                            Absent
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $pending_employees->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">All Attended!</h3>
            <p class="text-gray-500">Every active employee has already provided their attendance today.</p>
        </div>
        @endif
    </div>
</div>

@endsection