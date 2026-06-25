@extends('admin.layout')
@section('header_title', 'Edit Department')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 max-w-2xl mx-auto mt-8">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">Edit Department</h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.departments.update', $department) }}" method="POST" class="validate-form">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Department Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" data-rule-required="true" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-navy focus:border-navy">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.departments.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-[#233554] font-medium">Update Department</button>
            </div>
        </form>
    </div>
</div>
@endsection
