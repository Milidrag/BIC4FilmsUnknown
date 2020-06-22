@extends('layouts.app')


@section('content')
    <section class="section">
        <show :current-object="{{$actor}}"></show>
    </section>
@endsection
