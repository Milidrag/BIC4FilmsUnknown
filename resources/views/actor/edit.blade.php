@extends('layouts.app')


@section('content')
    <section class="section">
        <edit-actor :current-actor="{{$actor}}"></edit-actor>
    </section>
@endsection
