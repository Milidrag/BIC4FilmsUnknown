@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h3 class="title">Create a new actor</h3>
            <dialog-control
                :dialog-id="'create-form-dialog'"
                :dialog-title="'Create Actor'"
                :form-definition='
                    [
                        {
                            fieldName: "slug",
                            fieldLabel: "Slug",
                            fieldIsDisplayed: false,
                            isMandatory: false,
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
                            fieldLabel: "Film participation",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A FilmId is required",
                            fieldType: "b-form-select",
                            fieldData: ""
                        }
                    ]
                    '
                    :options-url="'../../list/film'"
                    :create-url="'.'"
                    :edit-url="'.'"
                    v-bind:dialog-mode="'create'"
                    :ich-muss-verwendet-werden="true"
{{--                v-bind:form-data=formData--}}
{{--                :dialogCallback=''--}}
            >
            </dialog-control>

        </div>
    </section>

@endsection
