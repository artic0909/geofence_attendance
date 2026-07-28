@extends('superadmin.layouts.app')

@section('title', 'Organizations')
@section('header', 'Organizations')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <!-- Search Form -->
        <form action="{{ route('superadmin.organizations.index') }}" method="GET" class="w-full md:w-1/3">
            <div class="relative">
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search organizations..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-navy focus:border-navy shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </form>

        <div class="flex space-x-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            <a href="{{ route('superadmin.organizations.index', ['search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ !request('filter') ? 'bg-navy text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">All</a>
            <a href="{{ route('superadmin.organizations.index', ['filter' => 'pending', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ request('filter') == 'pending' ? 'bg-navy text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">New / Pending</a>
            <a href="{{ route('superadmin.organizations.index', ['filter' => 'active', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ request('filter') == 'active' ? 'bg-navy text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">Active</a>
            <a href="{{ route('superadmin.organizations.index', ['filter' => 'expiring_soon', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ request('filter') == 'expiring_soon' ? 'bg-navy text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">Expiring (≤ 3 days)</a>
            <a href="{{ route('superadmin.organizations.index', ['filter' => 'expired', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap {{ request('filter') == 'expired' ? 'bg-navy text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">Expired</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="text-red-700 font-medium">{{ $errors->first() }}</p>
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Business Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Admin Info</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subscription</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($organizations as $org)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ($organizations->currentPage() - 1) * $organizations->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $org->business_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $org->business_type }}</div>
                            <div class="mt-1 flex space-x-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800" title="Employees Count">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    {{ $org->employees_count }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-teal-100 text-teal-800" title="Geofences Count">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $org->geofences_count }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $org->name }}</div>
                            <div class="text-xs text-gray-500">{{ $org->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $org->phone ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($org->subscription_status == 'active' && $org->subscription_expires_at)
                                @php
                                    $daysLeft = now()->diffInDays($org->subscription_expires_at, false);
                                    $color = $daysLeft > 3 ? 'text-green-600' : ($daysLeft >= 0 ? 'text-yellow-600' : 'text-red-600');
                                @endphp
                                <div class="text-sm font-medium text-gray-900">{{ $org->activeSubscription->plan_name ?? 'Plan' }}</div>
                                <div class="text-xs font-bold {{ $color }}">
                                    @if($daysLeft > 0)
                                        {{ ceil($daysLeft) }} days left
                                    @elseif($daysLeft == 0)
                                        Expires today
                                    @else
                                        Expired
                                    @endif
                                </div>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">None/Expired</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($org->is_active)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <!-- Employees -->
                                <a href="{{ url('superadmin/organizations/'.$org->id.'/employees') }}" class="text-blue-600 hover:text-blue-900" title="Employees">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </a>
                                <!-- Geofence -->
                                <a href="{{ url('superadmin/organizations/'.$org->id.'/geofences') }}" class="text-teal-600 hover:text-teal-900" title="Geofences">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </a>
                                <!-- Apply Coupon -->
                                <button type="button" onclick="openCouponModal('{{ $org->id }}', '{{ addslashes($org->business_name ?? $org->name) }}')" class="text-saffron hover:text-orange-600" title="Apply Coupon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                </button>
                                <!-- Edit -->
                                <a href="{{ route('superadmin.organizations.edit', $org->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <!-- Delete -->
                                <form action="{{ route('superadmin.organizations.destroy', $org->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span>No organizations found.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($organizations->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $organizations->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Coupon Modal -->
<div id="couponModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeCouponModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="couponForm" method="POST" action="">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-saffron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Apply Coupon</h3>
                            <p class="text-sm text-gray-500 mt-1">Applying to: <span id="couponOrgName" class="font-semibold text-gray-800"></span></p>
                            <div class="mt-4">
                                <label for="coupon_code" class="block text-sm font-medium text-gray-700">Coupon Code</label>
                                <input type="text" name="coupon_code" id="coupon_code" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm" placeholder="Enter coupon code">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-navy text-base font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy sm:ml-3 sm:w-auto sm:text-sm">Apply Coupon</button>
                    <button type="button" onclick="closeCouponModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCouponModal(orgId, orgName) {
        document.getElementById('couponOrgName').textContent = orgName;
        document.getElementById('couponForm').action = '{{ url("superadmin/organizations") }}/' + orgId + '/apply-coupon';
        document.getElementById('couponModal').classList.remove('hidden');
    }

    function closeCouponModal() {
        document.getElementById('couponModal').classList.add('hidden');
        document.getElementById('coupon_code').value = '';
    }
</script>
@endsection
