@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
{{--            <h1 class="title">List film</h1>--}}
            <films :current-title="'All Films'" :all-films="{{ $film->load('actors') }}" ></films>
        </div>
    </section>
@endsection
