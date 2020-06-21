@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <films :all-films="{{$films}}"></films>
        </div>
    </section>
@endsection
