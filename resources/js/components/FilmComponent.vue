<template>
    <div class="container">
        <hero :main-title="film.name" :sub-title="film.description" />
        <div class="columns is-multiline">
<!--            <div class="column is-three-fifths is-offset-one-fifth">-->
            <div class="column">
                <div class="box custom-box" v-if="hasActors">
<!--                    <actor-list :actor-list="this.filmActors" :user="user" :show-film="false" v-on:open-modal="setModal"></actor-list>-->
                    <actor-list :actor-list="this.filmActors" :show-film="false" v-on:open-modal="setModal"></actor-list>
                </div>
                <error-box message="No actors found" v-if="!hasActors"></error-box>
            </div>
        </div>
        <delete-modal :title="modalTitle" :delete-url="modalUrl" :active="modalActive" :content="modalContent"
                      :entry-id="modalId" v-on:close-modal="toggleModal"></delete-modal>
    </div>
</template>

<script>
    import ActorList from './ActorListComponent';

    export default {
        name: "FilmComponent",
        components: {
            ErrorBox,
            ActorList,
            DeleteModal
        },
        data() {
            return {
                modalActive: false,
                modalTitle: '',
                modalContent: '',
                modalUrl: '',
                modalId: 0,
                successMessage: '',
                filmActors: []
            }
        },
        methods: {
            toggleModal(info) {
                this.modalActive = !this.modalActive;

                if(info.id !== 0) {
                    this.filmActors = _.remove(this.filmActors, act => act.id !== info.id);
                    this.successMessage = info.message;
                }
            },
            setModal(data) {
                this.modalId = data.id;
                this.modalTitle = data.title;
                this.modalContent = data.content;
                this.modalUrl = data.url;
                this.toggleModal({id: 0});
            }
        },
        props: {
            film: {
                required: true
            },
            // user: {
            //     required: true
            // },
            actors: {
                required: true
            }
        },
        created() {
            this.filmActors = this.actors;
        },
        computed: {
            hasActors() {
                return !!this.filmActors.length;
            },
            showSuccessMessage() {
                return this.successMessage !== '';
            }
        }
    }
</script>

<style scoped>

</style>
