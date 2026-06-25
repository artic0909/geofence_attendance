@extends('superadmin.layouts.app')

@section('title', 'Edit Organization')
@section('header', 'Edit Organization: ' . $organization->business_name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('superadmin.organizations.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Organizations</a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Update Organization Details</h3>
        </div>
        <div class="p-6 bg-white">
            <form action="{{ route('superadmin.organizations.update', $organization->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1 md:col-span-2">
                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Business Information</h4>
                    </div>

                    <div>
                        <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name *</label>
                        <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $organization->business_name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('business_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="business_type" class="block text-sm font-medium text-gray-700">Business Type</label>
                        <input type="text" name="business_type" id="business_type" value="{{ old('business_type', $organization->business_type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('business_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="gst_number" class="block text-sm font-medium text-gray-700">GST Number</label>
                        <input type="text" name="gst_number" id="gst_number" value="{{ old('gst_number', $organization->gst_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('gst_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Admin Information</h4>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Admin Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $organization->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Admin Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $organization->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Admin Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $organization->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password (Leave blank to keep current)</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-4">
                        <h4 class="text-md font-semibold text-gray-700 border-b pb-2 mb-4">Address Details</h4>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                        <input type="text" name="address_line_1" id="address_line_1" value="{{ old('address_line_1', $organization->address_line_1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('address_line_1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $organization->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                        <input type="text" name="state" id="state" value="{{ old('state', $organization->state) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700">Zip Code</label>
                        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $organization->zip_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('zip_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $organization->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Organization</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Organization
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
