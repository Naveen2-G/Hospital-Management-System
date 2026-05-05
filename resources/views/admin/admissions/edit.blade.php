@extends('admin.layouts.app')
@section('title', 'Edit Admission')
@section('content')
    @include('admin.admissions.create', ['admission' => $admission, 'patients' => $patients, 'doctors' => $doctors, 'beds' => $beds])
@endsection
