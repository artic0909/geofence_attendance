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
            <!-- Designation Filter -->
            <div class="col-md-3">
                <label for="designation" class="form-label small text-muted fw-bold">Designation</label>
                <select name="designation" id="designation" class="form-select select2 border-0 bg-light">
                    <option value="all">All Designations</option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}" {{ request('designation') == $designation->id ? 'selected' : '' }}>
                            {{ $designation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Filter (Optional) -->
            <div class="col-md-3">
                <label for="employee_id" class="form-label small text-muted fw-bold">Employee <span class="text-secondary">(Optional)</span></label>
                <select name="employee_id" id="employee_id" class="form-select select2 border-0 bg-light">
                    <option value="all">All Employees</option>
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

@if(isset($reportData) && count($reportData) > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-secondary">Employee Summary</h6>
            <p class="text-muted small mb-0 mt-1">Period: {{ \Carbon\Carbon::parse(request('from_date'))->format('d M, Y') }} to {{ \Carbon\Carbon::parse(request('to_date'))->format('d M, Y') }}</p>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 text-start">Employee Name</th>
                        <th>Emp ID</th>
                        <th>Designation</th>
                        <th>Total P</th>
                        <th>Total A</th>
                        <th>Total OT</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $empId => $data)
                    <tr>
                        <td class="ps-4 text-start fw-semibold">{{ $data['employee']->name }}</td>
                        <td>{{ $data['employee']->employee_id ?? '-' }}</td>
                        <td>{{ $data['employee']->designation->name ?? '-' }}</td>
                        <td class="fw-bold text-success">{{ $data['totals']['P'] }}</td>
                        <td class="fw-bold text-danger">{{ $data['totals']['A'] }}</td>
                        <td class="fw-bold text-warning">{{ $data['totals']['OT'] }} h</td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewEmployeeReport({{ $empId }})">
                                <i class="bi bi-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@elseif(request()->has('from_date') && request()->has('to_date'))
<div class="alert alert-info border-0 shadow-sm mt-4">
    No attendance records found for the selected criteria.
</div>
@endif

</div>

<!-- Employee Details Modal -->
<div class="modal fade" id="employeeReportModal" tabindex="-1" aria-labelledby="employeeReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <div>
                    <h5 class="modal-title fw-bold text-primary mb-1" id="employeeReportModalLabel">Employee Attendance & Salary</h5>
                    <p class="text-muted small mb-0" id="modalPeriodText"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                
                <div class="row g-4 mb-4">
                    <!-- Employee Info -->
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Employee Details</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted" style="width: 100px;">Name:</td>
                                        <td class="fw-bold text-dark fs-6" id="modalEmpName"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Emp ID:</td>
                                        <td class="fw-semibold text-secondary" id="modalEmpId"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Phone:</td>
                                        <td class="fw-semibold text-secondary" id="modalEmpPhone"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="col-md-7">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Attendance Summary</h6>
                                <div class="row text-center g-3">
                                    <div class="col-4">
                                        <div class="bg-success bg-opacity-10 rounded p-3 border border-success border-opacity-25 h-100">
                                            <h3 class="text-success mb-1 fw-bold" id="modalTotalP">0</h3>
                                            <span class="small text-success fw-semibold text-uppercase">Total Present</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-danger bg-opacity-10 rounded p-3 border border-danger border-opacity-25 h-100">
                                            <h3 class="text-danger mb-1 fw-bold" id="modalTotalA">0</h3>
                                            <span class="small text-danger fw-semibold text-uppercase">Total Absent</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-warning bg-opacity-10 rounded p-3 border border-warning border-opacity-25 h-100">
                                            <h3 class="text-warning mb-1 fw-bold"><span id="modalTotalOT">0</span><span class="fs-6">h</span></h3>
                                            <span class="small text-warning fw-semibold text-uppercase">Total OT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Calculator -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold text-secondary">Salary Calculator</h6>
                    </div>
                    <div class="card-body p-4 bg-white rounded-bottom">
                        <div class="row align-items-center g-4">
                            <!-- Inputs -->
                            <div class="col-md-5">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="daily_amount" class="form-label small text-muted fw-bold text-uppercase">Daily Amount (₹)</label>
                                        <div class="input-group input-group-lg shadow-sm">
                                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-currency-rupee"></i></span>
                                            <input type="number" step="0.01" id="daily_amount" class="form-control border-start-0 ps-0 fw-bold" placeholder="0" oninput="calculateSalary()">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="ot_amount" class="form-label small text-muted fw-bold text-uppercase">OT Per Hour (₹)</label>
                                        <div class="input-group input-group-lg shadow-sm">
                                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-currency-rupee"></i></span>
                                            <input type="number" step="0.01" id="ot_amount" class="form-control border-start-0 ps-0 fw-bold" placeholder="0" oninput="calculateSalary()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Live Results -->
                            <div class="col-md-7">
                                <div class="d-flex justify-content-between align-items-center bg-light p-4 rounded-3 border shadow-sm h-100">
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
                <div class="card border-0 shadow-sm">
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
                                <tbody id="modalTableBody">
                                    <!-- Populated via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Prepare JSON data for JS
    const reportData = @json($reportData ?? []);
    let currentEmployeeId = null;

    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });

        $('#designation').on('change', function() {
            this.form.submit();
        });
    });

    function viewEmployeeReport(empId) {
        const data = reportData[empId];
        if(!data) return;

        currentEmployeeId = empId;

        // Populate header & info
        const fromDateStr = "{{ request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('d M, Y') : '' }}";
        const toDateStr = "{{ request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('d M, Y') : '' }}";
        document.getElementById('modalPeriodText').innerText = `Period: ${fromDateStr} to ${toDateStr}`;
        
        document.getElementById('modalEmpName').innerText = data.employee.name;
        document.getElementById('modalEmpId').innerText = data.employee.employee_id || 'N/A';
        document.getElementById('modalEmpPhone').innerText = data.employee.phone || 'N/A';
        
        // Populate Totals
        document.getElementById('modalTotalP').innerText = data.totals.P;
        document.getElementById('modalTotalA').innerText = data.totals.A;
        document.getElementById('modalTotalOT').innerText = Number(parseFloat(data.totals.OT).toFixed(2));

        // Populate Salary Calculator Default Values
        document.getElementById('daily_amount').value = data.employee.daily_rate_amount || '';
        document.getElementById('ot_amount').value = data.employee.ot_rate_amount || '';
        calculateSalary();

        // Populate Table
        const tbody = document.getElementById('modalTableBody');
        tbody.innerHTML = '';
        data.dayByDay.forEach(row => {
            const tr = document.createElement('tr');
            
            const tdDate = document.createElement('td');
            tdDate.className = 'ps-4 text-start fw-semibold';
            tdDate.innerText = row.date;

            const tdStatus = document.createElement('td');
            if(row.status === 'P') {
                tdStatus.innerHTML = '<span class="fw-bold text-success">P</span>';
            } else {
                tdStatus.innerHTML = '<span class="fw-bold text-danger">A</span>';
            }

            const tdHours = document.createElement('td');
            tdHours.innerText = row.hours;

            const tdOt = document.createElement('td');
            tdOt.innerText = row.ot;

            tr.appendChild(tdDate);
            tr.appendChild(tdStatus);
            tr.appendChild(tdHours);
            tr.appendChild(tdOt);
            tbody.appendChild(tr);
        });

        // Show Modal
        const modal = new bootstrap.Modal(document.getElementById('employeeReportModal'));
        modal.show();
    }

    function calculateSalary() {
        if(!currentEmployeeId || !reportData[currentEmployeeId]) return;
        
        const totals = reportData[currentEmployeeId].totals;
        
        const totalP = totals.P;
        const totalOT = totals.OT;
        
        const dailyAmount = parseFloat(document.getElementById('daily_amount').value) || 0;
        const otAmount = parseFloat(document.getElementById('ot_amount').value) || 0;
        
        const totalDailySalary = totalP * dailyAmount;
        const totalOTSalary = totalOT * otAmount;
        const grandTotal = totalDailySalary + totalOTSalary;
        
        const formatCurrency = (amount) => {
            return '₹' + amount.toLocaleString('en-IN', { maximumFractionDigits: 2 });
        };
        
        document.getElementById('total_daily_salary').innerText = formatCurrency(totalDailySalary);
        document.getElementById('total_ot_salary').innerText = formatCurrency(totalOTSalary);
        document.getElementById('grand_total').innerText = formatCurrency(grandTotal);
    }
</script>
@endpush
