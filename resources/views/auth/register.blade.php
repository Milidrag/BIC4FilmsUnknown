@extends('layouts.app')

@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-multiline">
                <div class="card custom-card">
                    <header class="card-header bg-primary">
                        <h1 class="card-header-title text-center">{{ __('Register') }}</h1>
                    </header>
                    <div class="card-body">
                        <div class="content">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="name">{{ __('Name') }}</label>
                                    <input name="name" class="form-control @error('name') is-danger @enderror"
                                               type="text" id="name"
                                               value="{{ old('name') }}" required autocomplete="name"
                                               autofocus>
                                    @error('name')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input name="email" id="email" class="form-control @error('email') is-danger @enderror"
                                               type="email" required>
                                    @error('email')
                                    <p class="help is-danger">Email is not valid</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <input name="password" id="password"
                                               class="form-control @error('password') is-danger @enderror"
                                               type="password"
                                               required>
                                    @error('password')
                                    <p class="help is-danger">Password is not valid</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password-confirm">Confirm Password</label>
                                    <input class="form-control field-spacer" type="password"
                                               id="password-confirm" name="password_confirmation"
                                               required>
                                </div>

                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    {{ __('Register') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
