@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">
            <h3 class="title">Create a new Film</h3>
            <dialog-control
                :dialog-id="'create-form-dialog'"
                :dialog-title="'Create Film'"
                :form-definition='
                    [
                        {
                            fieldName: "name",
                            fieldLabel: "Filmname",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A filmname is required",
                            fieldType: "b-form-input",
                            // data field must be specified otherwise v-bind does not work
                            fieldData: ""
                        },
                        {
                            fieldName: "description",
                            fieldLabel: "Description",
                            fieldIsDisplayed: true,
                            isMandatory: true,
                            validationFailedMessage: "A Film description is required",
                            fieldType: "b-form-input",
                            fieldData: ""
                        },
                        {
                            fieldName: "actors",
                            fieldLabel: "Actors that may play in the film",
                            fieldIsDisplayed: true,
                            isMandatory: false,
                            isMultiple: true,
                            validationFailedMessage: "A Film description is required",
                            fieldType: "b-form-select",
                            fieldData: []
                        }
                    ]
                    '
                :options-url="'../list/actor'"
                :create-url="'.'"
                :edit-url="'.'"
                v-bind:dialog-mode="'create'"
                {{--                v-bind:form-data=formData--}}
                {{--                :dialogCallback=''--}}
            >
            </dialog-control>
        </div>
    </section>
@endsection
