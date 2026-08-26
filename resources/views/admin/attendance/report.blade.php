@extends('admin.layout')
@section('header_title', 'Salary Report Generate')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
    <div>
      <h1 class="h3 mb-1">Salary Report Generate</h1>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.attendance.report') }}" method="GET" class="row g-3 align-items-end">
            <!-- Geofence Filter -->
            <div class="col-md-3">
                <label for="geofence" class="form-label small text-muted fw-bold">Site (Geofence)</label>
                <select name="geofence" id="geofence" class="form-select select2 border-0 bg-light">
                    <option value="all">All Sites</option>
                    @foreach($geofences as $geofence)
                        <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                            {{ $geofence->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Filter -->
            <div class="col-md-3">
                <label for="employee_id" class="form-label small text-muted fw-bold">Employee <span class="text-danger">*</span></label>
                <select name="employee_id" id="employee_id" class="form-select select2 border-0 bg-light">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->employee_id }} - {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div class="col-md-2">
                <label for="from_date" class="form-label small text-muted fw-bold">From Date <span class="text-danger">*</span></label>
                <input type="date" name="from_date" id="from_date" class="form-control border-0 bg-light" value="{{ request('from_date', now()->startOfMonth()->format('Y-m-d')) }}" required>
            </div>

            <!-- Date To -->
            <div class="col-md-2">
                <label for="to_date" class="form-label small text-muted fw-bold">To Date <span class="text-danger">*</span></label>
                <input type="date" name="to_date" id="to_date" class="form-control border-0 bg-light" value="{{ request('to_date', now()->endOfMonth()->format('Y-m-d')) }}" required>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Generate</button>
            </div>
        </form>
    </div>
</div>

@if($selectedEmployee && count($reportData) > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-secondary">Report for {{ $selectedEmployee->name }}</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 text-start">Date</th>
                        <th>Present</th>
                        <th>OT (Hours)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $row)
                    <tr>
                        <td class="ps-4 text-start fw-semibold">{{ $row['date'] }}</td>
                        <td>
                            @if($row['status'] == 'P')
                                <span class="fw-bold text-success">P</span>
                            @else
                                <span class="fw-bold text-danger">A</span>
                            @endif
                        </td>
                        <td>{{ $row['ot'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td class="ps-4 text-start">Totals</td>
                        <td>
                            <span class="text-success me-3">Total P: {{ $totals['P'] }}</span>
                            <span class="text-danger">Total A: {{ $totals['A'] }}</span>
                        </td>
                        <td>Total OT: {{ $totals['OT'] }} h</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@elseif(request()->has('from_date') && request()->has('to_date'))
<div class="alert alert-info border-0 shadow-sm mt-4">
    @if(empty(request('employee_id')))
        Please select an employee to generate the report.
    @else
        No attendance records found for the selected date range.
    @endif
</div>
@endif

</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });

        // Ensure auto-submit works with select2 for geofence
        $('#geofence').on('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush
