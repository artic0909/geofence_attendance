@extends('admin.layout')
@section('header_title', 'Employees Management')

@section('content')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 31px; /* match input-sm */
        padding: 2px 12px;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 30px;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
    }
</style>
@endpush
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Human Resources</p>
      <h1 class="h3 mb-1">Employees</h1>
      <p class="text-muted mb-0">Manage staff members and assign them to sites.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm d-flex align-items-center"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Employee</a>
  </div>
</div>

@php
    $admin = auth()->user();
    $activeSub = $admin->activeSubscription;
    $maxEmp = $activeSub ? $activeSub->employee_count : 0;
    $currentEmp = $admin->employees()->count();
    $percentage = $maxEmp > 0 ? min(100, ($currentEmp / $maxEmp) * 100) : 0;
    
    $progressClass = 'bg-success';
    if ($percentage >= 90) {
        $progressClass = 'bg-danger';
    } elseif ($percentage >= 75) {
        $progressClass = 'bg-warning text-dark';
    }
@endphp

<div class="card mt-3 shadow-sm border-0 rounded-3">
    <div class="card-body py-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-bold text-muted"><i class="bi bi-bar-chart-steps me-1"></i> Plan Usage</h6>
            <span class="badge text-bg-light border {{ $percentage >= 100 ? 'border-danger text-danger' : 'border-secondary text-secondary' }}">{{ $currentEmp }} / {{ $maxEmp }} Employees Used</span>
        </div>
        <div class="progress rounded-pill" style="height: 8px;">
            <div class="progress-bar {{ $progressClass }} progress-bar-striped" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @if($percentage >= 100)
            <small class="text-danger mt-2 d-block fw-semibold"><i class="bi bi-exclamation-circle-fill"></i> You have reached your employee limit. Please upgrade your plan to add more.</small>
        @endif
    </div>
</div>

<section class="panel mt-3 mb-4">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-funnel" aria-hidden="true"></i><span>Filter Records</span></h2>
    </div>
  </div>
  <div class="panel-body p-4">
    <form method="GET" id="filterForm" action="{{ route('admin.employees.index') }}" class="row g-3 align-items-end">
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
            <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Search by name..." value="{{ request('employee_name') ?? request('search') }}">
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" id="filterBtn" class="btn btn-primary flex-grow-1">Filter</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>
  </div>
</section>

<section class="panel">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Employee Directory</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    @if($employees->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Dept & Desig</th>
                    <th scope="col">Assigned Geofences</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $employee->name }}</td>
                    <td class="text-muted small">{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td class="font-monospace text-muted small">{{ $employee->employee_id }}</td>
                    <td>
                        <div class="fw-bold">{{ $employee->department ? $employee->department->name : 'N/A' }}</div>
                        <div class="text-muted small">{{ $employee->designation ? $employee->designation->name : 'N/A' }}</div>
                    </td>
                    <td>
                        @if($employee->employeeGeofences->count() > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($employee->employeeGeofences as $geofence)
                                    <span class="badge text-bg-light border border-primary text-primary">
                                        {{ $geofence->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-warning small fst-italic">No Sites Assigned</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $employee->is_active ? 'text-bg-success' : 'text-bg-danger' }} mb-1">
                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($employee->phone_used_restricted)
                            <br>
                            <span class="badge text-bg-secondary">
                                Phone Restricted
                            </span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-light btn-sm text-primary me-2"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light btn-sm text-danger delete-btn" data-item="employee"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-4 py-3 border-top">
            {{ $employees->links() }}
        </div>
    @else
        <div class="p-5 text-center">
            <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted mb-3 rounded-circle" style="width: 64px; height: 64px;">
                <i class="bi bi-people fs-3"></i>
            </div>
            <h3 class="h5 fw-bold mb-1">No employees found</h3>
            <p class="text-muted small">Try adjusting your search or add a new staff member.</p>
            <div class="mt-3">
                <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add Employee
                </a>
            </div>
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