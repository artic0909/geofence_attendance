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
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

@if($selectedEmployee && count($reportData) > 0)
<!-- Professional Report Header & Summary -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <!-- Title & Actions -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-primary">Salary & Attendance Report</h4>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar-range me-1"></i> 
                    Period: <span class="fw-semibold">{{ \Carbon\Carbon::parse(request('from_date'))->format('d M, Y') }}</span> to <span class="fw-semibold">{{ \Carbon\Carbon::parse(request('to_date'))->format('d M, Y') }}</span>
                </p>
            </div>
            <!-- <div class="text-end">
                <button class="btn btn-success btn-sm"><i class="bi bi-download me-1"></i> Generate Report</button>
            </div> -->
        </div>

        <!-- Employee Info & Summary Stats -->
        <div class="row align-items-center">
            <!-- Employee Details -->
            <div class="col-md-5">
                <h6 class="text-muted text-uppercase small fw-bold mb-3">Employee Details</h6>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width: 100px;">Name:</td>
                        <td class="fw-bold text-dark fs-6">{{ $selectedEmployee->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Emp ID:</td>
                        <td class="fw-semibold text-secondary">{{ $selectedEmployee->employee_id ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Phone:</td>
                        <td class="fw-semibold text-secondary">{{ $selectedEmployee->phone ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Summary Stats -->
            <div class="col-md-7 border-start">
                <h6 class="text-muted text-uppercase small fw-bold mb-3 ps-3">Attendance Summary</h6>
                <div class="row text-center g-3 ps-2">
                    <div class="col-4">
                        <div class="bg-success bg-opacity-10 rounded p-3 border border-success border-opacity-25 h-100">
                            <h3 class="text-success mb-1 fw-bold">{{ $totals['P'] }}</h3>
                            <span class="small text-success fw-semibold text-uppercase">Total Present</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-danger bg-opacity-10 rounded p-3 border border-danger border-opacity-25 h-100">
                            <h3 class="text-danger mb-1 fw-bold">{{ $totals['A'] }}</h3>
                            <span class="small text-danger fw-semibold text-uppercase">Total Absent</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="bg-warning bg-opacity-10 rounded p-3 border border-warning border-opacity-25 h-100">
                            <h3 class="text-warning mb-1 fw-bold">{{ $totals['OT'] }}<span class="fs-6">h</span></h3>
                            <span class="small text-warning fw-semibold text-uppercase">Total OT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Salary Calculator -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-secondary">Salary Calculator</h6>
    </div>
    <div class="card-body p-4 bg-light rounded-bottom">
        <div class="row align-items-center g-4">
            <!-- Inputs -->
            <div class="col-md-5">
                <div class="row g-3">
                    <div class="col-6">
                        <label for="daily_amount" class="form-label small text-muted fw-bold text-uppercase">Daily Amount (₹)</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-currency-rupee"></i></span>
                            <input type="number" id="daily_amount" class="form-control border-start-0 ps-0 fw-bold" placeholder="0" oninput="calculateSalary()">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="ot_amount" class="form-label small text-muted fw-bold text-uppercase">OT Per Hour (₹)</label>
                        <div class="input-group input-group-lg shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-currency-rupee"></i></span>
                            <input type="number" id="ot_amount" class="form-control border-start-0 ps-0 fw-bold" placeholder="0" oninput="calculateSalary()">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Live Results -->
            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-3 border shadow-sm h-100">
                    <div class="text-center px-3">
                        <p class="text-muted small fw-bold mb-2 text-uppercase">Total Daily Salary</p>
                        <h4 class="mb-0 text-dark fw-bold font-monospace" id="total_daily_salary">₹0</h4>
                    </div>
                    <div class="text-center px-3 border-start border-end">
                        <p class="text-muted small fw-bold mb-2 text-uppercase">Total OT Salary</p>
                        <h4 class="mb-0 text-dark fw-bold font-monospace" id="total_ot_salary">₹0</h4>
                    </div>
                    <div class="text-center px-3">
                        <p class="text-primary small fw-bold mb-2 text-uppercase">Grand Total</p>
                        <h3 class="mb-0 text-primary fw-bold font-monospace" id="grand_total">₹0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Table -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-secondary">Detailed Log</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 text-start">Date</th>
                        <th>Present</th>
                        <th>Daily Hours</th>
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
                        <td>{{ $row['hours'] }}</td>
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
                        <td></td>
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

    @if($selectedEmployee && count($reportData) > 0)
    function calculateSalary() {
        const totalP = {{ $totals['P'] }};
        const totalOT = {{ $totals['OT'] }};
        
        const dailyAmount = parseFloat(document.getElementById('daily_amount').value) || 0;
        const otAmount = parseFloat(document.getElementById('ot_amount').value) || 0;
        
        const totalDailySalary = totalP * dailyAmount;
        const totalOTSalary = totalOT * otAmount;
        const grandTotal = totalDailySalary + totalOTSalary;
        
        // Format as Indian Rupee without decimal if it's a whole number, or with 2 decimals
        const formatCurrency = (amount) => {
            return '₹' + amount.toLocaleString('en-IN', { maximumFractionDigits: 2 });
        };
        
        document.getElementById('total_daily_salary').innerText = formatCurrency(totalDailySalary);
        document.getElementById('total_ot_salary').innerText = formatCurrency(totalOTSalary);
        document.getElementById('grand_total').innerText = formatCurrency(grandTotal);
    }
    @endif
</script>
@endpush
