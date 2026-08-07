<?php
// Update index.blade.php
$content = file_get_contents('resources/views/admin/attendance/index.blade.php');
$search = <<<'EOD'
                @endforeach
            </select>
EOD;
$replace = <<<'EOD'
                @endforeach
                <option value="outside" {{ request('geofence') == 'outside' ? 'selected' : '' }}>Outside</option>
            </select>
EOD;
$content = str_replace($search, $replace, $content);
file_put_contents('resources/views/admin/attendance/index.blade.php', $content);

// Update today.blade.php
$content = file_get_contents('resources/views/admin/attendance/today.blade.php');
$content = str_replace($search, $replace, $content);
file_put_contents('resources/views/admin/attendance/today.blade.php', $content);

// Update delete.blade.php
$content = file_get_contents('resources/views/admin/attendance/delete.blade.php');
$content = str_replace($search, $replace, $content);
file_put_contents('resources/views/admin/attendance/delete.blade.php', $content);

// Update today_absent.blade.php
$content = file_get_contents('resources/views/admin/attendance/today_absent.blade.php');

$search1 = <<<'EOD'
  <div class="heading-actions d-flex gap-2">
    <form method="GET" action="{{ route('admin.attendances.today-absent') }}" class="d-flex align-items-center">
        <div class="input-group input-group-sm">
            <input type="text" name="employee_name" placeholder="Search by name..." value="{{ request('employee_name') }}" class="form-control">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-warning btn-sm d-flex align-items-center"><i class="bi bi-filetype-csv me-1" aria-hidden="true"></i> Export CSV</a>
  </div>
EOD;

$replace1 = <<<'EOD'
  <div class="heading-actions">
    <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-warning btn-sm d-flex align-items-center"><i class="bi bi-filetype-csv me-1" aria-hidden="true"></i> Export CSV</a>
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
    <form method="GET" id="filterForm" action="{{ route('admin.attendances.today-absent') }}" class="row g-3 align-items-end">
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
EOD;

$content = str_replace($search2, $replace2, $content);
file_put_contents('resources/views/admin/attendance/today_absent.blade.php', $content);

echo "Updated Blades\n";
?>
