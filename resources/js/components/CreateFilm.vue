<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="edit ? form.title : 'NEW FILM'"/>
                </header>
                <div class="card-content">
                    <div class="content">
                        <query-message :success="form.isSuccess()" :fail="form.isFail()"
                                       :message="form.failMessage || form.successMessage"></query-message>
                        <form @submit.prevent="submit">


                            <div class="field">
                                <div class="control">
                                    <input id="name" v-model="form.name" class="input is-primary is-rounded" placeholder="Name"></input>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('name')"
                                   v-text="form.errors.get('name')"/>
                            </div>

                            <div class="field">
                                <label class="label" for="description">Description</label>
                                <div class="control">
                                    <textarea id="description" v-model="form.description" class="textarea is-primary is-rounded"></textarea>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('description')"
                                   v-text="form.errors.get('description')"/>
                                <p class="help">
                                    You can use <a target="_blank"
                                                   href="https://daringfireball.net/projects/markdown/syntax">
                                    Markdown</a> syntax here.
                                </p>
                            </div>

                            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth is-rounded"
                                    v-text="edit ? 'Save' : 'Post'"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let form = new Form({
        'id': '',
        'name': '',
        'description': '',
    });

    export default {
        name: "Create",
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
        },   data() {
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
                        .put(this.url);
                else
                    this.form
                        .post(this.url)
                        .then((response) => {
                            this.url = '/film/' + response.slug;

                            this.form.film_id = response.film_id;
                            this.form.name = response.name;
                            this.form.description = response.description;



                            this.edit = true;

                            window.history.pushState("", "", this.url);
                        });
            }
        },
        created() {


            this.edit = this.isEditable;

            if (this.edit) {
                this.url = '/film/' + this.currentFilm.slug;
                this.form.film_id = this.currentFilm.id;
                this.form.name = this.currentFilm.name;
                this.form.description = this.currentFilm.description;
                this.form.title = 'edit film'

            } else {
                this.url = '/film';
            }
        }
    }
</script>

<style scoped>

</style>
