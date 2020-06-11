<template>
    <b-form-group
        :state="fieldState"
        v-bind:label="fieldLabel"
        v-bind:label-for="fieldId"
        :invalid-feedback="validationFailedMessage"
    >

        <b-form-select v-if="isMandatory && isMultiple"
            v-bind:id="fieldId"
            v-model="fieldInput"
            :options="fieldOptions"
            :state="fieldState"
            class="mb-3"
            :value-field="fieldOptionsId"
            :text-field="fieldOptionsDisplayName"
            disabled-field="notEnabled"
            multiple
            required
        ></b-form-select>
        <b-form-select
            v-else-if="isMandatory && !isMultiple"
            v-bind:id="fieldId"
            v-model="fieldInput"
            :options="fieldOptions"
            :state="fieldState"
            class="mb-3"
            :value-field="fieldOptionsId"
            :text-field="fieldOptionsDisplayName"
            disabled-field="notEnabled"
            required
        ></b-form-select>
        <b-form-select
            v-else-if="!isMandatory && isMultiple"
            v-bind:id="fieldId"
            v-model="fieldInput"
            :options="fieldOptions"
            :state="fieldState"
            class="mb-3"
            :value-field="fieldOptionsId"
            :text-field="fieldOptionsDisplayName"
            disabled-field="notEnabled"
            multiple
        ></b-form-select>
        <b-form-select v-else
            v-bind:id="fieldId"
            v-model="fieldInput"
            :options="fieldOptions"
            :state="fieldState"
            class="mb-3"
            :value-field="fieldOptionsId"
            :text-field="fieldOptionsDisplayName"
            disabled-field="notEnabled"
        ></b-form-select>
    </b-form-group>
</template>

<script>
    import { FormInputPlugin, FormGroupPlugin }  from "bootstrap-vue";
    import Vue from "vue";

    Vue.use(FormInputPlugin);
    Vue.use(FormGroupPlugin);

    export default {
        name: "DialogFormSelect",
        props : {
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
            isMultiple: {
                type: Boolean,
                required: false,
                default: false
            },
            validationFailedMessage: {
                type: String,
                required: false,
                default: "Choose an option"
            },
            fieldData: {
                type: [ Array, String ],
                required: false,
                default: []
            },
            // fieldData: {
            //     type: String,
            //     required: false,
            //     default: ""
            // },
            // provides a list of options, such as
            // [ { item: 'A', name: 'Option A' },
            // { item: 'B', name: 'Option B' },
            // { item: 'D', name: 'Option C', notEnabled: true },
            // { item: { d: 1 }, name: 'Option D' } ]
            fieldOptions: {
                type: Array,
                required: true
            },
            // the id field of the options provided. e.g. item in the above example
            fieldOptionsId: {
                required: true
            },
            // the displayed field of the options provided. e.g. name in the above example
            fieldOptionsDisplayName: {
                required: true
            }
        },
        data() {
            return {
                fieldInput: this.fieldData

            }
        },
        computed: {
            fieldState(){
                // console.log( "dialog selected: computed field " + JSON.stringify (this.fieldInput) );
                if (this.isMultiple === true && Array.isArray(this.fieldInput) ){
                    if ( this.fieldInput.length === 0 ) {
                        return false;
                    } else {
                        return true;
                    }
                //(this.isMultiple === false ){
                } else {
                    return typeof this.fieldOptions[this.fieldInput] !== 'undefined' ? true : false
                }
            },
        },
        watch: {
            fieldData: {
                handler: function(newData, oldData){
                    // console.log("dialog selected: select fieldChanged " + JSON.stringify (newData) )
                    this.fieldInput = newData;
                },
                deep: true
            }
        },

    }
</script>

<style scoped>

</style>
