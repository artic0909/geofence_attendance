@extends('superadmin.layouts.app')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')
@section('page_title', isset($coupon) ? 'Edit Coupon' : 'Create New Coupon')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ isset($coupon) ? 'Edit Coupon' : 'Create New Coupon' }}</h2>
        <a href="{{ route('superadmin.coupons.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Back to Coupons</a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ isset($coupon) ? route('superadmin.coupons.update', $coupon) : route('superadmin.coupons.store') }}" method="POST">
                @csrf
                @if(isset($coupon))
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Coupon Code (Name)</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $coupon->name ?? '') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="no_of_employee" class="block text-sm font-medium text-gray-700">Number of Employees</label>
                        <input type="number" name="no_of_employee" id="no_of_employee" value="{{ old('no_of_employee', $coupon->no_of_employee ?? '') }}" required min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                        <input type="number" name="duration" id="duration" value="{{ old('duration', $coupon->duration ?? '') }}" required min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-navy border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                        {{ isset($coupon) ? 'Update Coupon' : 'Save Coupon' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection