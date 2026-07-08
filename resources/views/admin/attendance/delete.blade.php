@extends('admin.layout')
@section('header_title', 'Delete Attendances')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-trash" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Data Management</p>
      <h1 class="h3 mb-1">Delete Attendances</h1>
      <p class="text-muted mb-0">Select date range to view and delete attendance records</p>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
    <div>
        <h5 class="alert-heading mb-1 h6 fw-bold">Success!</h5>
        <p class="mb-0 small">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
    <div>
        <h5 class="alert-heading mb-1 h6 fw-bold">Error!</h5>
        <p class="mb-0 small">{{ session('error') }}</p>
    </div>
</div>
@endif

<section class="panel mb-4">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-funnel" aria-hidden="true"></i><span>Filter Attendances</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form method="GET" action="{{ route('admin.attendances.delete') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="from_date" class="form-label fw-bold small">From Date <span class="text-danger">*</span></label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ $fromDate ?? '' }}" required max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-md-3">
            <label for="to_date" class="form-label fw-bold small">To Date <span class="text-danger">*</span></label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ $toDate ?? '' }}" required max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-md-3">
            <label for="geofence" class="form-label fw-bold small">Geofence (Optional)</label>
            <select name="geofence" id="geofence" class="form-select">
                <option value="">All Geofences</option>
                @foreach($geofences as $geofence)
                <option value="{{ $geofence->id }}" {{ $selectedGeofence == $geofence->id ? 'selected' : '' }}>
                    {{ $geofence->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="employee_name" class="form-label fw-bold small">Employee Name (Optional)</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Enter name" value="{{ request('employee_name') }}">
        </div>

        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.attendances.delete') }}" class="btn btn-light">Reset</a>
            <button type="submit" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-search me-1"></i> Search Attendances
            </button>
        </div>
    </form>
  </div>
</section>

@if($attendances->count() > 0)
<section class="panel">
  <div class="panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Attendances Found</span></h2>
      <p class="text-muted small mb-0">
          Showing <span class="fw-bold text-dark">{{ $attendances->count() }}</span> record(s) from 
          <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</span> to 
          <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</span>
      </p>
    </div>
    <button type="button" class="btn btn-outline-danger btn-sm fw-bold d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
        <i class="bi bi-trash me-1"></i> Delete All ({{ $attendances->count() }})
    </button>
  </div>
  
  <div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Type</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Date</th>
                <th scope="col">Check In</th>
                <th scope="col">Check Out</th>
                <th scope="col">Total Hours</th>
                <th scope="col">Location/Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr class="{{ $attendance->is_auto_checkout_trap ? 'table-danger' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="badge {{ $attendance->attendance_type == 'outside' ? 'text-bg-warning' : 'text-bg-success' }}">
                        {{ ucfirst($attendance->attendance_type) }}
                    </span>
                    @if($attendance->is_auto_checkout_trap)
                    <div class="mt-1">
                        <span class="badge text-bg-danger" title="Privacy Violation: The employee forcefully bypassed the Kiosk Mode pin.">
                            <i class="bi bi-shield-exclamation me-1"></i> Privacy Violation
                        </span>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="fw-bold text-primary">{{ $attendance->employee->name }}</div>
                    <div class="small text-muted">{{ $attendance->employee->email }}</div>
                </td>
                <td class="fw-medium">
                    {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                </td>
                <td class="text-muted">
                    {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}
                </td>
                <td class="text-muted">
                    {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}
                </td>
                <td>
                    @php
                    if ($attendance->check_in && $attendance->check_out) {
                        $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                        $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                        $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                    } else {
                        $totalHours = '--:--:--';
                    }
                    @endphp
                    <span class="badge bg-light text-dark font-monospace">{{ $totalHours }}</span>
                </td>
                <td>
                    @if($attendance->attendance_type == 'normal')
                        <span class="badge bg-light border text-dark">
                            <i class="bi bi-geo-alt me-1 text-muted"></i>
                            {{ $attendance->geofence->name ?? 'N/A' }}
                        </span>
                    @else
                        <div class="d-flex flex-column gap-1 align-items-start">
                            <span class="badge text-bg-warning">
                                <i class="bi bi-cursor me-1"></i>
                                {{ $attendance->checkin_location ?? 'Outside' }}
                            </span>
                            @if($attendance->reason)
                                <button type="button" class="btn btn-outline-warning btn-sm py-0" onclick="showReason('{{ addslashes($attendance->employee->name) }}', '{{ addslashes($attendance->checkin_location ?? 'N/A') }}', '{{ addslashes($attendance->reason) }}')" title="View Reason">
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
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-bottom-0">
                <h5 class="modal-title fw-bold d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger mb-4">
                    <strong>Warning!</strong> This action cannot be undone. All selected records will be permanently removed.
                </div>
                <p class="mb-3">Are you sure you want to delete <strong class="fs-5">{{ $attendances->count() }}</strong> attendance record(s)?</p>
                <div class="bg-light p-3 rounded border">
                    <div class="row mb-1">
                        <div class="col-4 text-muted small fw-bold">From Date:</div>
                        <div class="col-8 fw-bold">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-4 text-muted small fw-bold">To Date:</div>
                        <div class="col-8 fw-bold">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</div>
                    </div>
                    @if($selectedGeofence)
                    <div class="row pt-2 mt-2 border-top">
                        <div class="col-4 text-muted small fw-bold">Site:</div>
                        <div class="col-8 fw-bold">{{ $geofences->firstWhere('id', $selectedGeofence)->name }}</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.attendances.bulk-delete') }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="from_date" value="{{ $fromDate }}">
                    <input type="hidden" name="to_date" value="{{ $toDate }}">
                    <input type="hidden" name="geofence" value="{{ $selectedGeofence }}">
                    <input type="hidden" name="employee_name" value="{{ request('employee_name') }}">
                    <button type="submit" class="btn btn-danger fw-bold">
                        Yes, Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@elseif($fromDate && $toDate)
<div class="card border-0 shadow-sm p-5 mt-4">
    <div class="text-center max-w-md mx-auto py-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted mb-4 rounded-circle" style="width: 80px; height: 80px;">
            <i class="bi bi-search fs-1"></i>
        </div>
        <h3 class="h4 fw-bold text-dark mb-2">No Attendances Found</h3>
        <p class="text-muted mb-2">
            We couldn't find any records between<br>
            <strong class="text-dark">{{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }}</strong> and
            <strong class="text-dark">{{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</strong>
        </p>
        <p class="small text-muted mb-0">Try adjusting your filters or date range.</p>
    </div>
</div>
@else
<div class="card border-0 shadow-sm p-5 mt-4">
    <div class="text-center max-w-md mx-auto py-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted mb-4 rounded-circle" style="width: 80px; height: 80px;">
            <i class="bi bi-calendar3-range fs-1"></i>
        </div>
        <h3 class="h4 fw-bold text-dark mb-2">Select Date Range</h3>
        <p class="text-muted mb-0">Please select a date range using the filter above to view attendance records that you can delete.</p>
    </div>
</div>
@endif

@push('scripts')
<script>
    function showReason(employee, location, reason) {
        Swal.fire({
            title: 'Outside Justification',
            html: `
                <div class="text-start mt-4">
                    <p class="small fw-bold text-muted text-uppercase mb-1">Employee</p>
                    <p class="fw-medium text-primary mb-3">${employee}</p>
                    
                    <p class="small fw-bold text-muted text-uppercase mb-1">Location</p>
                    <p class="fw-medium text-primary mb-3">${location}</p>
                    
                    <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                        <p class="small fw-bold text-warning text-uppercase mb-2">Reason</p>
                        <p class="text-dark fst-italic mb-0">"${reason}"</p>
                    </div>
                </div>
            `,
            confirmButtonColor: '#fd7e14',
            confirmButtonText: 'Close',
        });
    }

    document.getElementById('from_date').addEventListener('change', function() {
        document.getElementById('to_date').setAttribute('min', this.value);
    });
</script>
@endpush
@endsection