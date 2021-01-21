@extends('layouts.app')
@section('title', @ucfirst(__('auth.login')))

@section('content')
<form method="POST" action="{{ route('login') }}" class="row d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
    @csrf
    <div class="col-12 col-md-7 pt-5">
        <div class="card">
            <h5 class="card-header">
                @ucfirst(__('auth.login'))
            </h5>
            <div class="card-body">   
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">@ucfirst(__('auth.email'))</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">@ucfirst(__('auth.password'))</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @ucfirst(__('auth.remember'))
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row pt-5 mb-2">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @ucfirst(__('auth.login'))
                        </button>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            @ucfirst(__('auth.forgot'))
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
                
    </div>
</form>
@endsection
