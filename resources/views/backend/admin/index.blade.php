@extends('backend.layout.app')
@section('title', 'Welcome')

@section('main-content')
<div class="container py-5">

    <!-- Welcome Card -->
    <div class="card shadow-lg border-0 rounded-4" style="overflow:hidden;">
        <div class="row g-0">

            <!-- Left side color strip -->
            <div class="col-md-3 d-flex align-items-center justify-content-center text-white"
                 style="background: linear-gradient(135deg, #007bff, #6610f2); min-height: 220px;">
                <div>
                    <h1 class="fw-bold display-6 mb-2">Welcome</h1>
                    <p class="mb-0 fs-5">Admin Panel</p>
                </div>
            </div>

            <!-- Right side content -->
            <div class="col-md-9 p-4 d-flex align-items-center">
                <div>
                    <h3 class="fw-semibold mb-3">Hello, Admin!</h3>
                    <p class="text-muted mb-4">
                        You are logged in to the management dashboard.  
                        Use the sidebar to navigate through operations, manage records, and monitor activity.
                    </p>

                    {{-- <a href="{{ route('home') }}" class="btn btn-primary px-4">
                        Go to Dashboard
                    </a> --}}
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="row mt-5">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                <h4 class="fw-bold text-primary">Users</h4>
                <p class="text-muted">Manage all registered users</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                <h4 class="fw-bold text-success">Operations</h4>
                <p class="text-muted">Monitor and manage operations</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3 p-3 text-center">
                <h4 class="fw-bold text-danger">Reports</h4>
                <p class="text-muted">View performance and analytics</p>
            </div>
        </div>

    </div>

</div>
@endsection
