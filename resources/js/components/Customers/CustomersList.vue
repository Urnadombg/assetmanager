<template>
<div class="dol">
    <h1>11</h1>
    <b-table :items="customers"
             :fields="fields"
             hover
             responsive
             show-empty
             striped
    >
        <template v-slot:cell(name)="row">
            {{ row.item.name }} {{ row.item.lastname }}
        </template>

        <template v-slot:cell(actions)="row">
           <b-btn @click="goToClient(row.item.id)">
               Виж
           </b-btn>
        </template>
    </b-table>
</div>
</template>

<script>
    export default {
        name: "CustomersList",
        props: ['clist'],
        data (){
            return {
                customers: [],
                fields: [
                    {
                        label: 'Клиент',
                        key: 'name'
                    },
                    {
                        label: 'Град',
                        key: 'city'
                    },
                    {
                        label: 'Телефон',
                        key: 'phone'
                    },
                    {
                        label: 'Фирмени данни',
                        key: 'company'
                    },
                    {
                        label: '',
                        key: 'actions'
                    }
                ]
            }
        },
        mounted() {
            this.customers = this.$props.clist ? this.$props.clist : []
            console.log(this.$props)
        },
        methods: {
            goToClient(client) {
                window.location.href = `/customers/${client}`
            }
        }
    }
</script>

<style scoped>

</style>
