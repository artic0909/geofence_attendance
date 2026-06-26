@extends('admin.layout')
@section('header_title', 'Geofences (Sites)')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Geofences (Sites)</h2>
    <div class="flex flex-col md:flex-row items-center gap-4">
        <!-- Search Bar -->
        <form action="{{ route('admin.geofences.index') }}" method="GET" class="w-full md:w-auto">
            <div class="relative flex items-center bg-white border border-gray-300 rounded-xl shadow-sm hover:border-saffron focus-within:border-saffron focus-within:ring-2 focus-within:ring-saffron/20 transition-all overflow-hidden group">
                <div class="pl-4 pr-2 py-2 text-gray-400 group-focus-within:text-navy">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sites..." 
                    class="w-full md:w-64 px-2 py-2.5 outline-none bg-transparent text-sm text-gray-800 placeholder-gray-400">
                <button type="submit" class="px-4 py-2.5 bg-gray-50 text-gray-600 font-medium border-l border-gray-200 hover:bg-gray-100 hover:text-navy transition-colors text-sm">
                    Search
                </button>
            </div>
            @if(request('search'))
                <a href="{{ route('admin.geofences.index') }}" class="block mt-2 text-xs text-red-500 hover:text-red-700 font-medium">Clear search</a>
            @endif
        </form>

        <a href="{{ route('admin.geofences.create') }}" class="w-full md:w-auto flex items-center justify-center px-5 py-2.5 bg-navy text-white font-bold rounded-xl shadow-md hover:bg-[#233554] transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Site
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