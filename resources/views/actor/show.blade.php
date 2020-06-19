@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h1>Show actor</h1>

            <table-control :table-title="'Film list of actor: {{ $actor['name'] }}'"
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
                                        fieldName: "actors",
                                        fieldLabel: "Actors that play in the film",
                                        fieldIsDisplayed: true,
                                        isMandatory: true,
                                        isMultiple: true,
                                        validationFailedMessage: "A Film description is required",
                                        fieldType: "b-form-select",
                                        fieldData: []
                                    }
                                ]
                                '
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
                                // customElement: "DescriptionNew"
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
                                "__slot:actions:actionEditSeperat",
                                "__slot:actions:actionShowDetails",
                                "__slot:actions:actionRemove",
                                "__slot:actions:actionsEditInline"
                                ]'
                           :track-by="'slug'"
                           :initial-data="{{ $film }}"
                           :is-search-able="false"
                           :search-table-data-url="'../../search/actor'"
                           :sort="'yes'"
                           :options-url="'../list/actor'"
                           :get-table-data-url="'../list/film'"
                           :entry-url="'../film/'"
                           :identifier-of-entry="'slug'"
                           :edit-success-action="'reload'"
            ></table-control>

            {{--{{ $film }}--}}


        </div>
    </section>
@endsection
