<template>
<div>
    <b-card>
        <div slot="title">
            <h1>
                Сервизна история
            </h1>
        </div>
        <b-card-body>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad commodi corporis culpa, cum dignissimos distinctio dolor eos esse in itaque modi nemo nulla quam quas quia rem reprehenderit sit temporibus!
        </b-card-body>
    </b-card>
</div>
</template>

<script>
    export default {
        name: "service-history-table",
        data () {
            return {
                calledFrom: null,
                components: [],
                assets: [],
                asset_entity: {},
                component_entity: {},
            }
        }
    }
</script>

<style scoped>

</style>
