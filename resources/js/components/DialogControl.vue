<template>
    <div id="dialog-control">
        <dialog-modal
            :dialog-id="this.dialogMode + '-form-dialog'"
            :dialog-title="dialogTitle"
            :form-definition="formDefinition"
            v-bind:form-data="formData"
            v-bind:dialog-options="selectableOptions"
            :dialogCallback="dialogCallback"

        >
        </dialog-modal>
        <div class="userInfo" id="userInfo">
        </div>
        <br>

        <b-button :id="this.dialogMode + '-btn'" variant="primary" @click="buttonClick()">{{ this.dialogTitle }}
        </b-button>
    </div>
</template>

<script>
    import { FormInputPlugin, FormGroupPlugin }  from "bootstrap-vue";
    import Vue from "vue";

    Vue.use(FormInputPlugin);
    Vue.use(FormGroupPlugin);


    export default {
        name: "DialogControl",
        props : {
            dialogTitle: {
                type: String,
                required: false,
                default: "MyDialog"
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
            },
            // where to get the available options for the select
            optionsUrl: {
                type: String,
                required: false,
                default: function(){
                    return null;
                }
            },
            // [edit, create] whether it is a create or edit dialog
            dialogMode:{
                type: String,
                required: true,
                default: "create"
            },
            // where to submit form data
            createUrl: {
                type: String,
                required: false
            },
            // where to submit form data
            editUrl: {
                type: String,
                required: false
            },
            ichMussVerwendetWerden: {
                type: Boolean,
                required: false,
                default: false
            },
        },
        data: function(){
            return {
                selectableOptions: [],
                workingFormData: this.formData
            }
        },
        methods: {
            buttonClick: function(){
                /*
                window.location.href = "http://localhost:8000/public/actor/"+slug+"/edit";
                                 */
                this.$bvModal.show( this.dialogMode + "-form-dialog" );

            },
            dialogCallback( formulaData ) {
                // console.log("running " + JSON.stringify(formulaData) );
                if ( (this.dialogMode === 'create') && (typeof this.createUrl !== 'undefined') ) {
                    if (this.ichMussVerwendetWerden == true){
                        // console.log('verwendung von form.js')
                        let form = new Form({
                            'film_id': '',
                            'name': '',
                            'description': ''
                        });
                        form.name = formulaData['name'];
                        form.description = formulaData['description'];
                        form.film_id = formulaData['film_id'];
                        form.post(this.createUrl)
                            .then((response) => {
                                this.dialogOkCallback();
                            }).catch(  (error) => {
                            this.dialogFailedCallback();
                        });
                    } else {
                        axios.post(this.createUrl , formulaData )
                            .then( (response) => {
                                this.dialogOkCallback()
                            }).catch(  (error) => {
                            this.dialogFailedCallback();
                        });
                    }


                } else if ( (this.dialogMode === 'edit') && (typeof this.editUrl !== 'undefined') ) {
                    axios.put(this.editUrl , formulaData )
                        .then( (response) => {
                            this.dialogOkCallback();
                        }).catch(  (error) => {
                        this.dialogFailedCallback();
                    });
                } else {
                    this.updateUserInfo("warning", " mode is invalid");
                }

            },
            dialogOkCallback() {
                this.updateUserInfo("info", this.dialogMode + " success");
            },
            dialogFailedCallback() {
                this.updateUserInfo("warning", this.dialogMode + " failed");

            },
            getOptions: function(optionsUrl){
                axios.get(optionsUrl).then(res => (
                    // console.log(res)
                    this.selectableOptions = res.data
                ) );
            },
            updateUserInfo: function (level, info){
                var element = document.getElementById("userInfo");
                element.innerHTML = info;
                if (level === "success" ){
                    element.classList.add("alert");
                    element.classList.add("alert-success");
                } else if (level === "info" ){
                    element.classList.add("alert");
                    element.classList.add("alert-info");
                } else if ( level === "warning" ){
                    element.classList.add("alert");
                    element.classList.add("alert-warning");
                } else {
                    element.classList.add("alert");
                    element.classList.add("alert-danger");
                }
                element.classList.add("hidden");
                setTimeout(function(){
                    // element.classList.remove("hidden");
                    element.className = 'userInfo';
                    element.innerHTML = '';
                }, 10000);
            }
        },

        created(){
            if ( this.optionsUrl !== null ){
                this.getOptions(this.optionsUrl);
            }

        },
        mounted(){
            this.$bvModal.show( this.dialogMode + "-form-dialog" );
        }
    }
</script>

<style scoped>

    #dialog-control .hidden{
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s 10s, opacity 10s linear;
    }

</style>
