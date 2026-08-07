<?php
$content = file_get_contents('resources/views/admin/employees/index.blade.php');

$search1 = <<<'EOD'
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
EOD;

$replace1 = <<<'EOD'
  <div class="heading-actions">
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm d-flex align-items-center"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Employee</a>
  </div>
EOD;

$content = str_replace($search1, $replace1, $content);

$search2 = <<<'EOD'
<section class="panel mt-3">
  <div class="panel-header">
EOD;

$replace2 = <<<'EOD'
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
            <select name="geofence" id="geofence" class="form-select">
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
EOD;

$content = str_replace($search2, $replace2, $content);
file_put_contents('resources/views/admin/employees/index.blade.php', $content);

echo "Updated Employee Blade\n";
?>
