@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Geofences (Sites)</h2>
    <div class="flex items-center gap-4">
        <!-- Search Bar -->
        <form action="{{ route('admin.geofences.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search site name..." 
                class="px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-64 text-sm">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 transition-colors text-sm">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.geofences.index') }}" class="ml-2 text-red-500 hover:text-red-700 text-sm">Clear</a>
            @endif
        </form>

        <a href="{{ route('admin.geofences.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-shadow shadow-sm font-medium">
            + Add Geofence
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    @if($geofences->count() > 0)
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">SL</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Site Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Radius</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($geofences as $geofence)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ($geofences->currentPage() - 1) * $geofences->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $geofence->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">{{ $geofence->latitude }}, {{ $geofence->longitude }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $geofence->radius }} meters</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $geofence->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $geofence->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-3">
                        <a href="{{ route('admin.geofences.edit', $geofence) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                        <form action="{{ route('admin.geofences.destroy', $geofence) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium" onclick="return confirm('Delete this site?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $geofences->links() }}
        </div>
    @else
        <div class="p-12 text-center text-gray-500">
            No geofences found matching your search.
        </div>
    @endif
</div>
@endsection