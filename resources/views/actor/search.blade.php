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
            <table-control :table-title="'Search for Actors'"
                           :edit-form-definition='
                                 [
                                    {
                                        fieldName: "slug",
                                        fieldLabel: "Slug",
                                        fieldIsDisplayed: false,
                                        isMandatory: true,
                                        validationFailedMessage: "A Slug is required",
                                        fieldType: "b-form-input",
                                        // data field must be specified otherwise v-bind does not work
                                        fieldData: ""

                                    },
                                    {
                                        fieldName: "name",
                                        fieldLabel: "Name",
                                        fieldIsDisplayed: true,
                                        isMandatory: true,
                                        validationFailedMessage: "A super Name is required",
                                        fieldType: "b-form-input",
                                        // data field must be specified otherwise v-bind does not work
                                        fieldData: ""
                                    },
                                    {
                                        fieldName: "description",
                                        fieldLabel: "Description",
                                        fieldIsDisplayed: true,
                                        isMandatory: true,
                                        validationFailedMessage: "A Description is required",
                                        fieldType: "b-form-input",
                                        fieldData: ""
                                    },
                                    {
                                        fieldName: "film_id",
                                        fieldLabel: "FilmId",
                                        fieldIsDisplayed: true,
                                        isMandatory: true,
                                        validationFailedMessage: "A FilmId is required",
                                        fieldType: "b-form-select",
                                        fieldData: ""
                                    }
                                ]
                                '
                           :header-fields='[
                                // "__slot:checkboxes",
                                // {
                                // name: "slug",
                                // label: "Slug",
                                // sortable: true
                                // },
                                {
                                name: "name",
                                label: "Name",
                                sortable: true
                                },
                                {
                                name: "description",
                                label: "Description",
                                sortable: true,
                                // customElement: "DescriptionNew"
                                },
                                // {
                                // name: "film_id",
                                // label: "FilmNr",
                                // sortable: true
                                // },
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
                                "__slot:actions:actionEditSeperat",
                                "__slot:actions:actionShowDetails",
                                "__slot:actions:actionRemove",
                                "__slot:actions:actionsEditInline"
                                ]'
                           :track-by="'name'"
                           :initial-data="{{ $actors }}"
                           :is-search-able="true"
                           :search-table-data-url="'../../search/actor'"
                           :sort="'yes'"
                           :options-url="'../list/film'"
                           :get-table-data-url="'../list/actor'"
                           :entry-url="'../actor/'"
                           :identifier-of-entry="'slug'"
                           :edit-success-action="'update'"
            ></table-control>

            <div id="container1">
            </div>


        </div>
    </section>
@endsection
