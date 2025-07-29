@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <a href="/" class="d-inline-block mb-2">
                            <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" alt="BFAR Logo" style="width: 120px;">
                        </a>
                        <h4 class="mb-1">Welcome to {{ __('Login') }}! 👋</h4>
                        <p class="mb-3 text-muted">Please sign-in to your account and start the adventure</p>
                    </div>
                    <form id="formAuthentication" action="{{ route('login') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Enter your password" required autocomplete="current-password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary" type="submit">{{ __('Login') }}</button>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="mb-2 text-center">
                                <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                    <p class="text-center mt-3 mb-0">
                        <span>New on our platform?</span>
                        <a href="/register">
                            <span>Create an account</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection