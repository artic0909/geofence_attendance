@extends('admin.layout')
@section('header_title', 'Account Settings')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Configuration</p>
      <h1 class="h3 mb-1">Account Settings</h1>
      <p class="text-muted mb-0">Update your profile, business information, and change your password.</p>
    </div>
  </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <div>
            <h5 class="alert-heading mb-1 text-sm font-medium">There were {{ $errors->count() }} errors with your submission</h5>
            <ul class="mb-0 text-sm list-unstyled">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-dot"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" class="validate-form">
    @csrf

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-person-badge" aria-hidden="true"></i><span>Profile Details</span></h2>
                <p class="text-muted mb-0 small">Basic contact and login information.</p>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" data-rule-required="true">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" data-rule-required="true" data-rule-email="true">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>
            </div>
        </div>
    </section>

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-building" aria-hidden="true"></i><span>Business Information</span></h2>
                <p class="text-muted mb-0 small">Details used for billing and organization display.</p>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Business/Organization Name</label>
                    <input type="text" name="business_name" value="{{ old('business_name', $user->business_name) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">GST Number (Optional)</label>
                    <input type="text" name="gst_number" value="{{ old('gst_number', $user->gst_number) }}" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Address Line 1</label>
                    <input type="text" name="address_line_1" value="{{ old('address_line_1', $user->address_line_1) }}" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Address Line 2</label>
                    <input type="text" name="address_line_2" value="{{ old('address_line_2', $user->address_line_2) }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">State/Province</label>
                    <input type="text" name="state" value="{{ old('state', $user->state) }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">ZIP/Postal Code</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" class="form-control">
                </div>
            </div>
        </div>
    </section>

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Security</span></h2>
                <p class="text-muted mb-0 small">Leave blank if you do not wish to change your password.</p>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">New Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" autocomplete="new-password" class="form-control border-end-0">
                        <button class="btn btn-outline-secondary bg-white border-start-0 toggle-password" type="button" data-target="password">
                            <i class="bi bi-eye eye-icon"></i>
                            <i class="bi bi-eye-slash eye-slash-icon d-none"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" data-rule-equalto="#password" class="form-control border-end-0">
                        <button class="btn btn-outline-secondary bg-white border-start-0 toggle-password" type="button" data-target="password_confirmation">
                            <i class="bi bi-eye eye-icon"></i>
                            <i class="bi bi-eye-slash eye-slash-icon d-none"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex justify-content-end pb-5">
        <button type="submit" class="btn btn-primary btn-lg px-5 shadow"><i class="bi bi-check2-circle me-2"></i> Save Changes</button>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            var targetId = $(this).data('target');
            var input = $('#' + targetId);
            var type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            $(this).find('.eye-icon').toggleClass('d-none');
            $(this).find('.eye-slash-icon').toggleClass('d-none');
        });
    });
</script>
@endpush

@endsection
