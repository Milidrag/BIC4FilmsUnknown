@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <actors :all-actors="{{ $actor->load('film') }}" ></actors>
        </div>
    </section>
@endsection
