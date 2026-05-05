@extends('admin.layouts.app')@section('title', 'Edit Staff')@section('content')@include('admin.staff.create', ['staff' => $staff, 'departments' => $departments])@endsection
