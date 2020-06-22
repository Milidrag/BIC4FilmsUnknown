<template>
    <div class="table-container is-fullwidth">
        <table>
            <thead>
            <tr v-for="object in Object.keys(currentObject)">
                <table-element  element-type="th"> {{ object }}</table-element>
                <table-element  element-type="th">  &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;   </table-element>
                <table-element  element-type="th"> {{currentObject[object]}} </table-element>
            </tr>
            </thead>

        </table>
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
