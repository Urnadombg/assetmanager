<template>
    <b-container fluid>
       <b-card bg-variant="info" header-bg-variant="primary" body-bg-variant="white">
           <div slot="header">
           </div>
           <b-table :items="assets" :fields="tableFields" small hover striped>
<!--           <b-table :items="assets" hover striped>-->
               <template slot="[nomer]" slot-scope="data">
                   {{ data.index +1 }}
               </template>
               <template slot="[typeOfAsset]" slot-scope="data">
                   {{ data.item.type_of_asset === 'Primary' ? "Основен актив": "второстепенен/компонент"}}
               </template>
               <template slot="[components]" slot-scope="data">
                   <div v-if="data.item.components.length > 0">
                       {{ data.item.components.length}}
                   </div>
               </template>
               <template slot="[customer]" slot-scope="customer">
<!--                   {{ data.item.customer }}-->
<!--                   {{ customer }}-->
               </template>
                <template slot="[actions]" slot-scope="data">
                    <b-btn-group>
                        <a :href="`assets/${data.item.id}`" class="btn btn-primary">Виж</a>
                        <a href="" class="btn btn-info">Редакция</a>
                        <a href="" class="btn btn-warning">Изтрий</a>
                    </b-btn-group>
                </template>
           </b-table>
       </b-card>
    </b-container>
</template>

<script>
    export default {
        name: "asset-list",
        data () {
            return {
                assets: [],
                tableFields: [
                    {
                        label: '№',
                        key: 'nomer'
                    },
                    {
                        label: 'Наименование на актива',
                        key: 'title'
                    },
                    {
                        label: 'Модел',
                        key: 'model'
                    },
                    {
                        label: 'сериен №',
                        key: 'serial'
                    },
                    {
                        label: 'Тип на актива',
                        key: 'typeOfAsset'
                    },
                    {
                        label: 'Допълнително оборудване',
                        key: 'components'
                    },
                    {
                        label: 'Клиент',
                        key: 'customer'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    },
                ]
            }
        },
        mounted() {
            axios.get('/api/assets')
                .then(
                    (data) => {
                        this.assets = data.data
                    }
                )

        }
    }
</script>

<style scoped>

</style>
