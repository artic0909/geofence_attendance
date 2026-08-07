@extends('admin.layout')
@section('header_title', 'All Attendances')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Reports</p>
      <h1 class="h3 mb-1">All Attendances</h1>
      <p class="text-muted mb-0">Welcome to Site Sync <span class="fw-bold text-primary text-capitalize">{{ auth()->user()->name }}</span> Panel</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.attendances.export') }}" class="btn btn-success btn-sm d-flex align-items-center"><i class="bi bi-file-earmark-excel me-1" aria-hidden="true"></i> Export Excel</a>
  </div>
</div>

<section class="panel mt-3 mb-4">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-funnel" aria-hidden="true"></i><span>Filter Search</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form method="GET" id="filterForm" action="{{ route('admin.attendances') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="geofence" class="form-label fw-bold small">Site / Geofence</label>
            <select name="geofence" id="geofence" class="form-select select2">
                <option value="" {{ request('geofence') == '' ? 'selected' : '' }}>ALL</option>
                @foreach($geofences as $geofence)
                <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                    {{ $geofence->name }}
                </option>
                @endforeach
                <option value="outside" {{ request('geofence') == 'outside' ? 'selected' : '' }}>Outside</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="from_date" class="form-label fw-bold small">From Date</label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label for="to_date" class="form-label fw-bold small">To Date</label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-3">
            <label for="employee_name" class="form-label fw-bold small">Employee Name</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Optional" value="{{ request('employee_name') }}">
        </div>

        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.attendances') }}" class="btn btn-light">Reset</a>
            <button type="submit" id="filterBtn" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-funnel me-1"></i> Filter Search
            </button>
        </div>
    </form>
  </div>
</section>

<section class="panel">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Attendance Log</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    @if($recent_attendances->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Type</th>
                    <th scope="col">Employee</th>
                    <th scope="col">Date</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Hours</th>
                    <th scope="col">Location</th>
                    <th scope="col" class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_attendances as $attendance)
                <tr class="{{ $attendance->is_auto_checkout_trap ? 'table-danger' : '' }}">
                    <td>{{ ($recent_attendances->currentPage() - 1) * $recent_attendances->perPage() + $loop->iteration }}</td>
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
                    <td>
                        <div class="fw-medium">{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_in_photo)
                        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none mt-1" onclick="showImage('{{ Storage::url($attendance->check_in_photo) }}', 'Check-In Photo: {{ $attendance->employee->name }}')">View Photo</button>
                        @endif
                    </td>
                    <td>
                        <div class="fw-medium">{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : '--:--' }}</div>
                        @if($attendance->check_out_photo)
                        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none mt-1" onclick="showImage('{{ Storage::url($attendance->check_out_photo) }}', 'Check-Out Photo: {{ $attendance->employee->name }}')">View Photo</button>
                        @endif
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
                    <td class="text-end">
                        @if($attendance->check_in && !$attendance->check_out && \Carbon\Carbon::parse($attendance->date)->isToday())
                        <a href="{{ route('admin.employees.track', $attendance->employee) }}" class="btn btn-primary btn-sm" title="Track Live Location">
                            <i class="bi bi-geo-fill me-1"></i> Track
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-4 py-3 border-top">
            {{ $recent_attendances->links() }}
        </div>
    @else
        <div class="py-5 text-center">
            <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-clock-history fs-3"></i>
            </div>
            <h3 class="h5 fw-bold mb-1">No Records Found</h3>
            <p class="text-muted small">No attendances have been found with the current filters.</p>
        </div>
    @endif
  </div>
</section>

@push('scripts')
<script>
    function showImage(imageUrl, title) {
        Swal.fire({
            title: title,
            imageUrl: imageUrl,
            imageWidth: '100%',
            imageAlt: 'Attendance Photo',
            confirmButtonColor: '#0a58ca',
            confirmButtonText: 'Close',
        });
    }

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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush