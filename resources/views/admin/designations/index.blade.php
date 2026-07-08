@extends('admin.layout')
@section('header_title', 'Designations')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-briefcase" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Organization</p>
      <h1 class="h3 mb-1">Designations</h1>
      <p class="text-muted mb-0">Manage job roles and designations.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.designations.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Designation</a>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Designation List</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    @if($designations->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($designations as $designation)
                <tr>
                    <td>{{ ($designations->currentPage() - 1) * $designations->perPage() + $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $designation->name }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.designations.edit', $designation) }}" class="btn btn-light btn-sm text-primary me-2"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('admin.designations.destroy', $designation) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light btn-sm text-danger delete-btn" data-item="designation"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-top">
            {{ $designations->links() }}
        </div>
    @else
        <div class="p-5 text-center text-muted">
            No designations found.
        </div>
    @endif
  </div>
</section>
@endsection
