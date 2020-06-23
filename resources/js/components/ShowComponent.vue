<template>
    <div class="container">
        <hero main-title="SHOW" class="column is-three-quarter is-offset-two-fifth"></hero>
        <div class="columns">
            <div class="column is-three-fifths is-offset-one-fifth">
                <div class="box custom-box">
                        <table>
                            <thead>
                            <tr v-for="object in Object.keys(currentObject)">
                                <table-element  element-type="th"> {{ object }}</table-element>
                                <table-element  element-type="th">  &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;   </table-element>
                                <table-element  element-type="td"> {{currentObject[object]}} </table-element>
                            </tr>
                            </thead>

                        </table>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "ShowComponent",
        props: {
            currentObject: {
                required: true
            }
        },
        components: {
            TableElement
        }
    }
</script>

<style scoped>

</style>
