<template>
    <div class="container">
        <hero :main-title="actor.name" :sub-title="actor.description" />
        <div class="columns is-multiline">
            <div class="column is-three-fifths is-offset-one-fifth">
                <div class="box custom-box" v-if="actor.film_id">
                    <!--                    <actor-list :actor-list="this.filmActors" :user="user" :show-film="false" v-on:open-modal="setModal"></actor-list>-->
                    <film-list :actor-list="this.filmActors" :show-film="false" v-on:open-modal="setModal"></film-list>
                </div>
                <error-box message="No film found" v-if="!actor.film_id"></error-box>
            </div>
        </div>
        <actor-detail :actor="actor"></actor-detail>
        <actor-message-form :blog-id="actor.id" @new-message="sendNewMessage"></actor-message-form>
        <div v-if="showSuccessMessage" class="columns is-multiline">
            <div class="column is-half is-offset-one-quarter">
                <success-box :message="successMessage" v-if="showSuccessMessage"></success-box>
            </div>
        </div>
<!--        <actor-message-list v-if="hasMessages" :actor-messages="messages" :actor-slug="actor.slug" :new-message="newMessage"-->
<!--                            @sync-messages="syncMessages" :current-user="currentUser"-->
<!--                            @open-modal="setModal"></actor-message-list>-->
<!--        <actor-message-list v-if="hasMessages" :actor-messages="messages" :actor-slug="actor.slug" :new-message="newMessage"-->
<!--                           @sync-messages="syncMessages"-->
<!--                           @open-modal="setModal"></actor-message-list>-->
<!--        <div v-if="!hasMessages" class="columns is-multiline">-->
<!--            <div class="column is-half is-offset-one-quarter">-->
<!--                <error-box message="No messages found" v-if="!hasMessages"></error-box>-->
<!--            </div>-->
<!--        </div>-->
        <delete-modal :title="modalTitle" :delete-url="modalUrl" :active="modalActive" :content="modalContent"
                      :entry-id="modalId" v-on:close-modal="toggleModal"></delete-modal>
    </div>
</template>

<script>
    // import BlogDetail from "./BlogDetailComponent";
    // import BlogMessageForm from "./BlogMessageFormComponent";
    // import BlogMessageList from "./BlogMessageListComponent";

    export default {
        name: "ActorComponent",
        components: {
            ErrorBox,
            SuccessBox,
            DeleteModal,
            // BlogDetail,
            // BlogMessageForm,
            // BlogMessageList
        },
        props: {
            currentActor: {
                required: true
            },
            // currentMessages: {
            //     required: true
            // },
            // currentUser: {
            //     required: true
            // },
        },
        data() {
            return {
                actor: [],
                // messages: [],
                // newMessage: {},
                modalActive: false,
                modalTitle: '',
                modalContent: '',
                modalUrl: '',
                modalId: 0,
                successMessage: ''
            }
        },
        methods: {
            // sendNewMessage(message) {
            //     this.newMessage = message;
            //
            //     if (!this.messages.length)
            //         this.messages.push(message);
            // },
            // syncMessages(allMessages) {
            //     if (this.messages !== allMessages)
            //         this.messages = allMessages.reverse();
            // },
            toggleModal(info) {
                this.modalActive = !this.modalActive;

                if (info.id !== 0) {
                    this.messages = _.remove(this.messages, msg => msg.id !== info.id);
                    this.successMessage = info.message;
                }
            },
            setModal(data) {
                this.modalTitle = data.title;
                this.modalContent = data.content;
                this.modalUrl = data.url;
                this.modalId = data.id;
                this.toggleModal({id: 0});
            }
        },
        created() {
            this.actor = this.currentActor;
            alert(JSON.stringify(this.actor));
            // if (this.currentMessages instanceof Object)
            //     Object.keys(this.currentMessages).forEach(item =>
            //         this.messages.push(this.currentMessages[item]));
            // else
            //     this.messages = this.currentMessages;
        },
        computed: {
            // hasMessages() {
            //     return !!this.messages.length;
            // },
            showSuccessMessage() {
                return this.successMessage !== '';
            }
        }
    }
</script>

<style scoped>

</style>
