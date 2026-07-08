@extends('admin.layout')
@section('header_title', 'Attendance Tracking')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Management</p>
      <h1 class="h3 mb-1">Attendance Options</h1>
      <p class="text-muted mb-0">Welcome to Site Sync <span class="fw-bold text-primary text-capitalize">{{ auth()->user()->name }}</span> Panel</p>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.attendances.today') }}" class="text-decoration-none h-100 block">
            <div class="card h-100 border-0 shadow-sm hover-elevate transition-all">
                <div class="card-body p-4 d-flex align-items-start justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold text-uppercase small mb-2">Today's Activity</h6>
                        <h2 class="display-6 fw-bold text-primary mb-2">{{ $stats['today_attendances'] }}</h2>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-arrow-up-right-circle text-success me-1"></i> Check-ins today
                        </div>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-calendar2-check fs-2"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('admin.attendances') }}" class="text-decoration-none h-100 block">
            <div class="card h-100 border-0 shadow-sm hover-elevate transition-all">
                <div class="card-body p-4 d-flex align-items-start justify-content-between">
                    <div>
                        <h6 class="text-muted fw-bold text-uppercase small mb-2">Historical Data</h6>
                        <h2 class="h3 fw-bold text-primary mb-2 mt-3">All Logs</h2>
                        <div class="d-flex align-items-center text-muted small mt-4">
                            <i class="bi bi-clock-history me-1"></i> View all past check-ins
                        </div>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-server fs-2"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm hover-elevate transition-all cursor-pointer" onclick="showRestrictedAlert()">
            <div class="card-body p-4 d-flex align-items-start justify-content-between">
                <div>
                    <h6 class="text-muted fw-bold text-uppercase small mb-2">Data Management</h6>
                    <h2 class="h3 fw-bold text-secondary mb-2 mt-3">Cleanup</h2>
                    <div class="d-flex align-items-center text-muted small mt-4">
                        <i class="bi bi-trash text-danger me-1"></i> Delete old records
                    </div>
                </div>
                <div class="bg-light text-secondary rounded p-3">
                    <i class="bi bi-trash3 fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-elevate:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>

<script>
    function showRestrictedAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Access Restricted',
            html: `
                <div class="text-start mt-2">
                    <p class="mb-3 text-dark">This feature is <strong>restricted by the Super Admin</strong> for security purposes.</p>
                    <p class="small text-muted bg-light p-3 rounded border">Please contact your Super Admin if you need access to delete old attendance records.</p>
                </div>
            `,
            confirmButtonText: 'Understood',
            confirmButtonColor: '#0a58ca',
        });
    }
</script>
@endsection