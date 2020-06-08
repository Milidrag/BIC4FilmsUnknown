@extends('layouts.app')


@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <h1 class="title">Edit actor</h1>
            <actor-form :is-editable="true" :current-actor="{{ $actor }}"></actor-form>
        </div>
    </section>
@endsection
