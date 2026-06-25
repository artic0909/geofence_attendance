@extends('admin.layout')
@section('header_title', 'Departments')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Departments</h2>
    <div class="flex flex-col md:flex-row items-center gap-4">
        <a href="{{ route('admin.departments.create') }}" class="w-full md:w-auto flex items-center justify-center px-5 py-2.5 bg-navy text-white font-bold rounded-xl shadow-md hover:bg-[#233554] transition-all transform hover:-translate-y-0.5">
            Add Department
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    @if($departments->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($departments as $department)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $department->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $department->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                        <a href="{{ route('admin.departments.edit', $department) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Delete this department?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $departments->links() }}
        </div>
    @else
        <div class="p-12 text-center text-gray-500">
            No departments found.
        </div>
    @endif
</div>
@endsection
