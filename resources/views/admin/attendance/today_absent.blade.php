@extends('admin.layout')
@section('header_title', 'Missing Check-ins Today')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-x" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Reports</p>
      <h1 class="h3 mb-1">Missing Check-ins Today</h1>
      <p class="text-muted mb-0">Employees who have not logged attendance yet.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-warning btn-sm d-flex align-items-center"><i class="bi bi-filetype-csv me-1" aria-hidden="true"></i> Export CSV</a>
  </div>
</div>

<section class="panel mt-3 mb-4">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-funnel" aria-hidden="true"></i><span>Filter Records</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form method="GET" id="filterForm" action="{{ route('admin.attendances.today-absent') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="geofence" class="form-label fw-bold small">Site / Geofence</label>
            <select name="geofence" id="geofence" class="form-select select2">
                <option value="">All Sites</option>
                @foreach($geofences as $geofence)
                <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                    {{ $geofence->name }}
                </option>
                @endforeach
                <option value="outside" {{ request('geofence') == 'outside' ? 'selected' : '' }}>Outside</option>
            </select>
        </div>

        <div class="col-md-5">
            <label for="employee_name" class="form-label fw-bold small">Employee Name</label>
            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Search by name..." value="{{ request('employee_name') }}">
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" id="filterBtn" class="btn btn-primary flex-grow-1">Filter</button>
            <a href="{{ route('admin.attendances.today-absent') }}" class="btn btn-light">Reset</a>
        </div>
    </form>
  </div>
</section>

<section class="panel">
  <div class="panel-header">
    <div class="d-flex align-items-center gap-2">
      <h2 class="h5 mb-1 section-title mb-0"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Pending Attendance</span></h2>
      <span class="badge text-bg-danger rounded-pill">{{ $pending_employees->total() }}</span>
    </div>
  </div>
  <div class="table-responsive">
    @if($pending_employees->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Employee</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Assigned Sites</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pending_employees as $employee)
                <tr>
                    <td>{{ ($pending_employees->currentPage() - 1) * $pending_employees->perPage() + $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold text-primary">{{ $employee->name }}</div>
                        <div class="small text-muted mt-1">ID: {{ $employee->employee_id ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $employee->phone }}</div>
                        <div class="small text-muted">{{ $employee->email }}</div>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @forelse($employee->employeeGeofences as $geofence)
                                <span class="badge bg-light border text-dark">
                                    {{ $geofence->name }}
                                </span>
                            @empty
                                <span class="text-muted small fst-italic">No Sites</span>
                            @endforelse
                        </div>
                    </td>
                    <td>
                        <span class="badge text-bg-danger">
                            <i class="bi bi-x-circle me-1"></i> Absent
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-4 py-3 border-top">
            {{ $pending_employees->appends(request()->query())->links() }}
        </div>
    @else
        <div class="py-5 text-center">
            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-check2-circle fs-3"></i>
            </div>
            <h3 class="h5 fw-bold mb-1">Excellent!</h3>
            <p class="text-muted small">Every active employee has checked in today or no employees match your search.</p>
        </div>
    @endif
  </div>
</section>
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