<template>
    <div class="table-container is-fullwidth">
        <table class="table is-fullwidth is-hoverable">
            <thead>
            <tr class="title is-6">
                <table-element element-type="th" text-class="has-text-centered">Name</table-element>
                <table-element element-type="th" text-class="has-text-centered">Description</table-element>
                <table-element element-type="th" text-class="has-text-centered">Edit</table-element>
            </tr>
            </thead>
            <tbody>
            <tr v-for="film in films" :key="film.id">
                <table-element element-type="td" text-class="has-text-centered">
                    <a :href="'/film/' + film.slug"
                       :title="film.name" v-text="film.name"/>
                </table-element>
                <table-element element-type="td" text-class="has-text-left">{{ film.description }}</table-element>
                <table-element element-type="td" text-class="has-text-centered">
                    <p class="buttons">
                        <a :href="'/film/' + film.slug + '/edit'" class="button is-info is-outlined is-small">
                            <span class="icon">
                              <i class="fa fa-edit"></i>
                            </span>
                        </a>
                        <button @click="openDeleteModal(film)" class="button is-danger is-outlined is-small">
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
        name: "FilmListComponent",
        props: {
            films: {
                required: true
            }
        },
        components: {
            TableElement
        },
        methods: {
            openDeleteModal(film) {
                this.$emit('open-modal',
                    {
                        id: film.id,
                        title: film.name,
                        content: 'Do you really want to delete this film?',
                        url: '/film/' + film.slug
                    });
            }
        }
    }
</script>

<style scoped>

</style>
