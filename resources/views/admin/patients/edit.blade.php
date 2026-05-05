@extends('admin.layouts.app')
@section('title', 'Edit Patient')
@section('content')
    @include('admin.patients.create', ['patient' => $patient])
@endsection
