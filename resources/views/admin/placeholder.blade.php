@extends('admin.layouts.app')
@section('title', $title ?? 'Coming Soon')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Module' }}</h1>
    </div>

    <div class="admin-card">
        <div class="empty-state py-16">
            <svg class="mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384-3.115A1.999 1.999 0 004 13.92V19.5a1.5 1.5 0 001.5 1.5h13a1.5 1.5 0 001.5-1.5v-5.58a2 2 0 00-2.036-1.865L12.58 15.17a2 2 0 01-1.16 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5V7.312a2 2 0 00-1.058-1.765L12.58 2.442a2 2 0 00-1.16 0L5.558 5.547A2 2 0 004.5 7.312V10.5"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-400 max-w-md mx-auto">This module is being built. Full CRUD functionality will be available soon.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm mt-6 inline-flex">
                ← Back to Dashboard
            </a>
        </div>
    </div>
@endsection
