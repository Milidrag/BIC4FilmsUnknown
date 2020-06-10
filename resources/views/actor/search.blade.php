@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
{{--            <h1 class="title">Search actor</h1>--}}
            <hero :main-title="'Search for Actors'"></hero>
            <br>
            <search-form></search-form>
        </div>
    </section>
@endsection
