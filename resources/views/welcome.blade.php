@extends('layouts.app')

@section('content')
    @include('components.navbar')
    @include('components.hero')
    @include('components.quick-services')
    @include('components.doctors')
    @include('components.testimonials')
    @include('components.why-choose-us')
    @include('components.stats')
    @include('components.appointment-cta')
    @include('components.footer')

    {{-- Modals --}}
    @include('components.login-modal')
    @include('components.register-modal')
    @include('components.appointment-modal')
    @include('components.forgot-password-modal')
    @include('components.package-checkout-modal')
    @include('components.special-booking-modal')
@endsection
