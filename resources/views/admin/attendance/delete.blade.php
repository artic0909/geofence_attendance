@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Delete Attendances</h1>
    <p class="text-gray-600">Select date range to view and delete attendance records</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <strong>Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="font-bold text-xl mb-4">Filter Attendances</h2>

        <form method="GET" action="{{ route('admin.attendances.delete') }}" class="row">
            <!-- From Date -->
            <div class="col-md-3 mb-3">
                <label for="from_date" class="form-label">From Date <span class="text-danger">*</span></label>
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="{{ $fromDate ?? '' }}" required max="{{ date('Y-m-d') }}">
            </div>

            <!-- To Date -->
            <div class="col-md-3 mb-3">
                <label for="to_date" class="form-label">To Date <span class="text-danger">*</span></label>
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="{{ $toDate ?? '' }}" required max="{{ date('Y-m-d') }}">
            </div>

            <!-- Geofence Filter -->
            <div class="col-md-3 mb-3">
                <label for="geofence" class="form-label">Geofence (Optional)</label>
                <select name="geofence" id="geofence" class="form-select">
                    <option value="">All Geofences</option>
                    @foreach($geofences as $geofence)
                    <option value="{{ $geofence->id }}" {{ $selectedGeofence == $geofence->id ? 'selected' : '' }}>
                        {{ $geofence->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Name Filter -->
            <div class="col-md-3 mb-3">
                <label for="employee_name" class="form-label">Employee Name (Optional)</label>
                <input type="text" name="employee_name" id="employee_name" class="form-control"
                    placeholder="Enter name" value="{{ request('employee_name') }}">
            </div>

            <!-- Buttons -->
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search Attendances
                </button>
                <a href="{{ route('admin.attendances.delete') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Attendances Table -->
@if($attendances->count() > 0)
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="font-bold text-xl mb-1">Attendances Found</h2>
            <p class="text-gray-600 mb-0">
                Showing {{ $attendances->count() }} record(s) from
                <strong>{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</strong> to
                <strong>{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</strong>
            </p>
        </div>

        <!-- Delete All Button -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
            <i class="bi bi-trash"></i> Delete All ({{ $attendances->count() }})
        </button>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full table table-striped">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">S.No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Hours</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($attendances as $index => $attendance)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $attendance->employee->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $attendance->employee->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                            if ($attendance->check_in && $attendance->check_out) {
                            $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                            $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                            $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                            } else {
                            $totalHours = 'N/A';
                            }
                            @endphp
                            {{ $totalHours }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $attendance->geofence->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
                <p class="mb-3">Are you sure you want to delete <strong>{{ $attendances->count() }}</strong> attendance record(s)?</p>
                <p class="mb-3">
                    <strong>Date Range:</strong><br>
                    From: {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}<br>
                    To: {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}
                </p>
                @if($selectedGeofence)
                <p class="mb-0">
                    <strong>Geofence:</strong> {{ $geofences->firstWhere('id', $selectedGeofence)->name }}
                </p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.attendances.bulk-delete') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="from_date" value="{{ $fromDate }}">
                    <input type="hidden" name="to_date" value="{{ $toDate }}">
                    <input type="hidden" name="geofence" value="{{ $selectedGeofence }}">
                    <input type="hidden" name="employee_name" value="{{ request('employee_name') }}">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@elseif($fromDate && $toDate)
<div class="bg-white rounded-lg shadow p-6">
    <div class="text-center py-8">
        <i class="bi bi-inbox text-gray-400" style="font-size: 4rem;"></i>
        <h3 class="text-xl font-semibold text-gray-700 mt-3">No Attendances Found</h3>
        <p class="text-gray-500 mt-2">
            No attendance records found between
            <strong>{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</strong> and
            <strong>{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</strong>
        </p>
        <p class="text-gray-500">Try adjusting your filters or date range.</p>
    </div>
</div>
@else
<div class="bg-white rounded-lg shadow p-6">
    <div class="text-center py-8">
        <i class="bi bi-calendar-range text-gray-400" style="font-size: 4rem;"></i>
        <h3 class="text-xl font-semibold text-gray-700 mt-3">Select Date Range</h3>
        <p class="text-gray-500 mt-2">Please select a date range above to view attendance records.</p>
    </div>
</div>
@endif

<script>
    // Set max date for to_date based on from_date selection
    document.getElementById('from_date').addEventListener('change', function() {
        document.getElementById('to_date').setAttribute('min', this.value);
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

@endsection