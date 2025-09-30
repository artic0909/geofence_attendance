@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Welcome to Geo Locate RCPL Admin Panel</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Total Employees</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_employees'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Geofences</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_geofences'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Today's Attendance</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['today_attendances'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Active Employees</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_employees'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Attendance -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="text-lg font-medium text-gray-900">Recent Attendance</h3>

        <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <div class="searchbar mb-4">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap gap-3 items-end">

                    <!-- Geofence Dropdown -->
                    <div>
                        <label for="geofence" class="form-label">Geofence</label>
                        <select name="geofence" id="geofence" class="form-select">
                            <option value="">Select Geofence</option>
                            @foreach($geofences as $geofence)
                            <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                                {{ $geofence->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                    </div>

                    <!-- Employee Name (optional) -->
                    <div>
                        <label for="employee_name" class="form-label">Employee Name</label>
                        <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Optional" value="{{ request('employee_name') }}">
                    </div>

                    <!-- Filter Button -->
                    <div>
                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    </div>

                </form>

            </div>

            <form method="GET" action="{{ route('admin.dashboard') }}">
                <button type="submit" class="btn btn-primary mt-2">reset</button>
            </form>
        </div>

    </div>
    <div class="p-6">
        @if($recent_attendances->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ChaeckIn Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ChaeckOut Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recent_attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckIn{{$attendance->id}}">View</button>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'N/A' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckOut{{$attendance->id}}">View</button></td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->geofence->name }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="flex justify-center items-center gap-3 py-3">

                                <!-- Prev Button -->
                                <button
                                    class="btn btn-secondary"
                                    {{ $recent_attendances->onFirstPage() ? 'disabled' : '' }}
                                    onclick="window.location='{{ $recent_attendances->previousPageUrl() }}'">
                                    Prev
                                </button>

                                <!-- Page Indicator -->
                                <div class="flex items-center gap-1">
                                    <input type="text" readonly class="w-10 text-center form-control border rounded" value="{{ $recent_attendances->currentPage() }}">
                                    <span>/</span>
                                    <input type="text" readonly class="w-10 text-center form-control border rounded" value="{{ $recent_attendances->lastPage() }}">
                                </div>

                                <!-- Next Button -->
                                <button
                                    class="btn btn-secondary"
                                    {{ $recent_attendances->currentPage() == $recent_attendances->lastPage() ? 'disabled' : '' }}
                                    onclick="window.location='{{ $recent_attendances->nextPageUrl() }}'">
                                    Next
                                </button>

                            </div>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-4">No attendance records found.</p>
        @endif
    </div>
</div>

<!-- Check In Image Modal -->
@foreach($recent_attendances as $attendance)
<div class="modal fade" id="staticBackdropCheckIn{{$attendance->id}}" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Check In Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($attendance->check_in_photo) }}" class="w-full" alt="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach($recent_attendances as $attendance)
<div class="modal fade" id="staticBackdropCheckOut{{$attendance->id}}" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Check Out Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($attendance->check_out_photo) }}" class="w-full" alt="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection