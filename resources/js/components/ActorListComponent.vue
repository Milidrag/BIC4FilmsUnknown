<template>
    <div class="table-container is-fullwidth">
        <table class="table is-fullwidth is-hoverable">
            <thead>
            <tr class="title is-6">
                <table-element element-type="th">Name</table-element>
<!--                <table-element element-type="th">User</table-element>-->
                <table-element element-type="th" v-if="showFilm">Film</table-element>
<!--                <table-element element-type="th" text-class="has-text-centered">Replies</table-element>-->
                <table-element element-type="th">Created</table-element>
                <table-element element-type="th">Modified</table-element>
                <table-element element-type="th"></table-element>
            </tr>
            </thead>
            <tbody>
            <tr v-for="actor in actors" :key="actor.id">
                <table-element element-type="td">
                    <a :href="'/actor/' + actor.slug"
                       :title="actor.name">
                        <i class="fa fa-user"></i>&nbsp;{{ actor.name }}
                    </a>
                </table-element>
                <table-element element-type="td" v-if="showFilm">
                    <a :href="'/film/' + actor.film.slug"
                       :title="actor.film.name">
                        <i class="fa fa-film"></i>&nbsp;{{ actor.film.name }}
                    </a>
                </table-element>
<!--                <table-element element-type="td" text-class="has-text-centered">{{ actor['film'].length }}-->
<!--                </table-element>-->
                <table-element element-type="td">{{ actor.created_at | moment('DD.MM.YYYY') }}</table-element>
                <table-element element-type="td">{{ actor.updated_at | moment('DD.MM.YYYY') }}</table-element>
                <table-element element-type="td">
                    <p class="buttons" v-if="actor.id === actor.id">
                        <a :href="'/actor/' + actor.slug + '/edit'" class="button is-info is-outlined is-small">
                            <span class="icon">
                              <i class="fa fa-edit"></i>
                            </span>
                        </a>
<!--                        <button v-if="!actor.film.length" @click="openDeleteModal(actor)"-->
                        <button @click="openDeleteModal(actor)"
                                class="button is-danger is-outlined is-small">
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
            actorList: {
                required: true
            },
            // user: {
            //     required: true
            // },
            showFilm: {
                required: false,
                default: true
            }
        },
        components: {
            TableElement
        },
        data() {
            return {
                actors: []
            }
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
        },
        created() {
            this.actors = this.actorList;
            // alert(JSON.stringify(this.actors) );
        },
        watch: {
            actorList(newVal) {
                this.actors = newVal;
            }
        }
    }
</script>

<style scoped>

</style>
