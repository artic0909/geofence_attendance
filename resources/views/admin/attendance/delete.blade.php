@extends('admin.layout')
@section('header_title', 'Delete Attendances')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
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
            <select name="geofence" id="geofence" class="form-select select2">
                <option value="">All Geofences</option>
                @foreach($geofences as $geofence)
                <option value="{{ $geofence->id }}" {{ $selectedGeofence == $geofence->id ? 'selected' : '' }}>
                    {{ $geofence->name }}
                </option>
                @endforeach
                <option value="outside" {{ request('geofence') == 'outside' ? 'selected' : '' }}>Outside</option>
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
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="badge {{ $attendance->attendance_type == 'outside' ? 'text-bg-warning' : 'text-bg-success' }}">
                        {{ ucfirst($attendance->attendance_type) }}
                    </span>
                    @if(!empty($attendance->app_usages) && count($attendance->app_usages) > 0)
                    <div class="mt-1">
                        <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2 rounded-pill d-inline-flex align-items-center gap-1" style="font-size: 11px;" onclick="showAppUsage('{{ addslashes($attendance->employee->name) }}', {{ json_encode($attendance->app_usages) }})" title="View App Usage Record">
                            <i class="bi bi-phone"></i> App Usage ({{ count($attendance->app_usages) }})
                        </button>
                    </div>
                    @elseif($attendance->employee->phone_used_restricted)
                    <div class="mt-1">
                        <span class="badge text-bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25" style="font-size: 10px;" title="Phone Restriction Enabled">
                            <i class="bi bi-phone-vibrate me-1"></i> Monitored
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

    function showAppUsage(employeeName, usages) {
        if (!usages || (Array.isArray(usages) && usages.length === 0) || (typeof usages === 'object' && !Array.isArray(usages) && (!usages.summary || usages.summary.length === 0) && (!usages.before_lunch || usages.before_lunch.length === 0))) {
            Swal.fire({
                title: 'No App Usage Recorded',
                text: 'No external app activity was recorded during this session.',
                icon: 'info',
                confirmButtonColor: '#0a58ca'
            });
            return;
        }

        let isStructured = !Array.isArray(usages) && typeof usages === 'object';
        let summaryList = [];
        let lunchStart = isStructured ? (usages.lunch_start_time || null) : null;
        let lunchEnd = isStructured ? (usages.lunch_end_time || null) : null;

        if (isStructured) {
            summaryList = usages.summary || [];
        } else {
            summaryList = usages.map(app => ({
                app_name: app.app_name || app.package_name,
                package_name: app.package_name || '',
                before_lunch_seconds: app.usage_seconds || 0,
                before_lunch_formatted: app.usage_formatted || ((Math.floor((app.usage_seconds || 0) / 60)) + 'm ' + ((app.usage_seconds || 0) % 60) + 's'),
                after_lunch_seconds: 0,
                after_lunch_formatted: '0s',
                total_seconds: app.usage_seconds || 0,
                total_formatted: app.usage_formatted || ((Math.floor((app.usage_seconds || 0) / 60)) + 'm ' + ((app.usage_seconds || 0) % 60) + 's')
            }));
        }

        let totalBeforeSeconds = summaryList.reduce((acc, curr) => acc + (curr.before_lunch_seconds || 0), 0);
        let totalAfterSeconds = summaryList.reduce((acc, curr) => acc + (curr.after_lunch_seconds || 0), 0);
        let totalAllSeconds = summaryList.reduce((acc, curr) => acc + (curr.total_seconds || 0), 0);

        function fmtSec(sec) {
            let h = Math.floor(sec / 3600);
            let m = Math.floor((sec % 3600) / 60);
            let s = sec % 60;
            if (h > 0) return h + 'h ' + m + 'm';
            if (m > 0) return m + 'm ' + s + 's';
            return s + 's';
        }

        let tableRows = summaryList.map(item => {
            let pct = totalAllSeconds > 0 ? Math.round((item.total_seconds / totalAllSeconds) * 100) : 0;
            return `
                <tr>
                    <td class="align-middle text-start py-2">
                        <div class="fw-bold text-dark fs-7">${item.app_name || item.package_name}</div>
                        <small class="text-muted d-block font-monospace" style="font-size: 10px;">${item.package_name || ''}</small>
                    </td>
                    <td class="align-middle text-center py-2">
                        <span class="badge ${item.before_lunch_seconds > 0 ? 'bg-warning text-dark' : 'bg-light text-muted border'} px-2 py-1" style="font-size: 11px;">
                            ${item.before_lunch_seconds > 0 ? item.before_lunch_formatted : '-'}
                        </span>
                    </td>
                    <td class="align-middle text-center py-2">
                        <span class="badge ${item.after_lunch_seconds > 0 ? 'bg-info text-dark' : 'bg-light text-muted border'} px-2 py-1" style="font-size: 11px;">
                            ${item.after_lunch_seconds > 0 ? item.after_lunch_formatted : '-'}
                        </span>
                    </td>
                    <td class="align-middle text-end py-2">
                        <div class="fw-bold text-dark" style="font-size: 12px;">${item.total_formatted}</div>
                        <div class="progress mt-1 ms-auto" style="height: 4px; width: 65px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: ${pct}%" aria-valuenow="${pct}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        let lunchInfoHtml = '';
        if (lunchStart && lunchEnd) {
            function formatTime12(tStr) {
                if (!tStr) return '';
                let parts = tStr.split(':');
                if (parts.length < 2) return tStr;
                let h = parseInt(parts[0], 10);
                let m = parts[1];
                let ampm = h >= 12 ? 'PM' : 'AM';
                let h12 = h % 12;
                if (h12 === 0) h12 = 12;
                return (h12 < 10 ? '0' + h12 : h12) + ':' + m + ' ' + ampm;
            }
            lunchInfoHtml = `
                <div class="d-flex align-items-center justify-content-between bg-light border rounded px-3 py-1 mb-3 text-muted small">
                    <span><i class="bi bi-cup-hot me-1 text-warning"></i> Lunch Window: <strong>${formatTime12(lunchStart)} - ${formatTime12(lunchEnd)}</strong></span>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Tracking Paused During Lunch</span>
                </div>
            `;
        }

        Swal.fire({
            title: `<div class="d-flex align-items-center justify-content-center gap-2"><i class="bi bi-phone text-primary"></i><span>App Usage Breakdown</span></div>`,
            html: `
                <div class="text-start mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <div class="small text-muted text-uppercase fw-bold" style="font-size: 10px;">Employee</div>
                            <div class="fw-bold text-primary fs-6">${employeeName}</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted text-uppercase fw-bold" style="font-size: 10px;">Total Tracked Apps</div>
                            <span class="badge bg-dark">${summaryList.length} Apps</span>
                        </div>
                    </div>

                    ${lunchInfoHtml}

                    <div class="row g-2 mb-3 text-center">
                        <div class="col-4">
                            <div class="p-2 border rounded bg-warning bg-opacity-10 border-warning border-opacity-25">
                                <small class="d-block text-muted text-uppercase fw-bold" style="font-size: 9px;">Before Lunch</small>
                                <span class="fw-bold text-dark fs-7">${fmtSec(totalBeforeSeconds)}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-info bg-opacity-10 border-info border-info-opacity-25">
                                <small class="d-block text-muted text-uppercase fw-bold" style="font-size: 9px;">After Lunch</small>
                                <span class="fw-bold text-dark fs-7">${fmtSec(totalAfterSeconds)}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 border rounded bg-primary bg-opacity-10 border-primary border-opacity-25">
                                <small class="d-block text-primary text-uppercase fw-bold" style="font-size: 9px;">Total Screen Time</small>
                                <span class="fw-bold text-primary fs-7">${fmtSec(totalAllSeconds)}</span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive border rounded" style="max-height: 280px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle mb-0" style="font-size: 12px;">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="text-start py-2">App Name</th>
                                    <th class="text-center py-2">Before Lunch</th>
                                    <th class="text-center py-2">After Lunch</th>
                                    <th class="text-end py-2">Total Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tableRows}
                            </tbody>
                        </table>
                    </div>
                </div>
            `,
            width: '620px',
            confirmButtonColor: '#0a58ca',
            confirmButtonText: 'Close'
        });
    }

    document.getElementById('from_date').addEventListener('change', function() {
        document.getElementById('to_date').setAttribute('min', this.value);
    });
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