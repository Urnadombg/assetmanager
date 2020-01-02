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
           </b-container>
           <br>
           <vuetable-pagination-info ref="paginationInfoTop"
           ></vuetable-pagination-info>
           <b-table :items="getAssetRecords"
                    id="assettable"
                    bordered
                    ref="table"
                    :busy.sync="isBusy"
                    head-variant="dark"
                    :sort-desc.sync="sortDesc"
                    show-empty
                    :fields="tableFields"
                    hover
                    striped
                    responsive
                    @row-dblclicked="goToAssetFile"
                    @filtered="onFiltered"
           >
               <template v-slot:cell(nomer)="data" style="width: 3%">
                    {{ data.index + 1 }}
               </template>
               <template v-slot:cell(title)="data">
                   {{ data.item.title }} {{ data.item.model }}
               </template>
               <template v-slot:cell(actions)="data">
                    <b-btn-group>
                        <b-btn variant="info" @click="goToAssetFile(data.item, 0)">
                            <i class="fa fa-eye"></i>
                        </b-btn>
                        <b-btn variant="warning" @click="goToAssetFile(data.item,1)">
                            <i class="fa fa-cogs"></i>
                        </b-btn>
                        <b-btn variant="primary" @click="goToAssetFile(data.item,2)">
                            <i class="fa fa-tools"></i>
                        </b-btn>
                        <b-btn variant="success" @click="goToAssetFile(data.item,3)">
                            <i class="fa fa-folder"></i>
                        </b-btn>
                    </b-btn-group>
               </template>
           </b-table>

       </b-card>

    </b-container>
</template>

<script>
    import ServiceHistoryTable from "../ServiceHistory/table";
    import VueAutoSuggest from 'vue-autosuggest'

    export default {
        name: "asset-list",
        props: ['localData'],
        components: {ServiceHistoryTable,VueAutoSuggest},
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
                        label: 'сериен №',
                        key: 'serial',
                        sortable: true
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
                sortBy: 'model',
                sortOrder: [
                    {
                        field: 'model',
                        direction: 'asc'
                    }
                ]
            }
        },

        mounted() {
            if (this.$props.localData) {
                console.log("da")
            }
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
            goToAssetFile(asset, tabIndex) {
                window.location.href = `/assets/${asset.id}&tabIndex=${tabIndex}`
            },
            getAssetRecords(ctx) {
                this.isBusy = true
                const promise = axios.get(`/api/assets?page=${this.currentPage}`)
                // Must return a promise that resolves to an array of items

                return promise.then(data => {
                    // Pluck the array of items off our axios response

                    const items = data.data.data
                    this.meta = data.data.meta
                    this.isBusy = false
                    this.assets = items
                    // Must return an array of items or an empty array if an error occurred
                    return items || []
                })


            },
            onFiltered(filteredItems) {
                // console.log(filteredItems)
                // console.log("ON FILTER")
                // this.currentPage = filteredItems.meta.current_page
                // this.getAssetRecords()
                this.getAssetRecords().then((d) => console.log(d))
            },
            pageChanged(ctx) {
                // this.currentPage = this.meta.current_page
                // console.log(this.currentPage)
                this.currentPage = ctx
                this.getAssetRecords();
                this.$root.$emit('bv::refresh::table', 'assettable')
            },
            clickHandler(item) {
                // event fired when clicking on the input
                // this.searchAsset('sh');
            },
            searchAsset(term) {
              return axios.get(`/api/assets/search/${term}`)
                    .then(
                        (data) => {
                            const items = data.data
                           return items || []
                        }
                    )
                    .catch(
                        (error) => {
                            console.log(error)

                        }
                    )
            }
        }
    }
</script>

<style>
    autosuggest__results {
        background-color: #4dc0b5;
    }
    .autosuggest-container {
        display: flex;
        justify-content: center;
        width: 280px;
    }

    #autosuggest { width: 100%; display: block;}
    .autosuggest__results-item--highlighted {
        background-color: #faf;
    }
</style>
