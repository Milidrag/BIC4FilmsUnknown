@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <create-film :is-editable="true" :current-film="{{$film}}"></create-film>
        </div>
    </section>
@endsection
