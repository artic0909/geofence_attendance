@extends('admin.layout')
@section('header_title', 'Today\'s Attendances')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Today's Attendances</h1>
        <p class="text-gray-600 mt-1">{{ \Carbon\Carbon::today()->format('l, jS F Y') }}</p>
    </div>
    
    <div class="flex gap-2">
        <a href="{{ route('admin.attendances.today.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg shadow-sm hover:bg-green-700 transition-colors text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h2 class="font-bold text-navy">Filter Records</h2>
    </div>
    
    <div class="p-6">
        <form method="GET" id="filterForm" action="{{ route('admin.attendances.today') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-1">
                <label for="geofence" class="block text-sm font-medium text-gray-700 mb-1">Site / Geofence</label>
                <select name="geofence" id="geofence" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50">
                    <option value="">All Sites</option>
                    @foreach($geofences as $geofence)
                    <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                        {{ $geofence->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
                <input type="text" name="employee_name" id="employee_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50" placeholder="Search by name..." value="{{ request('employee_name') }}">
            </div>

            <div class="md:col-span-1 flex gap-2">
                <button type="submit" id="filterBtn" class="flex-1 bg-navy text-white px-4 py-2 rounded-lg hover:bg-[#233554] transition-colors font-medium">Filter</button>
                <a href="{{ route('admin.attendances.today') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-center">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($recent_attendances->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold tracking-wider">Type</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Employee</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Check In</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Check Out</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Hours</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Location</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($recent_attendances as $attendance)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $attendance->attendance_type == 'outside' ? 'bg-orange-100 text-orange-700 border border-orange-200' : 'bg-green-100 text-green-700 border border-green-200' }}">
                            {{ ucfirst($attendance->attendance_type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-navy">{{ $attendance->employee->name }}</div>
                        <div class="text-xs text-gray-500">{{ $attendance->employee->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_in_photo)
                        <button class="text-xs text-blue-600 hover:text-blue-800 underline mt-1" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckIn{{$attendance->id}}">View Photo</button>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_out_photo)
                        <button class="text-xs text-blue-600 hover:text-blue-800 underline mt-1" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckOut{{$attendance->id}}">View Photo</button>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @php
                        if ($attendance->check_in && $attendance->check_out) {
                            $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                            $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                            $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                        } else {
                            $totalHours = '--:--:--';
                        }
                        @endphp
                        <span class="font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded text-xs">{{ $totalHours }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($attendance->attendance_type == 'normal')
                            <span class="font-medium text-gray-700">{{ $attendance->geofence->name ?? 'N/A' }}</span>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 font-bold text-xs">{{ $attendance->checkin_location ?? 'Outside' }}</span>
                                @if($attendance->reason)
                                    <button class="px-2 py-1 bg-orange-50 text-orange-600 rounded text-xs border border-orange-100 hover:bg-orange-100 transition-colors" data-bs-toggle="modal" data-bs-target="#reasonModal{{$attendance->id}}" title="View Reason">
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
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
        {{ $recent_attendances->links() }}
    </div>
    @else
    <div class="py-16 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4 shadow-sm border border-gray-100">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-navy mb-1">No Records Found</h3>
        <p class="text-gray-500 text-sm">No attendances have been logged for today yet.</p>
    </div>
    @endif
</div>

<!-- Modals for Photos -->
@foreach($recent_attendances as $attendance)
@if($attendance->check_in_photo)
<div class="modal fade" id="staticBackdropCheckIn{{$attendance->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-2xl overflow-hidden">
            <div class="modal-header bg-gray-50 border-b border-gray-100">
                <h5 class="modal-title font-bold text-navy">Check-In Photo: {{ $attendance->employee->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ Storage::url($attendance->check_in_photo) }}" class="w-full h-auto" alt="Check In Photo">
            </div>
        </div>
    </div>
</div>
@endif

@if($attendance->check_out_photo)
<div class="modal fade" id="staticBackdropCheckOut{{$attendance->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-2xl overflow-hidden">
            <div class="modal-header bg-gray-50 border-b border-gray-100">
                <h5 class="modal-title font-bold text-navy">Check-Out Photo: {{ $attendance->employee->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ Storage::url($attendance->check_out_photo) }}" class="w-full h-auto" alt="Check Out Photo">
            </div>
        </div>
    </div>
</div>
@endif

@if($attendance->attendance_type == 'outside' && $attendance->reason)
<div class="modal fade" id="reasonModal{{$attendance->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-2xl overflow-hidden">
            <div class="modal-header bg-orange-50 border-b border-orange-100">
                <h5 class="modal-title font-bold text-orange-700">Outside Justification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <div class="mb-4">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Employee</label>
                    <p class="text-navy font-medium">{{ $attendance->employee->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Location</label>
                    <p class="text-navy font-medium">{{ $attendance->checkin_location ?? 'N/A' }}</p>
                </div>
                <div class="p-4 bg-orange-50 border border-orange-100 rounded-xl">
                    <label class="text-xs font-bold text-orange-700 uppercase tracking-wider mb-2 block">Reason</label>
                    <p class="text-gray-800 italic leading-relaxed">"{{ $attendance->reason }}"</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection