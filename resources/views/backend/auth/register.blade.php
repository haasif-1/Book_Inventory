<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="page-wrapper" id="main-wrapper">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">

                        <div class="text-center mb-3">
                            <img src="{{ asset('logo.png') }}" width="100">
                            <p class="mt-3 fw-bold">Create Your Account</p>
                        </div>

                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- HUMAN CHECKER -->
                            @php
                                $n1 = rand(1, 9);
                                $n2 = rand(1, 9);
                                session(['sum_check' => $n1 + $n2]);
                            @endphp

                            <div class="mb-3">
                                <label class="form-label">Are you human? What is {{ $n1 }} +
                                    {{ $n2 }} ?</label>
                                <input type="number" class="form-control" name="human_check" required>
                            </div>

                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                        </form>

                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account?
                                <a href="{{ route('login.page') }}" class="text-primary">Sign In</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
