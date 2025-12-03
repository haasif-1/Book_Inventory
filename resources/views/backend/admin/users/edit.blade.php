@extends('backend.layout.app')
@section('title', 'Edit User')

@section('main-content')

    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit User</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                @foreach ($roles as $role)
                                    @if ($role->name !== 'client')
                                        {{-- HIDE CLIENT ROLE --}}
                                        <option value="{{ $role->name }}"
                                            {{ $user->roles->first()->name == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">Update User</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection
