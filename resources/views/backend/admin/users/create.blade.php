@extends('backend.layout.app')
@section('title','Create User')

@section('main-content')
    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-light">
                <h3 class="card-title mb-0 text-white">Create New User</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="clerk">Clerk</option>
                            </select>
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary">Create User</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
