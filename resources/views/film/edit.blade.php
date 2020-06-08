@extends('layouts.app')


@section('content')
    <section class="section is-fullheight">
        <div class="container">
            <h1 class="title">Edit film</h1>
                <film-form :is-editable="true" :current-film="{{ $film }}"></film-form>
        </div>
    </section>
@endsection
