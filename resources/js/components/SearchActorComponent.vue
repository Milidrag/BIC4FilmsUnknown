<template>
    <div class="container">
        Which actor you want to see?

        <form @submit.prevent="submit">


            <div class="field">
                <label class="label" for="name">Name of the actor or part of the specific description</label>
                <div class="control">
                    <input id="name" v-model="name" class="input"></input>
                </div>

            </div>


            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth"/>
        </form>

        <table class="table is-fullwidth is-hoverable">
            <thead>
            <tr class="title is-4">
                <table-element element-type="th">Name</table-element>
                <table-element element-type="th">Description</table-element>
                <table-element element-type="th">Created</table-element>
                <table-element element-type="th">Modified</table-element>
            </tr>
            </thead>
            <tbody>
            <tr v-for="actor in actors" :key="actor.id">
                <table-element element-type="td">
                    <a :href="'/actor/' + actor.slug + '/edit'"
                       :title="actor.name" v-text="actor.name"/>
                </table-element>
                <table-element element-type="td">{{ actor.description }}</table-element>
                <table-element element-type="td">{{ actor.created_at | moment('DD.MM.YYYY') }}</table-element>
                <table-element element-type="td">{{ actor.updated_at | moment('DD.MM.YYYY') }}</table-element>
            </tr>
            </tbody>
        </table>
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
