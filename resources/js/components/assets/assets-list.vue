<template>
    <b-container fluid>
       <b-card bg-variant="info" text-variant="dark" header-bg-variant="primary" body-bg-variant="white">
           <div slot="header">
               <h2>
                   Списък с техника
               </h2>
               <div class="text-right">
                   <b-btn variant="success">
                       <i class="fa fa-plus"></i>
                       Добави нова апаратура
                   </b-btn>
               </div>
           </div>
               <b-pagination
                   v-model="currentPage"
                   :total-rows="meta.total"
                   :per-page="meta.per_page"
                   aria-controls="assettable"
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
                    id="assettable"
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
                    responsive
                    @row-dblclicked="goToAssetFile"
           >
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
                   <div>
<!--                       <b-button :href="`/assets/${data.item.id}&tabIndex=1`">-->
                           <h3>
                               <a :href="`/assets/${data.item.id}&tabIndex=1`">
                                   <b-badge variant="primary">
                                       Компоненти
                                       {{ data.item.cc }}
                                   </b-badge>
                               </a>
                           </h3>
<!--                       </b-button>-->
<!--                       sdf-->
<!--                       {{ data.detailsShowing ? "da" :"ne"}}-->
                   </div>
               </template>
               <template slot="[department]" slot-scope="data">
                   {{ data.item.department}}
               </template>
               <template slot="[customer]" slot-scope="data">
                   <div v-if="data.item.customer.companies.length > 0">
                       <a :href="'/customers/' + data.item.customer.id">
                           {{data.item.customer.companies[0].companyName }}
                       </a>
                   </div>
                   <div v-else>
                       <a :href="'/customers/' + data.item.customer.id">
                           {{ data.item.customer.name }} {{ data.item.customer.lastname }}
                       </a>
                   </div>
               </template>
                <template slot="[actions]" slot-scope="data">
                    <b-dropdown id="dropdown-aria" text="Виж"  split
                                split-variant="outline-primary"
                                variant="primary">
                        <div slot="text">
                            <i class="fas fa-eye"></i>
                            Виж
                        </div>
                        <b-dropdown-header id="dropdown-header-1">
                            {{ data.item.title }}
                            {{ data.item.model }}
                        </b-dropdown-header>
                        <b-dropdown-item aria-describedby="dropdown-header-1" :href="`/assets/${data.item.id}`">
                            Виж досието
                        </b-dropdown-item>
                        <b-dropdown-item aria-describedby="dropdown-header-1" :href="`/assets/${data.item.id}/edit`">
                            Редакция
                        </b-dropdown-item>
                        <b-dropdown-item aria-describedby="dropdown-header-1" href="" @click="deleteAsset(data.item.id)">
                            Изтриване
                        </b-dropdown-item>
                        <b-dropdown-item-button aria-describedby="dropdown-header-1">Виж компонентите</b-dropdown-item-button>

                        <b-dropdown-header id="dropdown-header-2">
                            <i class="fas fa-cogs"></i>
                            Компоненти
                        </b-dropdown-header>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">Добави</b-dropdown-item-button>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">Виж</b-dropdown-item-button>

<!--                        <b-dropdown-divider></b-dropdown-divider>-->

                        <b-dropdown-header id="dropdown-header-2">Сервиз</b-dropdown-header>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">История</b-dropdown-item-button>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">Добави ново сервизно събитие</b-dropdown-item-button>

<!--                        <b-dropdown-divider></b-dropdown-divider>-->

                        <b-dropdown-header id="dropdown-header-2">Документи</b-dropdown-header>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">История</b-dropdown-item-button>
                        <b-dropdown-item-button aria-describedby="dropdown-header-2">Добави нов документ</b-dropdown-item-button>

                    </b-dropdown>
<!--                    <b-btn-group>-->
<!--                        <a :href="`/assets/${data.item.id}`" class="btn btn-primary">Виж</a>-->
<!--                        <a href="" class="btn btn-info">Редакция</a>-->
<!--                        <a href="" class="btn btn-warning">Изтрий</a>-->
<!--                    </b-btn-group>-->
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
                trg: '',
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
            this.getAssetRecords()
        },
        methods: {
            deleteAsset(id) {
                axios.delete(`/api/assets/${id}`)
                    .then(
                        (data) => {
                            console.log(data)
                            this.$root.$emit('bv::refresh::table', 'assettable')
                        }
                    )
                    .catch((err) => console.log(err))
            },
            goToAssetFile(x) {
                window.location.href = '/assets/' + x.id
            },
            getAssetRecords(ctx, callback) {

                console.log(ctx)
                let req = axios.get(`/api/assets?${this.currentPage}`);
               return req.then(
                    (data) => {
                        this.meta = data.data.meta
                        const items = data.data.data
                        return items
                    }
                )
                // this.sortBy = ctx.sortBy
                // // console.log(ctx.apiUrl)
                // // console.log(data.data.data);
                // let promise = axios.get(`/api/assets?page=${this.currentPage}`)
                //
                // return promise.then((data) => {
                //     this.meta = data.data.meta
                //     // this.assets = data.data.data
                //     const assets = data.data.data
                //     this.assets = assets
                //     return assets
                // }).catch(error => {
                //     // Here we could override the busy state, setting isBusy to false
                //     // this.isBusy = false
                //     // Returning an empty array, allows table to correctly handle
                //     // internal busy state in case of error
                //     return []
                // })
            },
            pageChanged(ctx) {
                // this.currentPage = this.meta.current_page
                // console.log(this.currentPage)
                this.currentPage = ctx
                this.getAssetRecords();
                this.$root.$emit('bv::refresh::table', 'assettable')
            }
        }
    }
</script>

<style scoped>

</style>
