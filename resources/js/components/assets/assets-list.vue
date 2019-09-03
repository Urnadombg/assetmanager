<template>
    <b-container fluid>
       <b-card bg-variant="info" text-variant="dark" header-bg-variant="primary" body-bg-variant="white">
           <div slot="header">
           </div>
               <b-pagination
                   v-model="currentPage"
                   :total-rows="meta.total"
                   :per-page="meta.per_page"
                   aria-controls="my-table"
                   first-text="Първа"
                   prev-text="Предишна"
                   next-text="Следваща"
                   last-text="Последна"
                   size="xl"
                   align="fill"
                   @change="pageChanged"
               ></b-pagination>
           <b-container fluid>
                <b-form-input size="lg" v-model="filter"></b-form-input>
           </b-container>
           <br>

           <b-table :items="getAssetRecords"
                    id="my-table"
                    bordered
                    ref="table"
                    :busy.sync="isBusy"
                    head-variant="dark"
                    :sort-desc.sync="sortDesc"
                    show-empty
                    :filter="filter"
                    :per-page="meta.per_page"
                    :current-page="meta.current_page"
                    :fields="tableFields"
                    hover
                    striped
                    responsive>
<!--           <b-table :items="assets" hover striped>-->
               <template slot="table-busy">
                   <div >
                       <b-spinner class="align-content-lg-center"></b-spinner>
                       <strong>Зарежда...</strong>
                   </div>
               </template>
               <template slot="[nomer]" slot-scope="data">
                   {{ data.index +1 }}
               </template>
               <template slot="[typeOfAsset]" slot-scope="data">
                   {{ data.item.type_of_asset === 'primary' ? "Основен актив": "второстепенен/компонент"}}
               </template>

               <template slot="row-details" slot-scope="row">
                   <b-card>
                       <b-row class="mb-2">
                           <!--<b-col><b>Age:</b></b-col>-->
                           <b-col>
                               <component-list :components="row.item.components"></component-list>
                               <!--<service-history-table :maintenanceData="[row.item]"></service-history-table>-->
                           </b-col>
                       </b-row>

                       <b-button size="sm" @click="row.toggleDetails">Скрий детайлите</b-button>
                   </b-card>
               </template>

               <template slot="[components]" slot-scope="data">
                   <div v-if="data.item.components.length > 0">
                       <!--<b-button variant="primary" :href="'/assets/' + data.item.id" @click="data.toggleDetails()">-->

                       <!--<b-button size="sm" @click="row.toggleDetails" class="mr-2">-->
                           <!--{{ row.detailsShowing ? 'Hide' : 'Show'}} Details-->
                       <!--</b-button>-->
                       <!---->
                       <b-button variant="primary" @click="data.toggleDetails">
                           Компоненти
                           <b-badge variant="light">
                               {{ data.item.components.length}}
                           </b-badge>
                       </b-button>
                       {{ data.detailsShowing ? "da" :"ne"}}
                   </div>
               </template>
               <template slot="[department]" slot-scope="data">
                   {{ data.item.department}}
               </template>
               <template slot="[customer]" slot-scope="data">
                   <div v-if="data.item.customer.legal_info !== undefined">
                       <a :href="'/customers/' + data.item.customer.id">
                           {{data.item.customer.legal_info.companyName }}, {{ data.item.customer.name }} {{ data.item.customer.lastname }}
                       </a>
                   </div>
                   <!--{{ data.item.customer.legal_info !== undefined }}-->
<!--                  {{ customer.item.customer['name'] }}-->
<!--                  {{ customer.item.customer['lastname'] }}-->
               </template>
                <template slot="[actions]" slot-scope="data">
                    <b-btn-group>
                        <a :href="`/assets/${data.item.id}`" class="btn btn-primary">Виж</a>
                        <a href="" class="btn btn-info">Редакция</a>
                        <a href="" class="btn btn-warning">Изтрий</a>
                    </b-btn-group>
                </template>
           </b-table>
       </b-card>

    </b-container>
</template>

<script>
    import ServiceHistoryTable from "../ServiceHistory/table";
    export default {
        name: "asset-list",
        components: {ServiceHistoryTable},
        data () {
            return {
                assets: [],
                filter: null,
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
                        key: 'serial',
                        sortable: true
                    },
                    {
                        label: 'Тип на актива',
                        key: 'typeOfAsset',
                        sortable: true
                    },
                    {
                        label: 'Допълнително оборудване',
                        key: 'components',
                        sortable: true
                    },
                    {
                        label: 'Катедра',
                        key: 'department',
                        sortable: true
                    },
                    {
                        label: 'Клиент',
                        key: 'customer'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    },
                ],
                meta: '',
                currentPage: 1,
                isBusy: false,
                sortDesc: false,
                sortBy: 'model'
            }
        },
        mounted() {

        },
        methods: {
            getAssetRecords(ctx, callback) {
                ctx.apiUrl = '/api/assets'
                // console.log("ctx", ctx)
                // console.log("callback", callback)
                this.sortBy = ctx.sortBy
                // console.log(ctx.apiUrl)
                // console.log(data.data.data);
                let promise = axios.get(`/api/assets?page=${this.currentPage}`)

                return promise.then((data) => {
                    console.log(data.data.data);
                    this.meta = data.data.meta
                    this.assets = data.data.data
                    const items = data.data.data
                    // Here we could override the busy state, setting isBusy to false
                    // this.isBusy = false
                    return(items)
                }).catch(error => {
                    // Here we could override the busy state, setting isBusy to false
                    // this.isBusy = false
                    // Returning an empty array, allows table to correctly handle
                    // internal busy state in case of error
                    return []
                })
            },
            pageChanged() {
                // this.currentPage = this.meta.current_page
                // console.log(this.currentPage)

                // axios.get(`/api/assets?page=${this.currentPage}`)
                //     .then(
                //         (data) => {
                //
                //             const items = data.data.data
                //             // Here we could override the busy state, setting isBusy to false
                //             // this.isBusy = false
                //             return(items)
                //         }
                //     )
                this.$root.$emit('bv::refresh::table', 'my-table')
            }
        }
    }
</script>

<style scoped>

</style>
