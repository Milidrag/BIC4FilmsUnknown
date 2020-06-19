<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="'Search for actors'"/>
                </header>
                <div class="card-content">
                    <div class="content">
                        <query-message :success="form.isSuccess()" :fail="form.isFail()"
                                       :message="form.failMessage || form.successMessage"></query-message>
                        <form @submit.prevent="submit">
                            <div class="field">
                                <label class="label" for="pattern">Searchpattern</label>
                                <div class="control">
                                    <input id="pattern"
                                           v-model="form.q"
                                           class="input"
                                           v-bind:class="{ 'is-danger': form.errors.has('q')}"
                                           type="text" autofocus>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('q')"
                                   v-text="form.errors.get('q')"/>
                            </div>

                            <button v-if="isLoading" class="button is-loading is-large is-primary is-outlined is-fullwidth" v-text="'Loading'"></button>
                            <button v-else type="submit" class="button is-large is-primary is-outlined is-fullwidth"
                                    v-text="'Search'" />

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
<!--            <hero v-if="searchedFor==''" :main-title="'nothing to show at the moment'"></hero>-->
            <actors :current-title="''" :all-actors="actors" v-if="actors.length > 0" ></actors>
        </div>
    </div>
</template>

<script>
    let form = new Form({
        'q': '',
    });

    export default {
        name: "SearchFormComponent",
        components: {
            QueryMessage
        },
        props: {

        },
        data() {
            return {
                form: form,
                url: '/search/actor',
                actors: [],
                hasSearched: false,
                searchedFor: '',
                isLoading: false
            }
        },
        methods: {
            submit() {
                this.isLoading = true;
                this.searchedFor = this.form.q;
                this.actors = [];

                this.form
                    .post(this.url)
                    .then(response => {
                        this.actors = response;
                        this.form.successMessage = 'The query returned ' + this.actors.length + ' results';
                        this.form.q = this.searchedFor;
                        this.form.noReset = ['q'];
                        this.isLoading = false;
                    }).catch((response) => {
                        this.form.q = this.searchedFor;
                        this.searchedFor = '';
                        this.isLoading = false;
                    });

            }
        },
        created() {

        }
    }
</script>

<style scoped>

</style>
