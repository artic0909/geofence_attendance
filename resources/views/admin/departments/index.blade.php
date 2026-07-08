@extends('admin.layout')
@section('header_title', 'Departments')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Organization</p>
      <h1 class="h3 mb-1">Departments</h1>
      <p class="text-muted mb-0">Manage all departments within your organization.</p>
    </div>
  </div>
  <div class="heading-actions">
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Department</a>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-list-ul" aria-hidden="true"></i><span>Department List</span></h2>
    </div>
  </div>
  <div class="table-responsive">
    @if($departments->count() > 0)
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                <tr>
                    <td>{{ ($departments->currentPage() - 1) * $departments->perPage() + $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $department->name }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-light btn-sm text-primary me-2"><i class="bi bi-pencil"></i> Edit</a>
                        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light btn-sm text-danger delete-btn" data-item="department"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-top">
            {{ $departments->links() }}
        </div>
    @else
        <div class="p-5 text-center text-muted">
            No departments found.
        </div>
    @endif
  </div>
</section>
@endsection
