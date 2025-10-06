@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Geofences</h2>
    <a href="{{ route('admin.geofences.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add Geofence
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Site Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Radius</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($geofences as $geofence)
            <tr>
                <td class="px-6 py-4">{{ $geofence->name }}</td>
                <td class="px-6 py-4">{{ $geofence->latitude }}, {{ $geofence->longitude }}</td>
                <td class="px-6 py-4">{{ $geofence->radius }} meters</td>
                <td class="px-6 py-4">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $geofence->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $geofence->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.geofences.edit', $geofence) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                    <form action="{{ route('admin.geofences.destroy', $geofence) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection