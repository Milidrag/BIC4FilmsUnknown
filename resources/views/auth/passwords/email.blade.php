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
                            @if (session('status'))
                                <article class="message is-success">
                                    <div class="message-body">
                                        {{ session('status') }}
                                    </div>
                                </article>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                                        <input name="email" id="email"
                                               class="form-control @error('email') is-danger @enderror"
                                               type="email"
                                               value="{{ old('email') }}" autocomplete="email" autofocus>
                                    @error('email')
                                    <p class="help is-danger">{{ $message }}</p>
                                    @enderror
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
