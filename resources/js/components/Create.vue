<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="edit ? form.title : 'New actor'"/>
                </header>
                <div class="card-content">
                    <div class="content">
                        <query-message :success="form.isSuccess()" :fail="form.isFail()"
                                       :message="form.failMessage || form.successMessage"></query-message>
                        <form @submit.prevent="submit">
                            <div class="field" v-if="!edit">
                                <label class="label" for="title">Name</label>
                                <div class="control">
                                    <input id="title"
                                           v-model="form.title"
                                           class="input"
                                           v-bind:class="{ 'is-danger': form.errors.has('title')}"
                                           type="text" autofocus>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('title')"
                                   v-text="form.errors.get('title')"/>
                            </div>

                            <div class="field">
                                <label class="label" for="body">Description</label>
                                <div class="control">
                                    <textarea id="body" v-model="form.body" class="textarea"></textarea>
                                </div>
                                <p class="help is-danger" v-if="form.errors.has('body')"
                                   v-text="form.errors.get('body')"/>
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
        'title': '',
        'body': '',
    });

    export default {
        name: "Create",
        components: {
            QueryMessage
        },
        props: {
            isEditable: {
                required: false,
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                edit: undefined,
                form: form,
                url: '',
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

                            this.form.blog_id = response.actor_id;
                            this.form.title = response.title;
                            this.form.body = response.body;

                            this.form.noReset = ['actor_id', 'title', 'body'];

                            this.edit = true;

                            window.history.pushState("", "", this.url);
                        });
            }
        }




    }
</script>

<style scoped>

</style>
