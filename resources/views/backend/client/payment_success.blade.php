@extends('backend.layout.app')
@section('title', 'Payment Successful')

@section('main-content')

<div class="container text-center py-5">

    <img src="{{ asset('success.png') }}" width="150" class="mb-4">

    <h3>Thank you! Your order has been placed.</h3>
    <p class="text-muted mb-3">You will receive a confirmation message shortly.</p>

    <a href="{{ route('client.dashboard') }}" class="btn btn-primary mt-3">
        Go to Dashboard
    </a>

</div>

@endsection
