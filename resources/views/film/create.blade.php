@extends('layouts.app')


@section('content')
    <div class="container section">
{{--        <h1 class="title">Create film</h1>--}}
        <hero :main-title="'Create a Film'"></hero>
    </div>
    <section class="section">
        <div class="container">
            <film-form></film-form>
        </div>
    </section>
@endsection
