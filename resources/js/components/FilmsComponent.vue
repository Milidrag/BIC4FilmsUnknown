<template>
    <div class="container">
        <hero main-title="Films"></hero>
        <div class="columns is-multiline">
            <div class="column is-three-fifths is-offset-one-fifth">
                <success-box :message="successMessage" v-if="showSuccessMessage"></success-box>
                <div class="box custom-box" v-if="hasFilms">
                    <films-list :films="films" v-on:open-modal="setModal"></films-list>
                </div>
                <error-box message="No films found" v-if="!hasFilms"></error-box>
            </div>
        </div>
        <delete-modal :title="modalTitle" :delete-url="modalUrl" :active="modalActive" :content="modalContent"
                      :entry-id="modalId" v-on:close-modal="toggleModal"></delete-modal>
    </div>
</template>

<script>
    import FilmsList from './FilmListComponent';

    export default {
        components:{
            FilmsList,
            ErrorBox,
            SuccessBox,
            DeleteModal
        },
        name: "FilmsComponent",
        data() {
            return {
                films: [],
                modalActive: false,
                modalTitle: '',
                modalContent: '',
                modalUrl: '',
                modalId: 0,
                successMessage: ''
            }
        },
        props: {
            allFilms: {
                type: Array,
                required: true
            }
        },
        methods: {
            toggleModal(info) {
                this.modalActive = !this.modalActive;

                if(info.id !== 0) {
                    this.films = _.remove(this.films, cat => cat.id !== info.id);
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
            this.films = this.allFilms;
        },
        computed: {
            hasFilms() {
                return !!this.films.length;
            },
            showSuccessMessage() {
                return this.successMessage !== '';
            }
        }

    }
</script>

<style scoped>

</style>
