@extends('admin.layouts.app')
@section('title', isset($labTest) ? 'Edit Lab Test' : 'Add Lab Test')
@section('content')
    <div class="mb-6"><a href="{{ route('admin.lab-tests.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a><h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($labTest) ? 'Edit Lab Test' : 'Add Lab Test' }}</h1></div>
    <div class="admin-card max-w-2xl">
        <form method="POST" action="{{ isset($labTest) ? route('admin.lab-tests.update', $labTest) : route('admin.lab-tests.store') }}">@csrf @if(isset($labTest)) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Test Name *</label><input type="text" name="name" value="{{ old('name', $labTest->name ?? '') }}" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Category</label><input type="text" name="category" value="{{ old('category', $labTest->category ?? '') }}" class="form-input" placeholder="e.g. Hematology"></div>
                <div class="form-group"><label class="form-label">Price (₹) *</label><input type="number" name="price" value="{{ old('price', $labTest->price ?? 0) }}" class="form-input" min="0" step="0.01" required></div>
                <div class="form-group md:col-span-2"><label class="form-label">Description</label><textarea name="description" rows="2" class="form-input">{{ old('description', $labTest->description ?? '') }}</textarea></div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100"><button type="submit" class="btn btn-primary">{{ isset($labTest) ? 'Update' : 'Add Test' }}</button><a href="{{ route('admin.lab-tests.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
@endsection
