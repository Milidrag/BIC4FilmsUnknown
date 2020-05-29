
<!-- <meta name="csrf-token" content="{{ csrf_token() }}">
-->

@extends('layouts.app')

<!--
alternative
https://docs.laravel-enso.com/backend/tables.html#template
https://vuejsexamples.com/high-performance-plugin-based-vue-data-grid-for-bootstrap/
https://github.com/OneWayTech/vue2-datatable

// edit modal
https://github.com/Egorvah/vudal
-->

@section('content')
    <section class="section">
        <div class="container">
            <h1>List actors</h1>
            <br>
            <datatable-light :table-title="'All Actors'"
                             :header-fields='[
                                "__slot:checkboxes",
                                {
                                name: "slug",
                                label: "Slug",
                                sortable: true
                                },
                                {
                                name: "name",
                                label: "Name",
                                sortable: true
                                },
                                {
                                name: "description",
                                label: "Description",
                                sortable: true,
                                customElement: "DescriptionNew"
                                },
                                {
                                name: "film_id",
                                label: "FilmNr",
                                sortable: true
                                },
                                {
                                name: "created_at",
                                label: "Created",
                                sortable: false,
                                isDate:    true
                                },
                                {
                                name: "updated_at",
                                label: "Updated",
                                sortable: false,
                                isDate:    true
                                },
                                "__slot:actions:actionFirst",
                                "__slot:actions"
                                ]'
                             :track-by="'slug'"
                             :initial-data="'{{ $actor }}'"
                             :sort="'yes'"
            ></datatable-light>



            <br>
            <br>
            <div id="app">
                <div class="columns medium-3" v-for="(result, index) in results" :key="index">
                    <div class="card">
                        <div class="card-divider">
                            <p v-text="result.id"> </p>
                        </div>
                        <div class="card-section">
                            <p v-text="result.slug"> </p>
                            <p v-text="index"> </p>
                        </div>
                    </div>
                </div>



                <ul>
                    <li v-for="name in names" v-text="name"></li>
                </ul>

                <input type="text" v-model="newName">
                <button @click="addName">
                    Add Name
                </button>
            </div>
            <br>
            <br>




            <div id="container1">
            </div>



        </div>
    </section>
@endsection
