<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="edit ? form.title : 'New actor'"/>
                </header>
                <div class="card-content">
                    <div class="content">
                        <form @submit.prevent="submit">

                            <div class="field">
                                <label class="label" for="name">Name</label>
                                <div class="control">
                                    <input id="name" v-model="form.name" class="input"></input>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('name')"
                                   v-text="form.errors.get('name')"/>
                            </div>

                            <div class="field">
                                <label class="label" for="film">Films</label>
                                <div class="control">
                                    <div class="select is-fullwidth" :class="loading ? 'is-loading' : ''">
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
                                    <textarea id="description" v-model="form.description" class="textarea"></textarea>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('description')"
                                   v-text="form.errors.get('description')"/>
                                <p class="help">
                                    You can use <a target="_blank"
                                                   href="https://daringfireball.net/projects/markdown/syntax">
                                    Markdown</a> syntax here.
                                </p>
                            </div>

                            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth"
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
        'actor_id': '',
        'name': '',
        'description': '',
        'film_id': ''
    });
    export default {
        name: "EditActorComponent",
        props:{
            currentActor: {
                    type: Object
            }
        },
        data(){
            return {
                form: form,
                url: '',
                films: [],
                noFilms: false
            }
        },
        created(){
                this.form.actor_id = this.currentActor.id;
                this.form.name = this.currentActor.name;
                this.form.description = this.currentActor.description;
                this.form.film_id = this.currentActor.film_id;

                axios.get('/list/film')
                .then(response => {
                    this.films = response.data;

                    if (this.loading)
                        this.noFilms = true;
                });

        }

    }
</script>

<style scoped>

</style>
