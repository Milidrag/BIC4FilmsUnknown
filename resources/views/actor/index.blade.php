@extends('layouts.app')


@section('content')
    <section class="section">
            <actors :all-actors="{{$actors}}"></actors>
    </section>
@endsection
