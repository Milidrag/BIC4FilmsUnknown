<template>
    <div class="table-container is-fullwidth">
        <table class="table is-fullwidth is-hoverable">
            <thead>
            <tr class="title is-6">
                <table-element element-type="th">Name</table-element>
                <table-element element-type="th">Description</table-element>
                <table-element element-type="th" text-class="has-text-centered has-extra-spacing">Actors</table-element>
                <table-element element-type="th">Created</table-element>
                <table-element element-type="th">Modified</table-element>
                <table-element element-type="th"></table-element>
            </tr>
            </thead>
            <tbody>
            <tr v-for="film in films" :key="film.id">
                <table-element element-type="td">
                    <a :href="'/film/' + film.slug"
                       :title="film.name">
                        <i class="fa fa-film"></i>&nbsp;{{ film.name }}
                    </a>
                </table-element>
                <table-element element-type="td">{{ film.description }}</table-element>
                <table-element element-type="td" text-class="has-text-centered">{{ film.actors.length }}</table-element>
                <table-element element-type="td">{{ film.created_at | moment('DD.MM.YYYY') }}</table-element>
                <table-element element-type="td">{{ film.updated_at | moment('DD.MM.YYYY') }}</table-element>
                <table-element element-type="td">
                    <p class="buttons">
                        <a :href="'/film/' + film.slug + '/edit'" class="button is-info is-outlined is-small">
                            <span class="icon">
                              <i class="fa fa-edit"></i>
                            </span>
                        </a>
                        <button v-if="!film.actors.length" @click="openDeleteModal(film)" class="button is-danger is-outlined is-small">
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
