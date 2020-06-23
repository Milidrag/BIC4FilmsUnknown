<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="card blog-card column is-half is-offset-one-quarter">
                <header class="card-header">
                    <h1 class="card-header-title is-centered" v-text="'SEARCH ACTOR'"/>
                </header>
                <div class="card-content ">
                    <div class="content">

                        <form @submit.prevent="submit">

                            <div class="field">
                                <div class="control">
                                    <input id="name" v-model="name" class="input" placeholder="Name of the actor or part of the specific description"></input>
                                </div>
                            </div>


                            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth is-rounded"
                                    v-text="'Search'"/>
                        </form>
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                            <tr >
                                <table-element element-type="th" text-class=" has-text-centered">Name</table-element>
                                <table-element element-type="th" text-class=" has-text-centered" >Description</table-element>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="actor in actors" :key="actor.id" text-class=" has-text-centered">
                                <table-element element-type="td"  text-class=" has-text-centered">
                                    <a :href="'/actor/' + actor.slug + '/edit'"
                                       :title="actor.name" v-text="actor.name"/>
                                </table-element>
                                <table-element element-type="td"  text-class=" has-text-left">{{ actor.description }}</table-element>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "ShowActorComponent",
        data(){
            return {
                name: '',
                slug:'',
                actors: []

            }
        },
        components: {
            TableElement
        },
        methods: {
            submit() {
                axios.post('actor/', {
                    name: this.name
                })
                    .then(response => {
                        console.log(response)
                        this.actors = response.data;
                    })
                    .catch(error => console.log(error));

                    }

        }

    }
</script>

<style scoped>

</style>
