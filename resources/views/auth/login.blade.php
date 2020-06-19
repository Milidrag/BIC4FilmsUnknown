@extends('layouts.app')

@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-multiline">
                <div class="card custom-card">
                    <header class="card-header bg-primary">
                        <h1 class="card-header-title text-center">{{ __('Sign In') }}</h1>
                    </header>
                    <div class="card-body">
                        <div class="content">
                            @if (session('status'))
                                <article class="message is-success">
                                    <div class="message-body">
                                        {{ session('status') }}
                                    </div>
                                </article>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" title="email" name="email" type="email" required
                                           autocomplete="email" autofocus
                                           class="form-control @error('email') is-danger @enderror"
                                           value="{{old('email')}}">
                                    @error('email')
                                    <p class="help is-danger">Email is not valid</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <input id="password" title="password" name="password" type="password" required
                                           autocomplete="current-password"
                                           class="form-control @error('password') is-danger @enderror">
                                    @error('email')
                                    <p class="help is-danger">Password is not valid</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label"
                                               for="remember"> {{ __('Remember Me') }} </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="text-center">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link level-right"
                                               href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </p>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
