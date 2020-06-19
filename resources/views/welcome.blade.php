@extends('layouts.app')

@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <h1 class="title">
                {{ env('APP_TITLE', 'Sample application') }}
            </h1>
        </div>
    </section>
@endsection
