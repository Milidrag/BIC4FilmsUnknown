@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <!-- here's a table showing all films in database -->
            <datatable-light :table-title="'All Films'"
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
                             :initial-data="'{{ $film }}'"
                             :sort="'yes'">
            </datatable-light>

        </div>
    </section>
@endsection
