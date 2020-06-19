@extends('layouts.app')

@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <div class="columns is-multiline">
                <div class="card custom-card">
                    <header class="card-header bg-primary">
                        <h1 class="card-header-title text-center">Dashboard</h1>
                    </header>
                    <div class="card-body">
                        @if (session('status'))
                            <query-message :success="true" :fail="false"
                                           message="{{ session('status') }}"></query-message>
                        @endif
                        <p>Welcome <strong>{{ auth()->user()->name }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
