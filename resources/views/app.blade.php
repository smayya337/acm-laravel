<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ACM @ UVA')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@100..900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@100..900&display=swap"
          rel="stylesheet">
    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/fontawesome.min.css'])
</head>
<body class="min-h-screen flex flex-col">
{{--TODO: make nav more mobile-friendly--}}
<div class="navbar bg-base-100 shadow-sm">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('events') }}">Events</a></li>
                <li><a href="{{ route('icpc') }}">ICPC</a></li>
                <li><a href="{{ route('hspc') }}">HSPC</a></li>
                <li><a href="{{ route('donate') }}">Donate</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost text-xl" href="{{ route('home') }}"><img src="{{ url('/acm.svg') }}" style="height: 2rem;" class="me-3"
                                                                          alt="ACM @ UVA Logo"/>ACM @ UVA</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('events') }}">Events</a></li>
            <li><a href="{{ route('icpc') }}">ICPC</a></li>
            <li><a href="{{ route('hspc') }}">HSPC</a></li>
            <li><a href="{{ route('donate') }}">Donate</a></li>
        </ul>
    </div>
    <div class="navbar-end">
        @auth
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    @if(Auth::user()->image)
                        <img
                            alt="Tailwind CSS Navbar component"
                            src="{{ url(Auth::user()->image) }}" />
                    @else
                        <span class="fa-solid fa-user"></span>
                    @endif
                </div>
            </div>
            <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a class="justify-between" href="{{ route('user_page', ['username' => Auth::user()->username]) }}">
                        Profile
                    </a>
                </li>
                @if(Auth::user()->is_admin)
                    <li>
                        <a class="justify-between" href="{{ route('admin') }}">
                            Admin
                        </a>
                    </li>
                @endif
                <li><a href="{{ route('logout') }}">Log Out</a></li>
            </ul>
        </div>
        @endauth
        @guest
            <a class="btn btn-ghost" href="{{ route('login') }}">Log In</a>
        @endguest
    </div>
</div>
<div class="container mx-auto prose py-8">
    @yield('content')
</div>
<div class="container mx-auto pb-8 prose">
    <footer class="flex flex-wrap">
        <small class="text-muted">Disclaimer: Although this organization has members who are University of Virginia
            students and may have University employees associated or engaged in its activities and affairs, the
            organization is not a part of or an agency of the University. It is a separate and independent organization,
            which is responsible for and manages its own activities and affairs. The University does not direct,
            supervise or control the organization and is not responsible for the organization's contracts, acts or
            omissions.</small>
        <small class="text-muted">© 2025 Association for Computing Machinery at the University of Virginia. All Rights
            Reserved.</small>
    </footer>
</div>
</body>
</html>
