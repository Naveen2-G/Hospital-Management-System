@extends('admin.layouts.app')
@section('title', 'Edit Medicine')
@section('content')@include('admin.pharmacy.create', ['medicine' => $medicine])@endsection
