@extends('layouts.app')


@section('content')
    <section class="section">
        <create-actor :is-editable="true" :current-actor="{{$actor}}"></create-actor>
    </section>
@endsection
