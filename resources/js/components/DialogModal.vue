<template>
    <div>
        <!--
        use this to start the modal dialog
        <b-button v-b-modal.modal-prevent-closing>Open Dialog</b-button>
        -->
        <b-modal
            v-bind:id="dialogId"
            ref="modal"
            :title="dialogTitle"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <div v-for="(field, i) in formDefinition">
                    <dialog-form-input
                        v-if="field.fieldIsDisplayed && field.fieldType ==='b-form-input'"
                        :key="field.fieldLabel + field.fieldData"
                        v-bind:field-label="field.fieldLabel"
                        v-bind:field-id="'form-input-' +field.fieldName"
                        v-bind:field-data="workingFormData[i].fieldData"
                        v-bind:is-mandatory="field.isMandatory"
                        v-bind:validation-failed-message="field.validationFailedMessage"
                    >
                    </dialog-form-input>
                    <dialog-form-select
                        v-if="field.fieldIsDisplayed && field.fieldType ==='b-form-select'"
                        :key="field.fieldLabel + field.fieldData"
                        v-bind:field-label="field.fieldLabel"
                        v-bind:field-id="'form-input-' +field.fieldName"
                        v-bind:field-data="workingFormData[i].fieldData"
                        v-bind:is-multiple="field.isMultiple"
                        v-bind:is-mandatory="field.isMandatory"
                        v-bind:validation-failed-message="field.validationFailedMessage"
                        v-bind:field-options-id="'id'"
                        v-bind:field-options-display-name="'name'"
                        v-bind:field-options="dialogOptions"
                    >
                    </dialog-form-select>
                </div>
            </form>
        </b-modal>
    </div>
</template>

<script>
    import { ModalPlugin, FormPlugin, FormInputPlugin, FormSelectPlugin, FormGroupPlugin, ButtonPlugin }  from "bootstrap-vue";
    Vue.use(ModalPlugin);
    Vue.use(FormPlugin);
    Vue.use(FormInputPlugin);
    Vue.use(FormGroupPlugin);
    Vue.use(ButtonPlugin);
    Vue.use(FormSelectPlugin)

    import Vue from 'vue';

    export default {
        name: "DialogModal",
        props : {
            // unique id in the event the dialog must be accessed
            dialogId: {
                type: String,
                required: false,
                default: "MyDialog"
            },
            dialogTitle: {
                type: String,
                required: false,
                default: "MyDialog"
            },
            // function is called when form was submitted ( e.g. parent)
            dialogCallback: {
                type: Function,
                required: false,
                default: function  (){

                }
            },
            // selectable list of options for select items
            dialogOptions: {
                type: Array,
                required: false,
                default: function  (){
                    return [];
                }
            },
            // the structure of the form
            formDefinition: {
                type: Array,
                required: false,
                default: function () {
                    // layout of a form definition that must be provided
                    return [
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
                            validationFailedMessage: "A Name is required",
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
                    ];
                }
            },
            // data of the form. is supposed to be json. fields must match "fieldName"
            // might be empty when the form is empty
            formData: {
                type: Object,
                required: false,
                default: function (){
                    return {};
                }
            }

        },
        data() {
            return {
                // using this bind both data sets together.
                // changing workingFormData will change also formDefinition, pointer?
                workingFormData: this.formDefinition

            }
        },
        computed: {

        },
        watch: {
            // runs when parent changes its data
            formData: {
                handler: function(newData, oldData){
                    console.log("newdata " + JSON.stringify(newData) );
                    var i;
                    // console.log( "pre " + JSON.stringify(this.workingFormData) );
                    // push data to structure
                    for (var i = 0; i < this.workingFormData.length; i++) {
                        //console.log("working on fieldname: "+ this.workingFormData[i].fieldName);
                        if ( typeof newData === 'undefined' || typeof newData[ this.workingFormData[i].fieldName ] === 'undefined' ){
                            // no change
                            //console.log("cannot set data, newData has no such array index");
                        } else {
                            this.workingFormData[i]['fieldData'] = newData[ this.workingFormData[i].fieldName ];
                        }
                    }
                },
                deep: true
            }
        },
        methods: {
            // unfortuanally variable binding is broken because in DialogFormInput we have to split prop / and data
            collectFormData() {
                var submitData = {};
                for (var i = 0; i < this.workingFormData.length; i++) {
                    var index = this.workingFormData[i].fieldName;
                    var data;
                    var dataElement = document.getElementById( "form-input-" + index);
                    // console.log(dataElement);
                    if ( dataElement !== "undefined" && dataElement !== null ){
                        if (this.workingFormData[i].isMultiple === true ){
                            data = this.getMultiSelectOptions(dataElement);
                        } else {
                            data = dataElement.value;
                        }
                    } else {
                        data = this.workingFormData[i].fieldData;
                    }
                    // console.log("index is: "+ index + " data is: " + data);
                    submitData[index] = data;
                }
                return submitData;
            },
            getMultiSelectOptions( documentElement ) {
                var selected1 = [];
                for (var i = 0; i < documentElement.length; i++) {
                    if (documentElement.options[i].selected) selected1.push(documentElement.options[i].value);
                }
                console.log(selected1);
                return selected1;
            },
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                return valid
            },
            resetModal() {
                // this.formData = null;
                // this.dialogData = null;
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()

                // Trigger submit handler
                this.handleSubmit()
            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide( this.dialogId )
                })
                this.dialogCallback( this.collectFormData() );
            }
        }

    }
</script>
