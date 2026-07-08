@extends('admin.layout')
@section('header_title', 'Geofences (Sites)')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Locations</p>
      <h1 class="h3 mb-1">Geofences (Sites)</h1>
      <p class="text-muted mb-0">Manage geographical boundaries for check-ins.</p>
    </div>
  </div>
  <div class="heading-actions d-flex gap-2">
    <form action="{{ route('admin.geofences.index') }}" method="GET" class="d-flex align-items-center">
        <div class="input-group input-group-sm me-2">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sites..." class="form-control border-start-0 ps-0">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
        </div>
        @if(request('search'))
            <a href="{{ route('admin.geofences.index') }}" class="btn btn-link btn-sm text-danger text-decoration-none px-0">Clear</a>
        @endif
    </form>
    <a href="{{ route('admin.geofences.create') }}" class="btn btn-primary btn-sm d-flex align-items-center"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Site</a>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Sites List</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    @if($geofences->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Site Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Radius</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($geofences as $geofence)
                <tr>
                    <td>{{ ($geofences->currentPage() - 1) * $geofences->perPage() + $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $geofence->name }}</td>
                    <td class="font-monospace text-muted small">{{ $geofence->latitude }}, {{ $geofence->longitude }}</td>
                    <td>{{ $geofence->radius }} meters</td>
                    <td>
                        <span class="badge {{ $geofence->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $geofence->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.geofences.edit', $geofence) }}" class="btn btn-light btn-sm text-primary me-2"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('admin.geofences.destroy', $geofence) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light btn-sm text-danger delete-btn" data-item="site"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-4 py-3 border-top">
            {{ $geofences->links() }}
        </div>
    @else
        <div class="p-5 text-center text-muted">
            No geofences found matching your search.
        </div>
    @endif
  </div>
</section>
@endsection