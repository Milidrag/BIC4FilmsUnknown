<template>
    <div class="container">
        <hero :main-title="currentTitle"></hero>
        <div class="columns is-multiline">
<!--            <div class="column is-three-fifths is-offset-one-fifth">-->
            <div class="column">
                <success-box :message="successMessage" v-if="showSuccessMessage"></success-box>
                <div class="box custom-box" v-if="hasActors">
<!--                    <actor-list :actor-list="actors" :user="user" v-on:open-modal="setModal"></actor-list>-->
                    <actor-list :actor-list="actors" v-on:open-modal="setModal"></actor-list>
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
        components: {
            ActorList,
            ErrorBox,
            SuccessBox,
            DeleteModal
        },
        name: "ActorsComponent",
        data() {
            return {
                Actors: [],
                // user: {},
                modalActive: false,
                modalTitle: '',
                modalContent: '',
                modalUrl: '',
                modalId: 0,
                successMessage: ''
            }
        },
        props: {
            allActors: {
                type: Array,
                required: true
            },
            currentTitle: {
                type: String,
                required: false,
                default: "Actors"
            }
            // currentUser: {
            //     type: Object,
            //     required: true
            // }
        },
        methods: {
            toggleModal(info) {
                this.modalActive = !this.modalActive;

                if(info.id !== 0) {
                    this.actors = _.remove(this.actors, act => act.id !== info.id);
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
        created() {
            this.actors = this.allActors;
            // this.user = this.currentUser;
        },
        computed: {
            hasActors() {
                return !!this.actors.length;
            },
            showSuccessMessage() {
                return this.successMessage !== '';
            }
        }

    }
</script>

<style scoped>

</style>
