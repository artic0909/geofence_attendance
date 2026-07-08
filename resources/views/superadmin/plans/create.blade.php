@extends('superadmin.layouts.app')

@section('title', 'Create Plan')
@section('page_title', 'Create New Plan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Create New Plan</h2>
        <a href="{{ route('superadmin.plans.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Back to Plans</a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('superadmin.plans.store') }}" method="POST">
                @csrf

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
                    <div class="col-span-6 sm:col-span-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm"></textarea>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="price" class="block text-sm font-medium text-gray-700">Fixed Base Charge (₹)</label>
                        <input type="number" step="0.01" name="price" id="price" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="price_per_employee" class="block text-sm font-medium text-gray-700">Price per Employee (₹)</label>
                        <input type="number" step="0.01" name="price_per_employee" id="price_per_employee" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm" value="0.00">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="duration_days" class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                        <input type="number" name="duration_days" id="duration_days" value="30" required min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="employee_count" class="block text-sm font-medium text-gray-700">Included Employees (Base Count)</label>
                        <input type="number" name="employee_count" id="employee_count" value="10" required min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <label for="features" class="block text-sm font-medium text-gray-700">Features (comma separated)</label>
                        <input type="text" name="features" id="features" placeholder="Feature 1, Feature 2, Feature 3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="active" name="active" type="checkbox" value="1" checked class="focus:ring-navy h-4 w-4 text-navy border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="active" class="font-medium text-gray-700">Active</label>
                                <p class="text-gray-500">Is this plan visible to users?</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_popular" name="is_popular" type="checkbox" value="1" class="focus:ring-navy h-4 w-4 text-navy border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_popular" class="font-medium text-gray-700">Popular</label>
                                <p class="text-gray-500">Highlight this plan on the frontend.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_trial" name="is_trial" type="checkbox" value="1" class="focus:ring-navy h-4 w-4 text-navy border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_trial" class="font-medium text-gray-700">Trial Plan</label>
                                <p class="text-gray-500">Mark this plan as the trial plan (used in the app when users don't have a subscription).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-navy border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                        Save Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
