@extends('admin.layouts.app')
@section('title', 'Edit Appointment')
@section('content')
    @include('admin.appointments.create', ['appointment'=>$appointment, 'patients'=>$patients, 'doctors'=>$doctors, 'departments'=>$departments])
@endsection
