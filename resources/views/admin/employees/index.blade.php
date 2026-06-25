@extends('admin.layout')
@section('header_title', 'Employees Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Employees</h2>
    <div class="flex flex-col md:flex-row items-center gap-4">
        <!-- Search Bar -->
        <form action="{{ route('admin.employees.index') }}" method="GET" class="w-full md:w-auto">
            <div class="relative flex items-center bg-white border border-gray-300 rounded-xl shadow-sm hover:border-saffron focus-within:border-saffron focus-within:ring-2 focus-within:ring-saffron/20 transition-all overflow-hidden group">
                <div class="pl-4 pr-2 py-2 text-gray-400 group-focus-within:text-navy">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff..." 
                    class="w-full md:w-64 px-2 py-2.5 outline-none bg-transparent text-sm text-gray-800 placeholder-gray-400">
                <button type="submit" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-medium border-l border-gray-200 hover:bg-gray-100 hover:text-navy transition-colors text-sm">
                    Search
                </button>
            </div>
            @if(request('search'))
                <a href="{{ route('admin.employees.index') }}" class="block mt-2 text-xs text-red-500 hover:text-red-700 font-medium">Clear search</a>
            @endif
        </form>

        <a href="{{ route('admin.employees.create') }}" class="w-full md:w-auto flex items-center justify-center px-5 py-2.5 bg-navy text-white font-bold rounded-xl shadow-md hover:bg-[#233554] transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Employee
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    @if($employees->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">SL</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Employee ID</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Assigned Geofences</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 italic-last-row">
                @foreach($employees as $employee)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $employee->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $employee->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $employee->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $employee->employee_id }}</td>
                    <td class="px-6 py-4">
                        @if($employee->employeeGeofences->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($employee->employeeGeofences as $geofence)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $geofence->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-orange-500 text-xs italic">No Sites Assigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $employee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                        <a href="{{ route('admin.employees.track', $employee) }}" target="_blank" class="text-green-600 hover:text-green-800 font-bold bg-green-50 px-2 py-1 rounded border border-green-100 italic transition-all shadow-sm">Track Live</a>
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                        <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Delete this employee?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $employees->links() }}
        </div>
    @else
        <div class="p-12 text-center">
            <div class="mx-auto h-16 w-16 text-gray-300 mb-4">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">No employees found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or add a new staff member.</p>
            <div class="mt-6">
                <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Add Employee
                </a>
            </div>
        </div>
    @endif
</div>
@endsection