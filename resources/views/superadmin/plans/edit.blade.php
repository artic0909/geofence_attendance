@extends('superadmin.layouts.app')

@section('title', 'Edit Plan')
@section('page_title', 'Edit Plan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Plan: {{ $plan->name }}</h2>
        <a href="{{ route('superadmin.plans.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Back to Plans</a>
    </div>

    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('superadmin.plans.update', $plan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                        <input type="text" name="name" id="name" value="{{ $plan->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">{{ $plan->description }}</textarea>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="monthly_price" class="block text-sm font-medium text-gray-700">Monthly Price (₹)</label>
                        <input type="number" step="0.01" name="monthly_price" id="monthly_price" value="{{ $plan->monthly_price }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="yearly_price" class="block text-sm font-medium text-gray-700">Yearly Price (₹)</label>
                        <input type="number" step="0.01" name="yearly_price" id="yearly_price" value="{{ $plan->yearly_price }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <label for="features" class="block text-sm font-medium text-gray-700">Features (comma separated)</label>
                        <input type="text" name="features" id="features" value="{{ is_array($plan->features) ? implode(', ', $plan->features) : '' }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-navy focus:border-navy sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="active" name="active" type="checkbox" value="1" {{ $plan->active ? 'checked' : '' }} class="focus:ring-navy h-4 w-4 text-navy border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="active" class="font-medium text-gray-700">Active</label>
                                <p class="text-gray-500">Is this plan visible to users?</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-navy border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
