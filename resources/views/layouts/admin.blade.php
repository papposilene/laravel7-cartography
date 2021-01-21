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
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }} " />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
</head>

<body id="app">
<div class="container px-4">
    <div class="row">
        <main role="main" class="col-12">
            <nav class="container navbar navbar-expand-md navbar-light fixed-top bg-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ setting('app_name', config('app.name', 'Laravel Cartography')) }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                @ucfirst(__('app.home'))
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.category.index') }}">
                                <i class="fas fa-folder-open" aria-hidden="true"></i>
                                @ucfirst(__('app.categories'))
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.address.index') }}">
                                <i class="fas fa-address-book" aria-hidden="true"></i>
                                @ucfirst(__('app.addresses'))
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.country.index') }}">
                                <i class="fas fa-globe" aria-hidden="true"></i>
                                @ucfirst(__('app.countries'))
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav  mt-2 mt-md-0">
                        @role('superAdmin')
                        <li class="nav-item">
                            <span class="nav-link" href="#">
                                @if ((bool) setting('is_public') === (bool) 1)
                                <i class="fas fa-unlock text-success" aria-hidden="true"
                                    title="@ucfirst(__('app.settingsAppPublic'))"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.public'))</span>
                                @else
                                <i class="fas fa-lock text-danger" aria-hidden="true"
                                    title="@ucfirst(__('app.settingsAppPrivate'))"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.private'))</span>
                                @endif
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url(config('app_settings.url')) }}">
                                <i class="fas fa-cog" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.activity'))</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.index') }}">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.users'))</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.activity.index') }}">
                                <i class="fas fa-file-signature" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.activity'))</span>
                            </a>
                        </li>
                        @endrole
                        @role('admin|editor')
                        <li class="nav-item">
                            <span class="nav-link" href="#">
                                @if ((bool) setting('is_public') === (bool) 1)
                                <i class="fas fa-unlock text-success" aria-hidden="true"
                                    title="@ucfirst(__('app.settingsAppPublic'))"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.public'))</span>
                                @else
                                <i class="fas fa-lock text-danger" aria-hidden="true"
                                    title="@ucfirst(__('app.settingsAppPrivate'))"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.private'))</span>
                                @endif
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.index') }}">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.users'))</span>
                            </a>
                        </li>
                        @endrole
                        @role('guest')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.show', ['uuid' => Auth::id()]) }}">
                                <i class="fas fa-user" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('app.users'))</span>
                            </a>
                        </li>
                        @endrole
                        <form action="{{ route('logout') }}" method="POST" class="form-inline" id="logout-form">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                                <span class="d-inline d-sm-none">@ucfirst(__('auth.logout'))</span>
                            </a>
                        </form>
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
