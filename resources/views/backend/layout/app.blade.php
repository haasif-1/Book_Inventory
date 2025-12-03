<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full">

        <!--  App Topstrip -->
        {{-- <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        <a class="d-flex justify-content-center" href="#">
          <img src="assets/images/logos/logo-wrappixel.svg" alt="" width="150">
        </a>
      </div>
    </div> --}}
        <!-- Sidebar Start -->
        @include('backend.include.sidebar')
        <!--  Sidebar End -->
        {{-- @include('backend.pages.user.change-password') --}}
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('backend.include.header')
            <!--  Header End -->
            <div class="body-wrapper-inner">
                <div class="container">
                    <!--  Row 1 -->
                    @yield('main-content')
                    {{-- @include('backend.include.footer') --}}
                </div>
            </div>
        </div>
    </div>
    @include('backend.include.script')
</body>

</html>
