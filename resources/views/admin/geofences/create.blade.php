@extends('admin.layout')
@section('header_title', 'Create Site (Geofence)')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-plus-circle" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Locations</p>
      <h1 class="h3 mb-1">New Site</h1>
      <p class="text-muted mb-0">Add a new geographical boundary for check-ins.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.geofences.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back to Sites</a>
  </div>
</div>

<form action="{{ route('admin.geofences.store') }}" method="POST" class="validate-form mt-4">
    @csrf
    <input type="hidden" name="admin_id" value="{{ auth()->id() }}">

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-info-circle" aria-hidden="true"></i><span>Site Details</span></h2>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-12">
                    <label for="name" class="form-label fw-bold">Site Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" data-rule-required="true" class="form-control" value="{{ old('name') }}">
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label fw-bold">Full Address <span class="text-danger">*</span></label>
                    <textarea name="address" id="address" data-rule-required="true" rows="3" class="form-control">{{ old('address') }}</textarea>
                    @error('address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="latitude" class="form-label fw-bold">Latitude <span class="text-danger">*</span></label>
                    <input type="text" name="latitude" id="latitude" data-rule-required="true" class="form-control font-monospace" value="{{ old('latitude') }}">
                    @error('latitude')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label for="longitude" class="form-label fw-bold">Longitude <span class="text-danger">*</span></label>
                    <input type="text" name="longitude" id="longitude" data-rule-required="true" class="form-control font-monospace" value="{{ old('longitude') }}">
                    @error('longitude')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center mb-0 mt-2" role="alert">
                        <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                        <div>
                            <h4 class="alert-heading h6 fw-bold mb-1">How to get coordinates</h4>
                            <ol class="mb-0 small ps-3">
                                <li>Open <a href="https://www.google.com/maps" target="_blank" class="fw-bold text-decoration-none">Google Maps</a></li>
                                <li>Right-click on your exact location</li>
                                <li>Click on the coordinates at the top to copy them</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-sliders" aria-hidden="true"></i><span>Site Parameters</span></h2>
            </div>
        </div>
        <div class="panel-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="radius" class="form-label fw-bold">Check-in Radius (meters) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="radius" id="radius" data-rule-required="true" min="50" class="form-control" value="{{ old('radius', 100) }}">
                        <span class="input-group-text">m</span>
                    </div>
                    <div class="form-text">The maximum distance allowed from the center to check in.</div>
                    @error('radius')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6">
                    <label for="tracking_radius" class="form-label fw-bold">Tracking Radius (Optional)</label>
                    <div class="input-group">
                        <input type="number" name="tracking_radius" id="tracking_radius" min="0" placeholder="e.g. 500" class="form-control" value="{{ old('tracking_radius') }}">
                        <span class="input-group-text">m</span>
                    </div>
                    <div class="form-text">Leave empty if outside tracking is disabled.</div>
                    @error('tracking_radius')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-12 mt-4 pt-3 border-top">
                    <div class="form-check form-switch form-check-lg d-flex align-items-center">
                        <input class="form-check-input fs-4 mt-0 me-3" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">Site is Active</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex justify-content-end pb-5 gap-2">
        <a href="{{ route('admin.geofences.index') }}" class="btn btn-light btn-lg px-4">Cancel</a>
        <button type="submit" class="btn btn-primary btn-lg px-5 shadow"><i class="bi bi-check2-circle me-2"></i> Create Geofence</button>
    </div>
</form>
@endsection