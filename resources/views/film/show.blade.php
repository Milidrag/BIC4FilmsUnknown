@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
{{--            <h1 class="title">Show film</h1>--}}
                <film :film="{{ $film }}" :actors="{{ $film->actors }}"></film>
{{--                <film :film="{{ $film }}" :actors="{{ $film->actors->load(['user','messages']) }}"></film>--}}
        </div>
    </section>
@endsection
