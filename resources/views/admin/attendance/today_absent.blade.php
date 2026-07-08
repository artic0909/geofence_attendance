@extends('admin.layout')
@section('header_title', 'Missing Check-ins Today')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-x" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Reports</p>
      <h1 class="h3 mb-1">Missing Check-ins Today</h1>
      <p class="text-muted mb-0">Employees who have not logged attendance yet.</p>
    </div>
  </div>
  <div class="heading-actions d-flex gap-2">
    <form method="GET" action="{{ route('admin.attendances.today-absent') }}" class="d-flex align-items-center">
        <div class="input-group input-group-sm">
            <input type="text" name="employee_name" placeholder="Search by name..." value="{{ request('employee_name') }}" class="form-control">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-warning btn-sm d-flex align-items-center"><i class="bi bi-filetype-csv me-1" aria-hidden="true"></i> Export CSV</a>
  </div>
</div>

<section class="panel mt-3">
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
