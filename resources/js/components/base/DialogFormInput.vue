<template>
    <b-form-group
        :state="fieldState"
        v-bind:label="fieldLabel"
        v-bind:label-for="fieldId"
        :invalid-feedback="validationFailedMessage"
    >

        <b-form-input v-if="isMandatory"
                      v-bind:id="fieldId"
                      v-model="fieldInput"
                      :state="fieldState"
                      required
        ></b-form-input>
        <b-form-input v-else
                      v-bind:id="fieldId"
                      v-model="fieldInput"
                      :state="fieldState"
        ></b-form-input>
    </b-form-group>
</template>

<script>
    import {FormInputPlugin, FormGroupPlugin} from "bootstrap-vue";
    import Vue from "vue";

    Vue.use(FormInputPlugin);
    Vue.use(FormGroupPlugin);

    export default {
        name: "DialogFormInput",
        props: {
            fieldLabel: {
                type: String,
                required: true,
                default: "MyName"
            },
            fieldId: {
                type: String,
                required: false,
                default: "myname-input"
            },
            isMandatory: {
                type: Boolean,
                required: false,
                default: false
            },
            validationFailedMessage: {
                type: String,
                required: false,
                default: "This field must be not empty"
            },
            fieldData: {
                type: String,
                required: false,
                default: ""
            }
        },
        data() {
            return {
                fieldInput: this.fieldData
            }
        },
        computed: {
            fieldState() {
                return this.fieldInput.length > 0 ? true : false
            },
        },
        watch: {
            fieldData: {
                handler: function (newData, oldData) {
                    // console.log("fieldChanged " + newData)
                    this.fieldInput = newData;
                },
                deep: true
            }
        },

    }
</script>

<style scoped>

</style>
