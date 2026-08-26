@extends('admin.layout')
@section('header_title', 'Edit Employee')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Human Resources</p>
      <h1 class="h3 mb-1">Edit Employee</h1>
      <p class="text-muted mb-0">Update staff details and site assignments.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.employees.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back to Directory</a>
  </div>
</div>

<form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" id="employeeForm" class="validate-form mt-4">
    @csrf
    @method('PUT')
    
    <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-person-vcard" aria-hidden="true"></i><span>Personal Details</span></h2>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" data-rule-required="true" class="form-control" value="{{ old('name', $employee->name) }}">
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" data-rule-required="true" data-rule-email="true" autocomplete="off" class="form-control" value="{{ old('email', $employee->email) }}">
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" data-rule-required="true" class="form-control" value="{{ old('phone', $employee->phone) }}">
                    @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="employee_id" class="form-label fw-bold">Employee ID <span class="text-danger">*</span></label>
                    <input type="text" name="employee_id" id="employee_id" data-rule-required="true" class="form-control" value="{{ old('employee_id', $employee->employee_id) }}">
                    @error('employee_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="department_id" class="form-label fw-bold">Department</label>
                    <select name="department_id" id="department_id" data-rule-required="true" class="form-select select2">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="designation_id" class="form-label fw-bold">Designation</label>
                    <select name="designation_id" id="designation_id" data-rule-required="true" class="form-select select2">
                        <option value="">Select Designation</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                        @endforeach
                    </select>
                    @error('designation_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label for="daily_rate_amount" class="form-label fw-bold">Daily Rate Amount (₹)</label>
                    <input type="number" step="0.01" name="daily_rate_amount" id="daily_rate_amount" class="form-control" value="{{ old('daily_rate_amount', $employee->daily_rate_amount) }}">
                    @error('daily_rate_amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="ot_rate_amount" class="form-label fw-bold">OT Rate Amount per Hour (₹)</label>
                    <input type="number" step="0.01" name="ot_rate_amount" id="ot_rate_amount" class="form-control" value="{{ old('ot_rate_amount', $employee->ot_rate_amount) }}">
                    @error('ot_rate_amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </section>

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Security Settings</span></h2>
                <p class="text-muted mb-0 small">Leave blank if you do not wish to change the password.</p>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="password" class="form-label fw-bold">New Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" autocomplete="new-password" class="form-control border-end-0">
                        <button class="btn btn-outline-secondary bg-white border-start-0 toggle-password" type="button" data-target="password">
                            <i class="bi bi-eye eye-icon"></i>
                            <i class="bi bi-eye-slash eye-slash-icon d-none"></i>
                        </button>
                    </div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="form-control border-end-0">
                        <button class="btn btn-outline-secondary bg-white border-start-0 toggle-password" type="button" data-target="password_confirmation">
                            <i class="bi bi-eye eye-icon"></i>
                            <i class="bi bi-eye-slash eye-slash-icon d-none"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-geo-alt" aria-hidden="true"></i><span>Site Assignment</span></h2>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 gap-2">
                <label class="form-label fw-bold mb-0">Assign Geofences <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm" style="max-width: 300px;">
                    <span class="input-group-text bg-transparent"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="geofenceSearch" class="form-control border-start-0 ps-0" placeholder="Search sites...">
                </div>
            </div>
            <div class="row g-3" id="geofenceList">
                @foreach($geofences as $geofence)
                <div class="col-md-6 geofence-item">
                    <label class="d-flex align-items-center p-3 border rounded bg-light border-secondary-subtle cursor-pointer h-100">
                        <input class="form-check-input mt-0 me-3 fs-5" type="checkbox" name="geofences[]" value="{{ $geofence->id }}" {{ $employee->employeeGeofences->contains($geofence->id) ? 'checked' : '' }}>
                        <div>
                            <div class="fw-bold geofence-name">{{ $geofence->name }}</div>
                            <div class="small text-muted">{{ $geofence->radius }}m Radius</div>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            <div id="noGeofenceResults" class="alert alert-light border border-info border-start border-start-4 mt-3 d-none">
                <i class="bi bi-info-circle me-2 text-info"></i> No sites found matching your search.
            </div>
            @error('geofences')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            
            @if($geofences->isEmpty())
            <div class="alert alert-warning d-flex align-items-center mt-3 mb-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <h5 class="alert-heading mb-1 text-sm font-medium">No sites available</h5>
                    <p class="mb-0 text-sm">You must <a href="{{ route('admin.geofences.create') }}" class="fw-bold">create a geofence</a> before you can assign one.</p>
                </div>
            </div>
            @endif

            <div class="mt-4 pt-3 border-top">
                <div class="form-check form-switch form-check-lg d-flex align-items-center mb-3">
                    <input class="form-check-input fs-4 mt-0 me-3" type="checkbox" role="switch" name="phone_used_restricted" id="phone_used_restricted" value="1" {{ old('phone_used_restricted', $employee->phone_used_restricted) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="phone_used_restricted">Phone Use Restricted</label>
                </div>

                <div class="form-check form-switch form-check-lg d-flex align-items-center">
                    <input class="form-check-input fs-4 mt-0 me-3" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">Account is Active</label>
                </div>
                <div class="form-text ms-5">If unchecked, the employee will not be able to log in or check in.</div>
            </div>
        </div>
    </section>

    <div class="d-flex justify-content-end pb-5 gap-2">
        <a href="{{ route('admin.employees.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
        <button type="submit" class="btn btn-primary btn-lg px-5 shadow"><i class="bi bi-check2-circle me-2"></i> Update Employee</button>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#geofenceSearch').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            var visibleCount = 0;
            
            $('.geofence-item').each(function() {
                var text = $(this).find('.geofence-name').text().toLowerCase();
                if (text.indexOf(searchTerm) > -1) {
                    $(this).removeClass('d-none');
                    visibleCount++;
                } else {
                    $(this).addClass('d-none');
                }
            });
            
            if (visibleCount === 0 && $('.geofence-item').length > 0) {
                $('#noGeofenceResults').removeClass('d-none');
            } else {
                $('#noGeofenceResults').addClass('d-none');
            }
        });
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('.toggle-password').click(function() {
            var targetId = $(this).data('target');
            var input = $('#' + targetId);
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                $(this).find('.eye-icon').addClass('d-none');
                $(this).find('.eye-slash-icon').removeClass('d-none');
            } else {
                input.attr('type', 'password');
                $(this).find('.eye-icon').removeClass('d-none');
                $(this).find('.eye-slash-icon').addClass('d-none');
            }
        });

        $('#employeeForm').submit(function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();
            if (password || confirmPassword) {
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Passwords Mismatch',
                        text: 'Password and Confirm Password must match.',
                        confirmButtonColor: '#0a58ca'
                    });
                }
            }
        });
    });
</script>
@endpush