@extends('admin.layout')
@section('header_title', 'Dashboard')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Overview</p>
      <h1 class="h3 mb-1">Dashboard</h1>
      <p class="text-muted mb-0">Monitor your organization's attendance and statistics.</p>
    </div>
  </div>
</div>

<!-- Subscription Status Banner -->
<div class="panel border-primary border-top border-4 mb-4">
    <div class="panel-body d-md-flex align-items-center justify-content-between p-4">
        <div>
            <h3 class="h4 fw-bold mb-2">{{ auth()->user()->business_name }}</h3>
            <p class="text-muted mb-0 d-flex align-items-center">
                <span class="status-dot {{ auth()->user()->subscription_status === 'active' ? 'bg-success' : 'bg-danger' }} me-2"></span>
                Subscription Status: 
                <strong class="ms-1 text-uppercase {{ auth()->user()->subscription_status === 'active' ? 'text-success' : 'text-danger' }}">
                    {{ auth()->user()->subscription_status ?? 'Inactive' }}
                </strong>
            </p>
        </div>
        <div class="mt-3 mt-md-0 d-flex gap-4">
            <div>
                <p class="text-muted small text-uppercase fw-bold mb-1">Current Plan</p>
                <p class="fw-bold h5 text-primary mb-0">{{ $current_plan->plan_name ?? 'Free / Trial' }}</p>
            </div>
            <div>
                <p class="text-muted small text-uppercase fw-bold mb-1">Expires On</p>
                <p class="fw-bold h5 mb-0">
                    {{ auth()->user()->subscription_expires_at ? \Carbon\Carbon::parse(auth()->user()->subscription_expires_at)->format('M d, Y') : 'N/A' }}
                </p>
            </div>
            @if(auth()->user()->subscription_status !== 'active')
            <div class="ms-3 d-flex align-items-center">
                <a href="{{ route('pricing') }}" class="btn btn-warning fw-bold">Renew Subscription</a>
            </div>
            @endif
        </div>
    </div>
    @if(!$subscription['is_expired'])
    <div class="px-4 pb-4">
        <div class="d-flex justify-content-between small text-muted fw-bold mb-1">
            <span>Subscription Progress</span>
            <span>{{ $subscription['days_left'] }} Days Left</span>
        </div>
        <div class="progress" style="height: 10px;">
            <div class="progress-bar {{ $subscription['percentage'] > 90 ? 'bg-danger' : ($subscription['percentage'] > 70 ? 'bg-warning' : 'bg-success') }}" role="progressbar" style="width: {{ $subscription['percentage'] }}%" aria-valuenow="{{ $subscription['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    @endif
</div>

<!-- Stats Grid -->
<section class="row g-3 mt-1 mb-4" aria-label="Dashboard metrics">
  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-primary">
      <div class="metric-top">
        <span class="metric-label">Total Employees</span>
        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $stats['total_employees'] }}</div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-success">
      <div class="metric-top">
        <span class="metric-label">Today's Check-ins</span>
        <span class="metric-icon"><i class="bi bi-calendar-check" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $stats['today_attendances'] }}</div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-danger">
      <div class="metric-top">
        <span class="metric-label">Today's Absents</span>
        <span class="metric-icon"><i class="bi bi-calendar-x" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">{{ $stats['today_absents'] }}</div>
    </article>
  </div>

  <div class="col-12 col-sm-6 col-xl-3">
    <article class="metric-card metric-warning">
      <div class="metric-top">
        <span class="metric-label">Total Payments</span>
        <span class="metric-icon"><i class="bi bi-currency-dollar" aria-hidden="true"></i></span>
      </div>
      <div class="metric-value">₹{{ number_format($stats['total_payments'], 2) }}</div>
    </article>
  </div>
</section>

<!-- Charts Section -->
<div class="panel">
    <div class="panel-header">
        <div>
            <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up" aria-hidden="true"></i><span>7-Day Attendance Trend</span></h2>
            <p class="text-muted mb-0">Overview of employees presence over the last 7 days.</p>
        </div>
    </div>
    <div class="panel-body p-4" style="height: 350px;">
        <canvas id="attendanceChart"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: @json($stats['chart_dates']),
                datasets: [
                    {
                        label: 'Total Employees',
                        data: @json($stats['chart_totals']),
                        borderColor: '#9ca3af',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.1,
                        pointBackgroundColor: '#9ca3af',
                        pointBorderColor: '#fff',
                        pointRadius: 3
                    },
                    {
                        label: 'Present',
                        data: @json($stats['chart_presents']),
                        borderColor: '#198754', // Bootstrap success
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#146c43',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Absent',
                        data: @json($stats['chart_absents']),
                        borderColor: '#dc3545', // Bootstrap danger
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#b02a37',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
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
                        labels: { usePointStyle: true, boxWidth: 8 }
                    },
                    tooltip: {
                        backgroundColor: '#212529',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#6c757d' },
                        grid: { color: '#f8f9fa', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#6c757d' },
                        grid: { display: false, drawBorder: false }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush
@endsection