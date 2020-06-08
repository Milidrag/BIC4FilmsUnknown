@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
            <h1 class="title">Show actor</h1>
            <actor :current-actor="{{ $actor->load('film') }}"
                   ></actor>
        </div>
    </section>
@endsection
