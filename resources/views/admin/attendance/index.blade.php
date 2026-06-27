@extends('admin.layout')
@section('header_title', 'All Attendances')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">All Attendances</h1>
        <p class="text-gray-600 mt-1">Welcome to Site Sync <span class="font-bold text-navy" style="text-transform: capitalize;">{{ auth()->user()->name }}</span> Panel</p>
    </div>
    
    <div class="flex gap-2">
        <a href="{{ route('admin.attendances.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg shadow-sm hover:bg-green-700 transition-colors text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h2 class="font-bold text-navy">Filter Search</h2>
    </div>
    
    <div class="p-6">
        <form method="GET" id="filterForm" action="{{ route('admin.attendances') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Geofence Dropdown -->
            <div>
                <label for="geofence" class="block text-sm font-medium text-gray-700 mb-1">Site / Geofence</label>
                <select name="geofence" id="geofence" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50">
                    <option value="" {{ request('geofence') == '' ? 'selected' : '' }}>ALL</option>
                    @foreach($geofences as $geofence)
                    <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                        {{ $geofence->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- From Date -->
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="from_date" id="from_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50" value="{{ request('from_date') }}">
            </div>

            <!-- To Date -->
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="to_date" id="to_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50" value="{{ request('to_date') }}">
            </div>

            <!-- Employee Name -->
            <div>
                <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
                <input type="text" name="employee_name" id="employee_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50" placeholder="Optional" value="{{ request('employee_name') }}">
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex justify-end gap-3 mt-2">
                <a href="{{ route('admin.attendances') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    Reset
                </a>
                <button type="submit" id="filterBtn" class="px-5 py-2.5 bg-navy text-white font-bold rounded-lg hover:bg-[#233554] transition-colors shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Search
                </button>
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
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Type</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Employee</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Date</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Check In</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Check Out</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Hours</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600">Location</th>
                    <th class="px-6 py-4 font-bold tracking-wider text-gray-600 text-right">Action</th>
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
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_in_photo)
                        <button type="button" class="text-xs text-blue-600 hover:text-blue-800 underline mt-1" onclick="showImage('{{ Storage::url($attendance->check_in_photo) }}', 'Check-In Photo: {{ $attendance->employee->name }}')">View Photo</button>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_out_photo)
                        <button type="button" class="text-xs text-blue-600 hover:text-blue-800 underline mt-1" onclick="showImage('{{ Storage::url($attendance->check_out_photo) }}', 'Check-Out Photo: {{ $attendance->employee->name }}')">View Photo</button>
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $attendance->geofence->name ?? 'N/A' }}
                            </span>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 font-bold text-xs flex items-center bg-orange-50 px-2 py-1 rounded-md">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $attendance->checkin_location ?? 'Outside' }}
                                </span>
                                @if($attendance->reason)
                                    <button type="button" class="px-2 py-1 bg-white text-orange-600 rounded text-xs border border-orange-200 hover:bg-orange-50 hover:border-orange-300 transition-colors shadow-sm font-medium" onclick="showReason('{{ addslashes($attendance->employee->name) }}', '{{ addslashes($attendance->checkin_location ?? 'N/A') }}', '{{ addslashes($attendance->reason) }}')" title="View Reason">
                                        View Reason
                                    </button>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($attendance->check_in && !$attendance->check_out && \Carbon\Carbon::parse($attendance->date)->isToday())
                        <a href="{{ route('admin.employees.track', $attendance->employee_id) }}" class="inline-flex items-center justify-center px-3 py-1.5 bg-navy text-white font-medium rounded-lg hover:bg-[#233554] transition-colors text-xs shadow-sm" title="Track Live Location">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            Track
                        </a>
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
        <p class="text-gray-500 text-sm">No attendances have been found with the current filters.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function showImage(imageUrl, title) {
        Swal.fire({
            title: title,
            imageUrl: imageUrl,
            imageWidth: '100%',
            imageAlt: 'Attendance Photo',
            confirmButtonColor: '#1a2639',
            confirmButtonText: 'Close',
            customClass: {
                title: 'text-lg font-bold text-navy',
            }
        });
    }

    function showReason(employee, location, reason) {
        Swal.fire({
            title: 'Outside Justification',
            html: `
                <div class="text-left mt-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Employee</p>
                    <p class="text-navy font-medium mb-4">${employee}</p>
                    
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Location</p>
                    <p class="text-navy font-medium mb-4">${location}</p>
                    
                    <div class="p-4 bg-orange-50 border border-orange-100 rounded-xl">
                        <p class="text-xs font-bold text-orange-700 uppercase tracking-wider mb-2 block">Reason</p>
                        <p class="text-gray-800 italic leading-relaxed">"${reason}"</p>
                    </div>
                </div>
            `,
            confirmButtonColor: '#ea580c',
            confirmButtonText: 'Close',
            customClass: {
                title: 'text-xl font-bold text-orange-700 border-b border-orange-100 pb-2',
            }
        });
    }
    // Set max date for to_date based on from_date selection
    const fromDateInput = document.getElementById('from_date');
    const toDateInput = document.getElementById('to_date');
    
    if(fromDateInput && toDateInput) {
        fromDateInput.addEventListener('change', function() {
            toDateInput.setAttribute('min', this.value);
        });
    }
</script>
@endpush

@endsection