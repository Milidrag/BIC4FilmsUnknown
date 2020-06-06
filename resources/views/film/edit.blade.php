@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="container">


            <dialog-control
                :dialog-id="'edit-form-dialog'"
                :dialog-title="'Edit Film'"
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
                    fieldData: "{{ $film['slug'] }}"
                    },
                    {
                    fieldName: "name",
                    fieldLabel: "Name",
                    fieldIsDisplayed: true,
                    isMandatory: true,
                    validationFailedMessage: "A super Name is required",
                    fieldType: "b-form-input",
                    // data field must be specified otherwise v-bind does not work
                    fieldData: "{{ $film['name'] }}"
                    },
                    {
                    fieldName: "description",
                    fieldLabel: "Description",
                    fieldIsDisplayed: true,
                    isMandatory: true,
                    validationFailedMessage: "A Description is required",
                    fieldType: "b-form-input",
                    fieldData: "{{ $film['description'] }}"
                    }
                    ]
                    '
                :options-url="'../../list/actor'"
                :create-url="'.'"
                :edit-url="'.'"
                :dialog-mode="'edit'"
                {{--                :dialogCallback=''--}}
            >
            </dialog-control>

        </div>
    </section>
@endsection
