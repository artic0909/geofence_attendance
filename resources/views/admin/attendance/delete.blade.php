@extends('admin.layout')
@section('header_title', 'Delete Attendances')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Delete Attendances</h1>
        <p class="text-gray-600 mt-1">Select date range to view and delete attendance records</p>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-start gap-3">
    <div class="p-1 rounded-full bg-green-100 text-green-600 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <div>
        <h4 class="text-green-800 font-bold text-sm">Success!</h4>
        <p class="text-green-700 text-sm mt-0.5">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3">
    <div class="p-1 rounded-full bg-red-100 text-red-600 shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </div>
    <div>
        <h4 class="text-red-800 font-bold text-sm">Error!</h4>
        <p class="text-red-700 text-sm mt-0.5">{{ session('error') }}</p>
    </div>
</div>
@endif

<!-- Filter Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h2 class="font-bold text-navy">Filter Attendances</h2>
    </div>

    <div class="p-6">
        <form method="GET" action="{{ route('admin.attendances.delete') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- From Date -->
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date <span class="text-red-500">*</span></label>
                <input type="date" name="from_date" id="from_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50"
                    value="{{ $fromDate ?? '' }}" required max="{{ date('Y-m-d') }}">
            </div>

            <!-- To Date -->
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date <span class="text-red-500">*</span></label>
                <input type="date" name="to_date" id="to_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50"
                    value="{{ $toDate ?? '' }}" required max="{{ date('Y-m-d') }}">
            </div>

            <!-- Geofence Filter -->
            <div>
                <label for="geofence" class="block text-sm font-medium text-gray-700 mb-1">Geofence (Optional)</label>
                <select name="geofence" id="geofence" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50">
                    <option value="">All Geofences</option>
                    @foreach($geofences as $geofence)
                    <option value="{{ $geofence->id }}" {{ $selectedGeofence == $geofence->id ? 'selected' : '' }}>
                        {{ $geofence->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Name Filter -->
            <div>
                <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-1">Employee Name (Optional)</label>
                <input type="text" name="employee_name" id="employee_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-saffron focus:border-saffron bg-gray-50"
                    placeholder="Enter name" value="{{ request('employee_name') }}">
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex justify-end gap-3 mt-2">
                <a href="{{ route('admin.attendances.delete') }}" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                    Reset
                </a>
                <button type="submit" class="px-5 py-2.5 bg-navy text-white font-bold rounded-lg hover:bg-[#233554] transition-colors shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Search Attendances
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Attendances Table -->
@if($attendances->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h2 class="font-bold text-lg text-navy mb-1">Attendances Found</h2>
            <p class="text-sm text-gray-500">
                Showing <span class="font-bold text-gray-800">{{ $attendances->count() }}</span> record(s) from 
                <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</span> to 
                <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</span>
            </p>
        </div>

        <!-- Delete All Button -->
        <button type="button" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 font-bold rounded-lg border border-red-100 hover:bg-red-600 hover:text-white transition-all shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Delete All ({{ $attendances->count() }})
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold tracking-wider">Type</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Employee Name</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Date</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Check In</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Check Out</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Total Hours</th>
                    <th class="px-6 py-4 font-semibold tracking-wider">Location/Reason</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($attendances as $index => $attendance)
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
                    <td class="px-6 py-4 text-gray-700">
                        {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-2xl overflow-hidden">
            <div class="modal-header bg-red-600 text-white border-b-0">
                <h5 class="modal-title font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-medium">
                    Warning! This action cannot be undone. All selected records will be permanently removed.
                </div>
                <p class="mb-4 text-gray-700">Are you sure you want to delete <strong class="text-gray-900">{{ $attendances->count() }}</strong> attendance record(s)?</p>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 text-sm">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="text-gray-500 font-medium">From Date:</div>
                        <div class="col-span-2 font-bold text-navy">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</div>
                        
                        <div class="text-gray-500 font-medium">To Date:</div>
                        <div class="col-span-2 font-bold text-navy">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</div>
                        
                        @if($selectedGeofence)
                        <div class="text-gray-500 font-medium mt-2 pt-2 border-t border-gray-200">Site:</div>
                        <div class="col-span-2 font-bold text-navy mt-2 pt-2 border-t border-gray-200">{{ $geofences->firstWhere('id', $selectedGeofence)->name }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-gray-50 border-t border-gray-100">
                <button type="button" class="px-5 py-2 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-100 transition-colors" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.attendances.bulk-delete') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="from_date" value="{{ $fromDate }}">
                    <input type="hidden" name="to_date" value="{{ $toDate }}">
                    <input type="hidden" name="geofence" value="{{ $selectedGeofence }}">
                    <input type="hidden" name="employee_name" value="{{ request('employee_name') }}">
                    <button type="submit" class="px-5 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@elseif($fromDate && $toDate)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-12">
    <div class="text-center max-w-md mx-auto">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-6 shadow-inner border border-gray-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-navy mb-2">No Attendances Found</h3>
        <p class="text-gray-500 mb-2">
            We couldn't find any records between<br>
            <strong class="text-gray-700">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</strong> and
            <strong class="text-gray-700">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</strong>
        </p>
        <p class="text-sm text-gray-400">Try adjusting your filters or date range.</p>
    </div>
</div>
@else
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-12">
    <div class="text-center max-w-md mx-auto">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-300 mb-6 shadow-inner border border-gray-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-navy mb-2">Select Date Range</h3>
        <p class="text-gray-500">Please select a date range using the filter above to view attendance records that you can delete.</p>
    </div>
</div>
@endif

@push('scripts')
<script>
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
</script>
@endpush

<script>
    // Set max date for to_date based on from_date selection
    document.getElementById('from_date').addEventListener('change', function() {
        document.getElementById('to_date').setAttribute('min', this.value);
    });
</script>

@endsection