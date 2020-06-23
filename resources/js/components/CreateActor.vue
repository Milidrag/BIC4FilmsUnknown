<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="edit ? form.title : 'NEW ACTOR'"/>
                </header>
                <div class="card-content background">
                    <div class="content">
                        <query-message :success="form.isSuccess()" :fail="form.isFail()"
                                       :message="form.failMessage || form.successMessage"></query-message>
                        <form @submit.prevent="submit">


                            <div class="field transbox">
                                <div class="control">
                                    <input id="name" v-model="form.name" class="input is-primary is-rounded" placeholder="Name"></input>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('name')"
                                   v-text="form.errors.get('name')"/>
                            </div>

                            <div class="field">
                                <label class="label" for="film">Films</label>
                                <div class="control">
                                    <div class="select is-fullwidth is-rounded is-primary" :class="loading ? 'is-loading' : ''">
                                        <select id="film" :disabled="loading" v-model="form.film_id">
                                            <option v-if="loading" :value="this.form.film_id"> Loading...</option>
                                            <option v-for="cat in films" v-if="!loading" v-text="cat.name"
                                                    :value="cat.id"/>
                                        </select>
                                    </div>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('film_id')"
                                   v-text="form.errors.get('film_id')"/>
                                <p v-if="noFilms" class="help is-warning">Add some movies to create an actor!</p>
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
                                    v-text="edit ? 'Save' : 'Post'" :disabled="loading"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let form = new Form({
        'title' : '',
        'id': '',
        'name': '',
        'description': '',
        'film_id': '',
        'noReset': ['film_id']
    });

    export default {
        name: "Create",
        props: {
            isEditable: {
                required: false,
                type: Boolean,
                default: false
            },
            currentActor: {
                required: false,
                type: Object
            }
        },
        data() {
            return {
                edit: undefined,
                form: form,
                url: '',
                films: [],
                noFilms: false
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
                            this.url = '/actor/' + response.slug;

                            this.form.actor_id = response.actor_id;
                            this.form.name = response.name;
                            this.form.description = response.description;
                            this.form.film_id = response.film_id;

                            this.form.noReset = ['actor_id', 'name', 'description', 'film_id'];

                            this.edit = true;

                            window.history.pushState("", "", this.url);
                        });
            }
        },
        created() {
            axios.get('/list/film')
                .then(response => {
                    this.films = response.data;

                    if (this.loading)
                        this.noFilms = true;
                });

            this.edit = this.isEditable;

            if (this.edit) {
                this.url = '/actor/' + this.currentActor.slug;
                this.form.actor_id = this.currentActor.id;
                this.form.name = this.currentActor.name;
                this.form.description = this.currentActor.description;
                this.form.film_id = this.currentActor.film_id;
                this.form.title = 'edit actor'

                this.form.noReset = ['actors_id', 'name', 'description', 'film_id'];
            } else {
                this.url = '/actor';
            }
        },

        computed: {
            loading() {
                return !this.films.length
            }
        },

        watch: {
            films() {
                if (!this.loading && this.form.film_id === '') {
                    this.form.film_id = _.first(this.films).id;
                }
            }
        }
    }
</script>

<style scoped>

</style>
