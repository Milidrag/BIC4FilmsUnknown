<template>
    <div>
        <b-button v-b-modal.modal-prevent-closing>Open Dialog</b-button>

        <div class="mt-3">
            Submitted Names:
            <div v-if="submittedNames.length === 0">--</div>
            <ul v-else class="mb-0 pl-3">
                <li v-for="name in submittedNames">{{ name }}</li>
            </ul>
        </div>
        <div class="mt-3">Selected: <strong>{{ selected }}</strong></div>
        <b-modal
            id="modal-prevent-closing"
            ref="modal"
            title="Submit Your Name"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    :state="nameState"
                    label="Name"
                    label-for="name-input"
                    invalid-feedback="Name is required"
                >
                    <b-form-input
                        id="name-input"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    :state="descriptionState"
                    label="Description"
                    label-for="description-input"
                    invalid-feedback="Description is required"
                >
                    <b-form-input
                        id="description-input"
                        v-model="description"
                        :state="descriptionState"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    :state="filmidState"
                    label="FilmId"
                    label-for="filmid-input"
                    invalid-feedback="Filmid is required"
                >
                    <b-form-input
                        id="filmid-input"
                        v-model="filmid"
                        :state="filmidState"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-select
                    v-model="selected"
                    :options="options"
                    class="mb-3"
                    value-field="item"
                    text-field="name"
                    disabled-field="notEnabled"
                ></b-form-select>

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

    // import "bootstrap/dist/css/bootstrap.min.css";
    // import "bootstrap-vue/dist/bootstrap-vue.css";
    import Vue from 'vue';

    export default {
        name: "DialogeModal",
        data() {
            // descriptionState: null,
            // nameState: null,
            // filmidState: null,
            return {
                name: '',
                description: '',
                filmid: '',
                submittedNames: [],
                selected: '-',
                options: [
                    { item: 'A', name: 'Option A' },
                    { item: 'B', name: 'Option B' },
                    { item: 'D', name: 'Option C', notEnabled: true },
                    { item: { d: 1 }, name: 'Option D' }
                ]
            }
        },
        computed: {
            nameState() {
                return this.name.length > 1 ? true : false
            },
            descriptionState() {
                return this.description.length > 1 ? true : false
            },
            filmidState() {
                return this.filmid.length > 1 ? true : false
            },
        },
        methods: {
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                // this.nameState = valid
                // this.descriptionState = valid
                // this.filmidState = valid
                return valid
            },
            resetModal() {
                this.name = ''
                // this.nameState = null
                this.description = ''
                // this.descriptionState = null
                this.filmid = ''
                // this.filmidState = null
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
                // Push the name to submitted names
                this.submittedNames.push(this.name)
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            }

        }
    }
</script>
