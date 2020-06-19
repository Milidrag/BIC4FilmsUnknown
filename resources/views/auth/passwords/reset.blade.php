@extends('layouts.app')

@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-multiline">
                <div class="card custom-card">
                    <header class="card-header bg-primary">
                        <h1 class="card-header-title text-center">{{ __('Reset Password') }}</h1>
                    </header>
                    <div class="card-body">
                        <div class="content">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                                    <input name="email" class="form-control @error('email') is-danger @enderror"
                                           type="email" id="email"
                                           value="{{ $email ?? old('email') }}" required autocomplete="email"
                                           autofocus>
                                    @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                    <input name="password" class="form-control @error('password') is-danger @enderror"
                                           type="password" id="password"
                                           required autocomplete="new-password">
                                    @error('password')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label"
                                           for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input class="form-control" type="password"
                                           id="password-confirm" name="password_confirmation"
                                           required autocomplete="new-password">
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
