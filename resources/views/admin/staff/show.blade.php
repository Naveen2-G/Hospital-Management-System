@extends('admin.layouts.app')
@section('title', $staff->name)
@section('content')
    <div class="mb-6"><a href="{{ route('admin.staff.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2"><h1 class="text-2xl font-bold text-gray-900">{{ $staff->name }}</h1><a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-secondary btn-sm">Edit</a></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach(['Email'=>$staff->email??'—','Phone'=>$staff->phone??'—','Designation'=>$staff->designation??'—','Department'=>$staff->department->name??'—','Joining Date'=>$staff->joining_date?$staff->joining_date->format('M d, Y'):'—','Salary'=>'₹'.number_format($staff->salary),'Status'=>ucfirst($staff->status)] as $l=>$v)
                <div><dt class="text-xs font-medium text-gray-400 uppercase">{{ $l }}</dt><dd class="text-sm text-gray-800 mt-1">{{ $v }}</dd></div>
                @endforeach
            </dl>
        </div>
        <div class="admin-card text-center">
            <div class="w-16 h-16 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3">{{ strtoupper(substr($staff->name,0,1)) }}</div>
            <h3 class="font-semibold text-gray-900">{{ $staff->name }}</h3>
            <p class="text-sm text-gray-500">{{ $staff->designation ?? 'Staff' }}</p>
            <span class="badge {{ $staff->status==='active'?'badge-success':'badge-gray' }} mt-2">{{ ucfirst($staff->status) }}</span>
        </div>
    </div>
@endsection
