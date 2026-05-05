@extends('admin.layouts.app')
@section('title', $doctor->name)
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.doctors.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Doctors
        </a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-900">{{ $doctor->name }}</h1>
            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Doctor Information</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach(['Email'=>$doctor->email??'—','Phone'=>$doctor->phone??'—','Department'=>$doctor->department->name??'—','Specialization'=>$doctor->specialization??'—','Qualification'=>$doctor->qualification??'—','Experience'=>$doctor->experience_years.'+ years','Consultation Fee'=>'₹'.number_format($doctor->consultation_fee),'Status'=>ucfirst($doctor->status)] as $label=>$val)
                <div><dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $label }}</dt><dd class="text-sm text-gray-800 mt-1">{{ $val }}</dd></div>
                @endforeach
            </dl>
        </div>
        <div class="admin-card text-center">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3">{{ strtoupper(substr($doctor->name, 0, 1)) }}</div>
            <h3 class="font-semibold text-gray-900">{{ $doctor->name }}</h3>
            <p class="text-sm text-gray-500">{{ $doctor->specialization ?? 'Doctor' }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $doctor->appointments->count() }} appointments</p>
        </div>
    </div>
@endsection
