@extends('admin.layout')
@section('header_title', 'Attendance Tracking')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Attendance Options</h1>
        <p class="text-gray-600 mt-1">Welcome to Site Sync <span class="font-bold text-navy" style="text-transform: capitalize;">{{ auth()->user()->name }}</span> Panel</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <a href="{{ route('admin.attendances.today') }}" class="block group">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full transition-all duration-300 hover:shadow-md hover:border-saffron hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Today's Activity</h3>
                    <p class="text-3xl font-bold text-navy">{{ $stats['today_attendances'] }}</p>
                    <p class="text-sm text-gray-400 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Check-ins today
                    </p>
                </div>
                <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.attendances') }}" class="block group">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full transition-all duration-300 hover:shadow-md hover:border-saffron hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Historical Data</h3>
                    <p class="text-3xl font-bold text-navy">All Logs</p>
                    <p class="text-sm text-gray-400 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        View all past check-ins
                    </p>
                </div>
                <div class="p-4 bg-saffron/20 text-yellow-700 rounded-2xl group-hover:bg-saffron group-hover:text-navy transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <div class="block group cursor-pointer" onclick="showRestrictedAlert()">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full transition-all duration-300 hover:shadow-md hover:border-red-400 hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Data Management</h3>
                    <p class="text-3xl font-bold text-gray-400">Cleanup</p>
                    <p class="text-sm text-gray-400 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Delete old records
                    </p>
                </div>
                <div class="p-4 bg-gray-50 text-gray-400 rounded-2xl group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showRestrictedAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Access Restricted',
            html: `
                <div class="text-left mt-2">
                    <p class="mb-3 text-gray-700">This feature is <strong>restricted by the Super Admin</strong> for security purposes.</p>
                    <p class="text-sm text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">Please contact your Super Admin if you need access to delete old attendance records.</p>
                </div>
            `,
            confirmButtonText: 'Understood',
            confirmButtonColor: '#1a2639',
            buttonsStyling: true,
            customClass: {
                confirmButton: 'px-6 py-2.5 rounded-lg font-bold shadow-sm',
                popup: 'rounded-2xl shadow-xl border border-gray-100',
                title: 'text-xl font-bold text-navy'
            }
        });
    }
</script>
@endsection