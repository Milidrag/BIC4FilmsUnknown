@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
            <h1 class="title">List actors</h1>
                <actors :all-actors="{{ $actor }}" ></actors>
{{--                <actors :all-actors="{{ $actor }}" :current-user="{{ Auth::user() }}"></actors>--}}
        </div>
    </section>
@endsection
