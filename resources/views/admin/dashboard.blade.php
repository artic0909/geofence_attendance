@extends('admin.layout')
@section('header_title', 'Dashboard')

@push('styles')
<style>
  /* Premium Dashboard Styles */
  .dash-card {
    background: var(--admin-surface, #ffffff);
    border: 1px solid var(--admin-border, #e5e7eb);
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .dash-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
  }
  .dash-card-header {
    padding: 1.15rem 1.35rem 0.85rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--admin-border, #f1f5f9);
  }
  .dash-card-body {
    padding: 1.25rem 1.35rem;
  }
  .dash-card-title {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--admin-text, #1f2937);
  }
  .dash-card-subtitle {
    font-size: 0.8rem;
    color: var(--admin-muted, #6b7280);
    margin-top: 0.2rem;
  }
  
  /* Filter Card */
  .filter-panel {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.04) 0%, rgba(15, 118, 110, 0.04) 100%);
    border: 1px solid var(--admin-border, #dbe4ef);
    border-radius: 14px;
    padding: 0.9rem 1.25rem;
  }

  /* Metric KPI Cards */
  .kpi-card {
    background: var(--admin-surface, #ffffff);
    border: 1px solid var(--admin-border, #e5e7eb);
    border-radius: 14px;
    padding: 1.25rem;
    position: relative;
    overflow: hidden;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
  }
  .kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
  }
  .kpi-card.kpi-primary::before { background: linear-gradient(90deg, #2563eb, #3b82f6); }
  .kpi-card.kpi-success::before { background: linear-gradient(90deg, #059669, #10b981); }
  .kpi-card.kpi-warning::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
  .kpi-card.kpi-danger::before { background: linear-gradient(90deg, #dc2626, #ef4444); }
  .kpi-card.kpi-info::before { background: linear-gradient(90deg, #0284c7, #06b6d4); }
  .kpi-card.kpi-purple::before { background: linear-gradient(90deg, #7c3aed, #a855f7); }

  .kpi-icon-box {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
  }
  .kpi-primary .kpi-icon-box { background: rgba(37, 99, 235, 0.12); color: #2563eb; }
  .kpi-success .kpi-icon-box { background: rgba(16, 185, 129, 0.12); color: #059669; }
  .kpi-warning .kpi-icon-box { background: rgba(245, 158, 11, 0.12); color: #d97706; }
  .kpi-danger .kpi-icon-box { background: rgba(239, 68, 68, 0.12); color: #dc2626; }
  .kpi-info .kpi-icon-box { background: rgba(6, 182, 212, 0.12); color: #0284c7; }
  .kpi-purple .kpi-icon-box { background: rgba(168, 85, 247, 0.12); color: #7c3aed; }

  .kpi-title {
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: var(--admin-muted, #6b7280);
    margin-bottom: 0.35rem;
  }
  .kpi-number {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1.2;
    color: var(--admin-text, #111827);
  }
  .kpi-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.2rem 0.55rem;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
  }

  /* Subscription Banner */
  .sub-banner {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 14px;
    color: #ffffff;
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    position: relative;
    overflow: hidden;
  }
  .sub-banner::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, transparent 70%);
    pointer-events: none;
  }

  /* Chart Containers */
  .chart-container-lg {
    position: relative;
    height: 360px;
    width: 100%;
  }
  .chart-container-md {
    position: relative;
    height: 290px;
    width: 100%;
  }

  /* Live Feed Table */
  .activity-table th {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    color: var(--admin-muted, #6b7280);
    padding: 0.85rem 1rem;
    border-bottom: 1px solid var(--admin-border, #e5e7eb);
  }
  .activity-table td {
    padding: 0.85rem 1rem;
    vertical-align: middle;
    font-size: 0.875rem;
    border-bottom: 1px solid var(--admin-border, #f1f5f9);
  }

  /* Dark mode overrides */
  [data-theme="dark"] .dash-card,
  [data-theme="dark"] .kpi-card {
    background: var(--admin-surface, #1f2937) !important;
    border-color: var(--admin-border, #374151) !important;
  }
  [data-theme="dark"] .kpi-number,
  [data-theme="dark"] .dash-card-title {
    color: #f3f4f6 !important;
  }
  [data-theme="dark"] .dash-card-header,
  [data-theme="dark"] .activity-table th,
  [data-theme="dark"] .activity-table td {
    border-color: #374151 !important;
  }
  [data-theme="dark"] .filter-panel {
    background: rgba(31, 41, 55, 0.6) !important;
    border-color: #374151 !important;
  }
</style>
@endpush

@section('content')
<div class="mb-4">
  <!-- Top Header & Filter Toolbar -->
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span class="badge bg-primary text-white px-2 py-1 rounded-pill small fw-semibold">
          <i class="bi bi-shield-check me-1"></i> Admin Panel
        </span>
        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
          <i class="bi bi-funnel me-1"></i> Showing: <strong class="text-primary">{{ $filterLabel }}</strong>
        </span>
      </div>
      <h1 class="h3 fw-bold mb-1 text-gray-800 dark:text-white">Organization Dashboard</h1>
      <p class="text-muted mb-0 small">Real-time attendance analytics, geofence distribution, and employee performance overview.</p>
    </div>

    <!-- Month & Year Dual Dropdown Filter Form -->
    <div class="filter-panel d-flex flex-wrap align-items-center gap-3">
      <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 m-0" id="filterForm">
        <!-- Month Dropdown -->
        <div class="d-flex align-items-center gap-1">
          <label for="monthSelect" class="form-label mb-0 small fw-bold text-nowrap text-muted">
            <i class="bi bi-calendar-month text-primary me-1"></i>Month:
          </label>
          <select name="month" id="monthSelect" class="form-select form-select-sm shadow-sm" style="min-width: 130px;" onchange="this.form.submit()">
            <option value="all" {{ $selectedMonth === 'all' ? 'selected' : '' }}>All Months</option>
            @foreach($monthsList as $mNum => $mName)
              <option value="{{ $mNum }}" {{ $selectedMonth === $mNum ? 'selected' : '' }}>
                {{ $mName }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Year Dropdown -->
        <div class="d-flex align-items-center gap-1">
          <label for="yearSelect" class="form-label mb-0 small fw-bold text-nowrap text-muted">
            <i class="bi bi-calendar3 text-primary me-1"></i>Year:
          </label>
          <select name="year" id="yearSelect" class="form-select form-select-sm shadow-sm" style="min-width: 110px;" onchange="this.form.submit()">
            <option value="all" {{ $selectedYear === 'all' ? 'selected' : '' }}>All Years</option>
            @foreach($availableYears as $yVal)
              <option value="{{ $yVal }}" {{ $selectedYear == $yVal ? 'selected' : '' }}>
                {{ $yVal }}
              </option>
            @endforeach
          </select>
        </div>

        @if($isFiltered)
          <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary shadow-sm" title="Reset to All / All">
            <i class="bi bi-x-circle me-1"></i> Reset
          </a>
        @endif
      </form>

      <div class="border-start ps-3 d-none d-sm-block">
        <a href="{{ route('admin.dashboard.export-pending') }}" class="btn btn-sm btn-danger shadow-sm text-nowrap fw-semibold">
          <i class="bi bi-download me-1"></i> Export Pending
        </a>
      </div>
    </div>
  </div>

  <!-- Subscription Status Banner -->
  <div class="sub-banner p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index: 2;">
      <div>
        <div class="d-flex align-items-center gap-2 mb-2">
          <h3 class="h5 fw-bold mb-0 text-white">{{ auth()->user()->business_name }}</h3>
          <span class="badge {{ auth()->user()->subscription_status === 'active' ? 'bg-success' : 'bg-danger' }} text-uppercase px-2 py-1 rounded-pill" style="font-size: 0.72rem;">
            ● {{ auth()->user()->subscription_status ?? 'Inactive' }}
          </span>
        </div>
        <p class="text-gray-300 small mb-0">
          Plan: <strong class="text-white">{{ $current_plan->plan_name ?? 'Standard / Active' }}</strong> &nbsp;|&nbsp; 
          Expires on: <strong class="text-white">{{ auth()->user()->subscription_expires_at ? \Carbon\Carbon::parse(auth()->user()->subscription_expires_at)->format('M d, Y') : 'Lifetime' }}</strong>
        </p>
      </div>

      <div class="d-flex align-items-center gap-3">
        @if(!$subscription['is_expired'])
          <div class="text-md-end">
            <span class="d-block small text-gray-300 fw-semibold">Subscription Validity</span>
            <span class="badge bg-primary bg-opacity-75 text-white px-3 py-2 rounded-pill fw-bold">
              <i class="bi bi-clock-history me-1"></i> {{ $subscription['days_left'] }} Days Left
            </span>
          </div>
        @endif

        @if(auth()->user()->subscription_status !== 'active' || $subscription['days_left'] < 7)
          <a href="{{ route('pricing') }}" class="btn btn-warning btn-sm fw-bold px-3 py-2 shadow-sm text-dark">
            <i class="bi bi-arrow-repeat me-1"></i> Renew Plan
          </a>
        @endif
      </div>
    </div>

    @if(!$subscription['is_expired'])
      <div class="mt-3 pt-2 border-top border-secondary border-opacity-25 position-relative" style="z-index: 2;">
        <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.15);">
          <div class="progress-bar {{ $subscription['percentage'] > 90 ? 'bg-danger' : ($subscription['percentage'] > 70 ? 'bg-warning' : 'bg-success') }}" 
               role="progressbar" 
               style="width: {{ $subscription['percentage'] }}%" 
               aria-valuenow="{{ $subscription['percentage'] }}" 
               aria-valuemin="0" 
               aria-valuemax="100">
          </div>
        </div>
      </div>
    @endif
  </div>

  <!-- Primary Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <!-- Total Employees -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-primary">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">Total Staff</span>
          <div class="kpi-icon-box"><i class="bi bi-people-fill"></i></div>
        </div>
        <div>
          <div class="kpi-number">{{ $stats['total_employees'] }}</div>
          <div class="mt-2 d-flex align-items-center gap-1">
            <span class="kpi-badge bg-success bg-opacity-10 text-success">
              <i class="bi bi-check-circle-fill"></i> {{ $stats['active_employees'] }} Active
            </span>
            @if($stats['inactive_employees'] > 0)
              <span class="kpi-badge bg-secondary bg-opacity-10 text-muted">
                {{ $stats['inactive_employees'] }} Inactive
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Period Attendance Count -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-success">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">{{ $isFiltered ? 'Filtered Check-ins' : 'Total Check-ins' }}</span>
          <div class="kpi-icon-box"><i class="bi bi-check2-circle"></i></div>
        </div>
        <div>
          <div class="kpi-number">{{ number_format($stats['period_total_attendance']) }}</div>
          <div class="mt-2 d-flex align-items-center gap-1">
            <span class="kpi-badge bg-primary bg-opacity-10 text-primary" title="On-Site Geofence check-ins">
              <i class="bi bi-geo-alt-fill"></i> {{ $stats['period_inside'] }} Site
            </span>
            <span class="kpi-badge bg-info bg-opacity-10 text-info" title="Outside / Field duty check-ins">
              <i class="bi bi-compass"></i> {{ $stats['period_outside'] }} Field
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Today's Live Attendance -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-info">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">Today's Presence</span>
          <div class="kpi-icon-box"><i class="bi bi-calendar-check-fill"></i></div>
        </div>
        <div>
          <div class="kpi-number">{{ $stats['today_attendances'] }}</div>
          <div class="mt-2 d-flex align-items-center gap-1">
            <span class="kpi-badge bg-success bg-opacity-10 text-success">
              {{ $stats['today_rate'] }}% Rate
            </span>
            <span class="kpi-badge bg-danger bg-opacity-10 text-danger">
              {{ $stats['today_absents'] }} Absent
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Checkout Completion Rate -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-purple">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">Checkout Rate</span>
          <div class="kpi-icon-box"><i class="bi bi-box-arrow-right"></i></div>
        </div>
        <div>
          <div class="kpi-number">{{ $stats['checkout_completion_rate'] }}%</div>
          <div class="mt-2">
            <span class="kpi-badge bg-purple bg-opacity-10 text-purple" style="color: #7c3aed;">
              <i class="bi bi-check-all"></i> {{ $stats['period_checkouts'] }} Checked Out
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Sites / Geofences -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-warning">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">Sites & Zones</span>
          <div class="kpi-icon-box"><i class="bi bi-geo-alt"></i></div>
        </div>
        <div>
          <div class="kpi-number">{{ $stats['total_geofences'] }}</div>
          <div class="mt-2 d-flex align-items-center gap-1">
            <span class="kpi-badge bg-warning bg-opacity-10 text-warning">
              <i class="bi bi-building"></i> {{ $stats['total_departments'] }} Depts
            </span>
            <span class="kpi-badge bg-secondary bg-opacity-10 text-muted">
              {{ $stats['total_designations'] }} Roles
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Payments -->
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
      <div class="kpi-card kpi-danger">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="kpi-title">{{ $isFiltered ? 'Filtered Billing' : 'Total Billing' }}</span>
          <div class="kpi-icon-box"><i class="bi bi-currency-rupee"></i></div>
        </div>
        <div>
          <div class="kpi-number">₹{{ number_format($stats['total_payments'], 0) }}</div>
          <div class="mt-2">
            <a href="{{ route('admin.transactions.index') }}" class="kpi-badge bg-danger bg-opacity-10 text-danger text-decoration-none">
              <i class="bi bi-receipt"></i> View Invoices
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 1: Main Attendance Trend & Mode Distribution Chart -->
  <div class="row g-4 mb-4">
    <!-- Attendance Trend Spline Area Chart (8 cols) -->
    <div class="col-12 col-xl-8">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-graph-up-arrow text-primary"></i> Attendance Volume & Trends
            </h2>
            <p class="dash-card-subtitle">
              {{ $isFiltered ? "Attendance timeline overview for {$filterLabel}" : "Monthly attendance pattern over the past 12 months" }}
            </p>
          </div>
          <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small fw-semibold">
            {{ $selectedMonth !== 'all' && $selectedYear !== 'all' ? 'Daily View' : 'Timeline View' }}
          </span>
        </div>
        <div class="dash-card-body">
          <div class="chart-container-lg">
            <canvas id="trendChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Check-in Modes & Status Breakdown Donut Chart (4 cols) -->
    <div class="col-12 col-xl-4">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-pie-chart-fill text-success"></i> Punch Method Split
            </h2>
            <p class="dash-card-subtitle">On-Site Geofence vs Field Duty vs Traps</p>
          </div>
        </div>
        <div class="dash-card-body d-flex flex-column justify-content-center">
          <div class="chart-container-lg" style="max-height: 300px;">
            <canvas id="methodDonutChart"></canvas>
          </div>
          <div class="mt-3 pt-2 border-top d-flex justify-content-around text-center small">
            <div>
              <span class="text-muted d-block">On-Site</span>
              <strong class="text-success fw-bold">{{ $stats['period_inside'] }}</strong>
            </div>
            <div class="border-start ps-3">
              <span class="text-muted d-block">Outside Field</span>
              <strong class="text-info fw-bold">{{ $stats['period_outside'] }}</strong>
            </div>
            <div class="border-start ps-3">
              <span class="text-muted d-block">Auto-Traps</span>
              <strong class="text-danger fw-bold">{{ $stats['period_traps'] }}</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 2: Geofence Site Footfall & Department Analytics -->
  <div class="row g-4 mb-4">
    <!-- Geofence / Site Activity Bar Chart -->
    <div class="col-12 col-xl-6">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-geo-alt-fill text-warning"></i> Site / Geofence Check-in Footfall
            </h2>
            <p class="dash-card-subtitle">Total employee check-ins recorded at each geofence location</p>
          </div>
          <a href="{{ route('admin.geofences.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Manage Sites &rarr;</a>
        </div>
        <div class="dash-card-body">
          <div class="chart-container-md">
            <canvas id="geofenceBarChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Department-wise Attendance vs Headcount Chart -->
    <div class="col-12 col-xl-6">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-diagram-3-fill text-info"></i> Department Analytics
            </h2>
            <p class="dash-card-subtitle">Headcount vs period attendance count per department</p>
          </div>
          <a href="{{ route('admin.departments.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Departments &rarr;</a>
        </div>
        <div class="dash-card-body">
          <div class="chart-container-md">
            <canvas id="departmentChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 3: Hourly Arrival Peak Times & Designation Breakdown -->
  <div class="row g-4 mb-4">
    <!-- Peak Check-in Hours Distribution -->
    <div class="col-12 col-xl-6">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-clock-history text-primary"></i> Peak Punch-In Time Distribution
            </h2>
            <p class="dash-card-subtitle">Employee arrival timing distribution across business hours</p>
          </div>
        </div>
        <div class="dash-card-body">
          <div class="chart-container-md">
            <canvas id="hourlyArrivalChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Designation Distribution (Polar Area / Doughnut) -->
    <div class="col-12 col-xl-6">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-briefcase-fill text-purple" style="color: #7c3aed;"></i> Designation Headcount
            </h2>
            <p class="dash-card-subtitle">Employee breakdown across organization designations</p>
          </div>
          <a href="{{ route('admin.designations.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Designations &rarr;</a>
        </div>
        <div class="dash-card-body">
          <div class="chart-container-md">
            <canvas id="designationChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 4: Live Check-in Activity & Geofence Site Overview Tables -->
  <div class="row g-4">
    <!-- Real-time Recent Check-in Activity (7 cols) -->
    <div class="col-12 col-xl-7">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-broadcast text-danger"></i> Live Check-in Activity Stream
            </h2>
            <p class="dash-card-subtitle">Latest punch-in and punch-out events in the system</p>
          </div>
          <a href="{{ route('admin.attendances') }}" class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-3">
            View All Attendances
          </a>
        </div>
        <div class="dash-card-body p-0">
          <div class="table-responsive">
            <table class="table activity-table mb-0">
              <thead>
                <tr>
                  <th>Employee</th>
                  <th>Location / Zone</th>
                  <th>Check In</th>
                  <th>Check Out</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentActivities as $item)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="avatar-img avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem;">
                          {{ $item->employee ? $item->employee->initials() : 'NA' }}
                        </div>
                        <div>
                          <span class="fw-bold d-block text-gray-800 dark:text-white">{{ $item->employee->name ?? 'Unknown' }}</span>
                          <small class="text-muted">{{ $item->employee->department->name ?? 'No Dept' }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      @if($item->type === 'inside')
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                          <i class="bi bi-geo-alt-fill me-1"></i> {{ $item->geofence->name ?? 'Geofence Site' }}
                        </span>
                      @else
                        <span class="badge bg-info bg-opacity-10 text-info">
                          <i class="bi bi-compass me-1"></i> Outside Field
                        </span>
                      @endif
                    </td>
                    <td>
                      <span class="fw-semibold">{{ $item->check_in ? \Carbon\Carbon::parse($item->check_in)->format('h:i A') : 'N/A' }}</span>
                      <small class="text-muted d-block">{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('M d') : '' }}</small>
                    </td>
                    <td>
                      @if($item->check_out)
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($item->check_out)->format('h:i A') }}</span>
                      @else
                        <span class="badge bg-warning bg-opacity-10 text-warning">Working</span>
                      @endif
                    </td>
                    <td>
                      @if($item->is_auto_checkout_trap)
                        <span class="badge bg-danger">Trapped</span>
                      @elseif($item->status === 'late')
                        <span class="badge bg-warning text-dark">Late</span>
                      @else
                        <span class="badge bg-success">Verified</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                      <i class="bi bi-inbox fs-3 d-block mb-1"></i> No recent attendance records found.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Geofences Performance / Assigned Staff Overview (5 cols) -->
    <div class="col-12 col-xl-5">
      <div class="dash-card h-100">
        <div class="dash-card-header">
          <div>
            <h2 class="dash-card-title">
              <i class="bi bi-geo-alt text-success"></i> Geofence Sites Status
            </h2>
            <p class="dash-card-subtitle">Active sites, radius coverage, and staff allocations</p>
          </div>
          <a href="{{ route('admin.geofences.create') }}" class="btn btn-sm btn-primary shadow-sm rounded-pill px-3">
            <i class="bi bi-plus-lg"></i> Add Site
          </a>
        </div>
        <div class="dash-card-body p-0">
          <div class="table-responsive">
            <table class="table activity-table mb-0">
              <thead>
                <tr>
                  <th>Site Name</th>
                  <th>Radius</th>
                  <th>Assigned</th>
                  <th>Period Check-ins</th>
                </tr>
              </thead>
              <tbody>
                @forelse($geofences as $geo)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <span class="status-dot {{ $geo->is_active ? 'bg-success' : 'bg-secondary' }}"></span>
                        <strong class="text-gray-800 dark:text-white">{{ $geo->name }}</strong>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-light text-dark border">{{ $geo->radius }}m</span>
                    </td>
                    <td>
                      <span class="fw-semibold">{{ $geo->employees_count ?? $geo->employees->count() }} Staff</span>
                    </td>
                    <td>
                      <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">
                        {{ $geo->attendances_count }} Check-ins
                      </span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                      <i class="bi bi-geo fs-3 d-block mb-1"></i> No geofences created yet.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme Awareness for Chart Colors
    const isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark' || document.documentElement.classList.contains('dark');
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)';
    const textColor = isDarkMode ? '#9ca3af' : '#6b7280';

    // 1. Attendance Volume & Trends (Multi-Dataset Spline Area Chart)
    const trendCtx = document.getElementById('trendChart')?.getContext('2d');
    if (trendCtx) {
        // Linear Gradients
        const gradSuccess = trendCtx.createLinearGradient(0, 0, 0, 320);
        gradSuccess.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
        gradSuccess.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

        const gradInfo = trendCtx.createLinearGradient(0, 0, 0, 320);
        gradInfo.addColorStop(0, 'rgba(6, 182, 212, 0.35)');
        gradInfo.addColorStop(1, 'rgba(6, 182, 212, 0.0)');

        const gradDanger = trendCtx.createLinearGradient(0, 0, 0, 320);
        gradDanger.addColorStop(0, 'rgba(239, 68, 68, 0.25)');
        gradDanger.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($stats['trend_labels']),
                datasets: [
                    {
                        label: 'On-Site Geofence',
                        data: @json($stats['trend_inside']),
                        borderColor: '#10b981',
                        backgroundColor: gradSuccess,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        pointRadius: 3
                    },
                    {
                        label: 'Outside / Field Duty',
                        data: @json($stats['trend_outside']),
                        borderColor: '#06b6d4',
                        backgroundColor: gradInfo,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        pointRadius: 3
                    },
                    {
                        label: 'Absents / Missed',
                        data: @json($stats['trend_absent']),
                        borderColor: '#ef4444',
                        backgroundColor: gradDanger,
                        borderWidth: 2,
                        borderDash: [4, 4],
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        pointRadius: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 18,
                            font: { size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        padding: 12,
                        cornerRadius: 8,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: textColor, maxRotation: 45, minRotation: 0 }
                    }
                }
            }
        });
    }

    // 2. Punch Method Split (Doughnut Chart)
    const donutCtx = document.getElementById('methodDonutChart')?.getContext('2d');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($stats['method_labels']),
                datasets: [{
                    data: @json($stats['method_data']),
                    backgroundColor: [
                        '#10b981', // Success / Green
                        '#06b6d4', // Cyan / Field
                        '#ef4444'  // Danger / Trap
                    ],
                    borderWidth: 2,
                    borderColor: isDarkMode ? '#1f2937' : '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            padding: 14,
                            font: { size: 11, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8
                    }
                }
            }
        });
    }

    // 3. Geofence Site Footfall (Bar Chart)
    const geoCtx = document.getElementById('geofenceBarChart')?.getContext('2d');
    if (geoCtx) {
        new Chart(geoCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['geofence_labels']),
                datasets: [{
                    label: 'Check-in Count',
                    data: @json($stats['geofence_data']),
                    backgroundColor: 'rgba(245, 158, 11, 0.85)',
                    hoverBackgroundColor: '#d97706',
                    borderRadius: 6,
                    maxBarThickness: 38
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    }

    // 4. Department Analytics (Grouped Bar Chart)
    const deptCtx = document.getElementById('departmentChart')?.getContext('2d');
    if (deptCtx) {
        new Chart(deptCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['dept_labels']),
                datasets: [
                    {
                        label: 'Total Staff',
                        data: @json($stats['dept_employees']),
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        hoverBackgroundColor: '#4f46e5',
                        borderRadius: 5,
                        maxBarThickness: 28
                    },
                    {
                        label: 'Period Check-ins',
                        data: @json($stats['dept_attendances']),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        hoverBackgroundColor: '#059669',
                        borderRadius: 5,
                        maxBarThickness: 28
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            font: { size: 11, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    }

    // 5. Peak Arrival Times (Bar Chart)
    const hourCtx = document.getElementById('hourlyArrivalChart')?.getContext('2d');
    if (hourCtx) {
        new Chart(hourCtx, {
            type: 'bar',
            data: {
                labels: @json($stats['hour_labels']),
                datasets: [{
                    label: 'Punches',
                    data: @json($stats['hour_data']),
                    backgroundColor: 'rgba(37, 99, 235, 0.75)',
                    hoverBackgroundColor: '#1d4ed8',
                    borderRadius: 6,
                    maxBarThickness: 32
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    }

    // 6. Designation Distribution (Polar Area Chart)
    const desigCtx = document.getElementById('designationChart')?.getContext('2d');
    if (desigCtx) {
        new Chart(desigCtx, {
            type: 'doughnut',
            data: {
                labels: @json($stats['designation_labels']),
                datasets: [{
                    data: @json($stats['designation_counts']),
                    backgroundColor: [
                        '#8b5cf6',
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ec4899',
                        '#06b6d4',
                        '#64748b'
                    ],
                    borderWidth: 2,
                    borderColor: isDarkMode ? '#1f2937' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            padding: 10,
                            font: { size: 11, weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 10,
                        cornerRadius: 8
                    }
                }
            }
        });
    }
});
</script>
@endpush