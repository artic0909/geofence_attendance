@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">All Attendances</h1>
    <p class="text-gray-600">Welcome to Geo Locate <span class="font-bold text-danger" style="text-transform: capitalize;">{{ auth()->guard('admin')->user()->name }}</span> Panel</p>
</div>


<!-- Recent Attendance -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">


        <div class="searchbar mb-2">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="row">
                <h2 class="font-bold">Filter Search</h2>
                <!-- Geofence Dropdown -->
                <div class="col-md-12">
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

                <!-- From Date -->
                <div class="col-md-4 mt-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <!-- To Date -->
                <div class="col-md-4 mt-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>


                <!-- Employee Name (optional) -->
                <div class="col-md-4 mt-3">
                    <label for="employee_name" class="form-label">Employee Name</label>
                    <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Optional" value="{{ request('employee_name') }}">
                </div>



                <!-- Filter Button -->
                <div class="col-md-4 mt-3 w-100 text-end">
                    <button type="submit" class="btn btn-primary w-20">Filter</button>
                </div>
            </form>

            <form method="GET" action="{{ route('admin.dashboard') }}" class="text-end">
                <button type="submit" class="btn btn-secondary w-20 mt-2">Reset</button>
            </form>

        </div>




    </div>
    <div class="p-6">
        @if($recent_attendances->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->employee->email }}</td>
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

<!-- Check Out Image Modal -->
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


<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const geofence = document.getElementById('geofence').value;
        if (!geofence) {
            e.preventDefault();
            alert('Please select a Geofence before filtering.');
        }
    });
</script>


@endsection