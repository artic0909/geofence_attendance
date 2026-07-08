@extends('admin.layout')
@section('header_title', 'Employees Management')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Human Resources</p>
      <h1 class="h3 mb-1">Employees</h1>
      <p class="text-muted mb-0">Manage staff members and assign them to sites.</p>
    </div>
  </div>
  <div class="heading-actions d-flex gap-2">
    <form action="{{ route('admin.employees.index') }}" method="GET" class="d-flex align-items-center">
        <div class="input-group input-group-sm me-2">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff..." class="form-control border-start-0 ps-0">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
        @if(request('search'))
            <a href="{{ route('admin.employees.index') }}" class="btn btn-link btn-sm text-danger text-decoration-none px-0">Clear</a>
        @endif
    </form>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm d-flex align-items-center"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Employee</a>
  </div>
</div>

<section class="panel mt-3">
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
                            <button type="submit" class="btn btn-light btn-sm text-danger" onclick="return confirm('Delete this employee?')"><i class="bi bi-trash"></i> Delete</button>
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