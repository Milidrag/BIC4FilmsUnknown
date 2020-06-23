<template>
    <div class="table-container is-fullwidth">
        <table class="table is-fullwidth is-hoverable">
            <thead>
            <tr class="title is-6">
                <table-element element-type="th" text-class="has-text-centered">Name</table-element>
                <table-element element-type="th" text-class="has-text-centered">Description</table-element>
                <table-element element-type="th" text-class="has-text-centered">Films</table-element>
                <table-element element-type="th"></table-element>
            </tr>
            </thead>
            <tbody>
            <tr v-for="actor in actors" :key="actor.id">
                <table-element element-type="td">
                    <a :href="'/actor/' + actor.slug"
                       :title="actor.name" v-text="actor.name"/>
                </table-element>
                <table-element element-type="td" text-class="has-text-left">{{ actor.description }}</table-element>
                <table-element element-type="td" text-class="has-text-centered">{{ actor.film.name }}</table-element>
                <table-element element-type="td">
                    <p class="buttons">
                        <a :href="'/actor/' + actor.slug + '/edit'" class="button is-info is-outlined is-small">
                            <span class="icon">
                              <i class="fa fa-edit"></i>
                            </span>
                        </a>
                        <button v-if="!actor.film.length" @click="openDeleteModal(actor)" class="button is-danger is-outlined is-small">
                            <span class="icon">
                              <i class="fa fa-remove"></i>
                            </span>
                        </button>
                    </p>
                </table-element>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "ActorListComponent",
        props: {
            actors: {
                required: true
            }
        },
        components: {
            TableElement
        },
        methods: {
            openDeleteModal(actor) {
                this.$emit('open-modal',
                    {
                        id: actor.id,
                        title: actor.name,
                        content: 'Do you really want to delete this actor?',
                        url: '/actor/' + actor.slug
                    });
            }
        }
    }
</script>

<style scoped>

</style>
