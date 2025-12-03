@extends('backend.layout.app')
@section('title', 'Welcome')

@section('main-content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h4>Clerk Dashboard</h4>
            <p>Welcome, {{ Auth::user()->name }}</p>

            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary w-100">Open Inventory</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
