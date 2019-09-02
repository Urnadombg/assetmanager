<template>
    <b-container fluid>
        <h1 style="font-size: 36px">
            Сервизна история
        </h1>
        <b-card>
            <b-card-body>
                {{ entities.maintenance }}
            </b-card-body>
        </b-card>
    </b-container>
</template>

<script>
    export default {
        props: ['maintenance'],
        name: "MaintenanceIndex",
        data () {
            return {
                entities: [],
                maintenanceEntity: {
                    perform_on: '',
                    protocolUUID: '',
                    isWarrantyEvent: '',
                    asset_id: '',
                    component_id: '',
                    explanation: ''
                }
            }
        },
        mounted () {
            console.log(this.$props[0])
            this.entities = this.$props
        }

    }
</script>

<style scoped>

</style>
