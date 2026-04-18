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

<!-- Recent Activity Section -->
<div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200 mt-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <h2 class="text-xl font-bold text-gray-800">Recent Attendance Activity</h2>
        <a href="{{ route('admin.attendances') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View All →</a>
    </div>
    
    <div class="overflow-x-auto">
        @if($recent_attendances->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SL</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location/Reason</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($recent_attendances as $attendance)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ($recent_attendances->currentPage() - 1) * $recent_attendances->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-bold rounded {{ $attendance->attendance_type == 'outside' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst($attendance->attendance_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $attendance->employee->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($attendance->attendance_type == 'normal')
                            <span class="text-gray-700 font-medium">{{ $attendance->geofence->name ?? 'N/A' }}</span>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 font-bold">{{ $attendance->checkin_location ?? 'Outside' }}</span>
                                @if($attendance->reason)
                                    <button class="px-2 py-1 bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-200 transition-colors" data-bs-toggle="modal" data-bs-target="#reasonModal{{$attendance->id}}">
                                        Reason
                                    </button>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $recent_attendances->links() }}
        </div>
        @else
        <div class="p-12 text-center text-gray-500">
            No recent activity found.
        </div>
        @endif
    </div>
</div>

<!-- Reason Modals -->
@foreach($recent_attendances as $attendance)
@if($attendance->attendance_type == 'outside' && $attendance->reason)
<div class="modal fade" id="reasonModal{{$attendance->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange-50">
                <h5 class="modal-title font-bold text-orange-700" id="reasonModalLabel">Attendance Justification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <div class="mb-4">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Employee</label>
                    <p class="text-gray-900 font-medium">{{ $attendance->employee->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Site Location</label>
                    <p class="text-gray-900 font-medium">{{ $attendance->checkin_location ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-orange-50 border border-orange-100 rounded-xl">
                    <label class="text-xs font-bold text-orange-600 uppercase tracking-wider mb-2 block">Reason for Outside Duty</label>
                    <p class="text-gray-800 italic leading-relaxed">"{{ $attendance->reason }}"</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-lg" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection