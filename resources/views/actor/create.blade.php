@extends('layouts.app')


@section('content')
    <div class="container section">
        <hero :main-title="'Create an Actor'"></hero>
{{--        <h1 class="title">Create actor</h1>--}}
    </div>
    <section class="section">
        <div class="container">
            <actor-form></actor-form>
        </div>
    </section>
@endsection
