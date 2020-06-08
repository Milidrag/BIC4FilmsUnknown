<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="edit ? form.name : 'New film'"/>
                </header>
                <div class="card-content">
                    <div class="content">
                        <query-message :success="form.isSuccess()" :fail="form.isFail()"
                                       :message="form.failMessage || form.successMessage"></query-message>
                        <form @submit.prevent="submit">
                            <div class="field" v-if="!edit">
                                <label class="label" for="name">Name</label>
                                <div class="control">
                                    <input id="name"
                                           v-model="form.name"
                                           class="input"
                                           v-bind:class="{ 'is-danger': form.errors.has('name')}"
                                           type="text" autofocus>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('name')"
                                   v-text="form.errors.get('name')"/>
                            </div>

                            <div class="field">
                                <label class="label" for="description">Description</label>
                                <div class="control">
                                    <textarea id="description" v-model="form.description" class="textarea"></textarea>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('description')"
                                   v-text="form.errors.get('description')"/>
                            </div>

                            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth"
                                    v-text="edit ? 'Update' : 'Save'" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let form = new Form({
        'film_id': '',
        'name': '',
        'description': ''
    });

    export default {
        name: "FilmFormComponent",
        components: {
            QueryMessage
        },
        props: {
            isEditable: {
                required: false,
                type: Boolean,
                default: false
            },
            currentFilm: {
                required: false,
                type: Object
            }
        },
        data() {
            return {
                edit: undefined,
                form: form,
                url: ''
            }
        },
        methods: {
            submit() {
                if (this.edit)
                    this.form
                        .put(this.url)
                        .then((response) => {
                            this.form.successMessage = 'Updated successfully'
                        }).catch((response) => {
                            this.form.failMessage = 'Could not update'
                        });
                else
                    this.form
                        .post(this.url)
                        .then(response => {
                            this.url = '/film/' + response.slug;

                            this.form.film_id = response.film_id;
                            this.form.name = response.name;
                            this.form.description = response.description;
                            this.form.successMessage = 'Film created successfully'
                            this.form.noReset = ['film_id', 'name', 'description'];

                            this.edit = true;

                            window.history.pushState("", "", this.url);
                        }).catch((response) => {
                            this.form.failMessage = 'Could not create film'
                        });
            }
        },
        created() {
            this.edit = this.isEditable;

            if (this.edit) {
                this.url = '/film/' + this.currentFilm.slug;

                this.form.film_id = this.currentFilm.film_id;
                this.form.name = this.currentFilm.name;
                this.form.description = this.currentFilm.description;

                this.form.noReset = ['film_id', 'name', 'description'];
            } else {
                this.url = '/film';
            }
        }
    }
</script>

<style scoped>

</style>
