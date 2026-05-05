@extends('admin.layouts.app')
@section('title', 'Edit Room')
@section('content')
    @include('admin.rooms.create', ['room' => $room])
@endsection
