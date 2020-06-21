<template>
    <div class="container">
        Which actor you want to see?

        <form @submit.prevent="submit">


            <div class="field">
                <label class="label" for="name">Name</label>
                <div class="control">
                    <input id="name" v-model="name" class="input"></input>
                </div>

            </div>


            <button type="submit" class="button is-large is-primary is-outlined is-fullwidth"/>
        </form>
    </div>
</template>

<script>

    export default {
        name: "ShowActorComponent",

        data(){
            return {
                name: ''

            }
        },
        methods: {
            submit() {
                axios.post('actor/', {
                    name: 'Brown, Hickle and Botsford'
                })
                    .then(() => {
                        console.log("Success. . . . ")
                        alert("Successfully Driver Added");
                    })
                    .catch(error => console.log(error));

                    }

        }

    }
</script>

<style scoped>

</style>
