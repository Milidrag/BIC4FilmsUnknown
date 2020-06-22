@extends('layouts.app')


@section('content')
    <section class="section">
        <show :current-object="{{$film}}"></show>
    </section>
@endsection
