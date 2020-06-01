<template>
    <div>
    <dialog-modal
        :dialog-id="'create-form-dialog'"
        :dialog-title="dialogTitle"
        :form-definition="formDefinition"
        v-bind:dialog-options="selectableOptions"
        :dialogCallback="dialogCallback"

    >
    </dialog-modal>
    <br>
    <div class="userInfo" id="userInfo">
    </div>
    <br>
    <b-button id="create-btn" variant="primary" @click="$bvModal.show('create-form-dialog')">{{ this.dialogTitle }}</b-button>
    </div>
</template>

<script>
    import { FormInputPlugin, FormGroupPlugin }  from "bootstrap-vue";
    import Vue from "vue";

    Vue.use(FormInputPlugin);
    Vue.use(FormGroupPlugin);

    export default {
        name: "DialogCreate",
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
            // where to get the available options for the select
            optionsUrl: {
                type: String,
                required: false,
                default: function(){
                    return null;
                }
            },
            // where to submit form data
            createUrl: {
                type: String,
                required: true
            },
        },
        data: function(){
            return {
                selectableOptions: []
            }
        },
        methods: {
            dialogCallback( formulaData ) {
                console.log("running " + formulaData);
                axios.post(this.createUrl , formulaData )
                    .then( (response) => {
                        this.dialogOkCallback()
                    }).catch(  (error) => {
                        this.dialogFailedCallback();
                });
            },
            dialogOkCallback() {
                this.updateUserInfo("info", "record has been created");
            },
            dialogFailedCallback() {
                this.updateUserInfo("warning", "cannot create record");

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
            console.log(this.optionsUrl);
            if ( this.optionsUrl !== null ){
                this.getOptions(this.optionsUrl);
            }

        },
        mounted(){
            this.$bvModal.show( "create-form-dialog" );
        }
    }
</script>

<style scoped>

</style>
