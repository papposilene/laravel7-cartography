<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - {{ setting('app_name', config('app.name', 'Laravel Cartography')) }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }} " />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body id="app">
<div class="container px-4">
    <div class="row">
        <main role="main" class="col-12">
            <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ setting('app_name', config('app.name', 'Laravel Cartography')) }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-folder" aria-hidden="true"></i>
                                @ucfirst(__('app.categories'))
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                @foreach ($menuCategories as $menuCategory)
                                <a class="dropdown-item" href="{{ route('public.category.show', ['slug' => $menuCategory->slug]) }}">
                                    <i class="{{ $menuCategory->icon }}" aria-hidden="true"></i>
                                    @ucfirst($menuCategory->name)
                                </a>
                                @endforeach
                            </div>
                        </li>
                        @isset ($category)
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#modalAddressesList">
                                <i class="fas fa-list" aria-hidden="true"></i>
                                @ucfirst(__('app.addressesList'))
                            </a>
                        </li>
                        @endisset
                        @endauth
                    </ul>
                    <ul class="navbar-nav mt-2 mt-md-0">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('auth.login'))</span>
                            </a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('auth.register'))</span>
                            </a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <i class="fas fa-database" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.admin'))</span>
                            </a>
                        </li>
                        <form action="{{ route('logout') }}" method="POST" class="form-inline" id="logout-form">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('auth.logout'))</span>
                            </a>
                        </form>
                        @endguest
                    </ul>
                </div>
            </nav>
            
            @if ($errors->any())
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
                <div class="col alert alert-danger">
                    <ol>
                        @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @endif
        
            @yield('content')
            
            @include('layouts.footer')
        </main>
    </div>
</div>
    
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</body>
</html>
