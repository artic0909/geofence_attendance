@extends('admin.layout')
@section('header_title', 'Edit Designation')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Organization</p>
      <h1 class="h3 mb-1">Edit Designation</h1>
      <p class="text-muted mb-0">Update job designation details.</p>
    </div>
  </div>
</div>

<section class="row justify-content-center mt-3">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-input-cursor" aria-hidden="true"></i><span>Designation Details</span></h2>
                </div>
            </div>
            <div class="panel-body p-4">
                <form action="{{ route('admin.designations.update', $designation) }}" method="POST" class="validate-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $designation->name) }}" data-rule-required="true" class="form-control">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.designations.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
