@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Attendance Options</h1>
    <p class="text-gray-600">Welcome to Site Sync <span class="font-bold text-danger" style="text-transform: capitalize;">{{ auth()->guard('admin')->user()->name }}</span> Panel</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <a href="{{ route('admin.attendances.today') }}" class="bg-white rounded-lg shadow p-6">
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
    </a>

    <div class="bg-white rounded-lg shadow p-6">
        <a href="{{ route('admin.attendances') }}" class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">All Attendances</h3>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <a href="{{ route('admin.attendances.delete') }}" class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>

            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-600">Delete Old Attendances</h3>
            </div>
        </a>
    </div>

    <!-- <div class="bg-white rounded-lg shadow p-6">
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
    </div> -->





</div>



@endsection