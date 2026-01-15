@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Today's Attendances ({{ \Carbon\Carbon::today()->format('d M Y') }})</h1>
    <p class="text-gray-600">Welcome to Site Sync <span class="font-bold text-danger" style="text-transform: capitalize;">{{ auth()->guard('admin')->user()->name }}</span> Panel</p>
</div>


<!-- Recent Attendance -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="searchbar mb-2">
            <form method="GET" id="filterForm" action="{{ route('admin.attendances.today') }}" class="row">
                <h2 class="font-bold">Filter Search (Today's Records Only)</h2>

                <!-- Geofence Dropdown -->
                <div class="col-md-12">
                    <label for="geofence" class="form-label">Geofence</label>
                    <select name="geofence" id="geofence" class="form-select">
                        <option value="">All Geofences</option>
                        @foreach($geofences as $geofence)
                        <option value="{{ $geofence->id }}" {{ request('geofence') == $geofence->id ? 'selected' : '' }}>
                            {{ $geofence->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Employee Name -->
                <div class="col-md-8 mt-3">
                    <label for="employee_name" class="form-label">Employee Name</label>
                    <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Enter Employee Name" value="{{ request('employee_name') }}">
                </div>

                <!-- Filter Button -->
                <div class="col-md-4 mt-3 d-flex align-items-end">
                    <button type="submit" formaction="{{ route('admin.attendances.today.export') }}" class="btn btn-success w-50 me-2">Export to Excel</button>
                    <button type="submit" id="filterBtn" class="btn btn-primary w-50 me-2">Filter</button>
                    <a href="{{ route('admin.attendances.today') }}" class="btn w-50 btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="p-6">
        @if($recent_attendances->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recent_attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->employee->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->employee->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('h:i A') : 'N/A' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($attendance->check_in_photo)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckIn{{$attendance->id}}">View</button>
                            @else
                            <span class="text-gray-400">No Image</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('h:i A') : 'N/A' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($attendance->check_out_photo)
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropCheckOut{{$attendance->id}}">View</button>
                            @else
                            <span class="text-gray-400">No Image</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            if ($attendance->check_in && $attendance->check_out) {
                            $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                            $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                            $totalHours = $checkIn->diff($checkOut)->format('%H:%I:%S');
                            } else {
                            $totalHours = 'N/A';
                            }
                            @endphp
                            {{ $totalHours }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $attendance->geofence->name }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="9">
                            <div class="flex justify-center items-center gap-3 py-3">
                                <!-- Prev Button -->
                                <button
                                    class="btn btn-secondary"
                                    {{ $recent_attendances->onFirstPage() ? 'disabled' : '' }}
                                    onclick="window.location='{{ $recent_attendances->appends(request()->query())->previousPageUrl() }}'">
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
                                    onclick="window.location='{{ $recent_attendances->appends(request()->query())->nextPageUrl() }}'">
                                    Next
                                </button>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-4">No attendance records found for today.</p>
        @endif
    </div>
</div>

<!-- Check In Image Modal -->
@foreach($recent_attendances as $attendance)
@if($attendance->check_in_photo)
<div class="modal fade" id="staticBackdropCheckIn{{$attendance->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Check In Image - {{ $attendance->employee->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($attendance->check_in_photo) }}" class="w-full" alt="Check In Photo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Check Out Image Modal -->
@foreach($recent_attendances as $attendance)
@if($attendance->check_out_photo)
<div class="modal fade" id="staticBackdropCheckOut{{$attendance->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Check Out Image - {{ $attendance->employee->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($attendance->check_out_photo) }}" class="w-full" alt="Check Out Photo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<script>
    // Optional: Remove validation if you want to allow filtering without selecting geofence
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        // Allow form submission without validation
        // You can add custom validation here if needed
    });
</script>

@endsection