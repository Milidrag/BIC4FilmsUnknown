@extends('layouts.app')


@section('content')
    <section class="section is-fullwidth">
        <div class="container">
            <films :all-films="{{ $film }}" :current-title="'{{ $actor['name'] }} participates in the following film:'" > </films>
        </div>
    </section>
@endsection
