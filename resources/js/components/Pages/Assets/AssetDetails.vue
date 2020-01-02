<template>
    <b-container fluid>
        <div v-if="loading" class="text-center">
            <b-spinner variant="primary" v-if="loading" label="Spinning"></b-spinner>
            <h2>
                Зарежда...
            </h2>
        </div>
        <b-card
            v-if="!loading"
            header-bg-variant="dark"
            header-text-variant="white"
            text-variant="black"
            body-bg-variant="white">
            <div slot="header">
                <h1 v-if="!loading">
                    {{ assetInfo.title }}
                    {{ assetInfo.model }}
                    <span>, сериен № </span>
                    {{ assetInfo.serial }}
                </h1>
                <b-row>
                    <b-col cols="1">
                    </b-col>
                    <b-col>
                    </b-col>
                </b-row>
            </div>
            <b-container fluid>
                <b-tabs card no-body>
                    <b-tab v-if="!loading" @click="tri(0)" :active="activeTab === 0">
                        <template slot="title">
                            <i class="fas fa-money-check"></i>
                            Детайли
                        </template>
                <b-card>
                    <div slot="header">
                        <h1>
                            <i class="fas fa-money-check"></i>
                            Детайли
                        </h1>
                    </div>
                    <b-card-body>
                        <b-row>
                            <b-col cols="6">
                                <b-btn @click="refreshTable">refresher</b-btn>
                                <b-table :items="[assetInfo]"
                                         :fields="assetDetailsFields"
                                         class="table-responsive"
                                         ref="assetInfoTable"
                                         :busy="assetTableBusyState"
                                         stacked
                                         small>
                                    <template v-slot:cell(title)="row">
                                        <b-form-group v-if="isInEditMode">
                                            <b-form-input v-model="currentAsset.title"></b-form-input>
                                        </b-form-group>
                                        <span v-show="!isInEditMode">
                                            {{ row.item.title }}
                                        </span>
                                    </template>

                                    <template v-slot:cell(model)="row">
                                        <b-form-group v-if="isInEditMode">
                                            <b-form-input v-model="currentAsset.model"></b-form-input>
                                        </b-form-group>
                                        <span v-show="!isInEditMode">
                                            {{ row.item.model }}
                                        </span>
                                    </template>

                                    <template v-slot:cell(serial)="row">
                                        <span v-show="!isInEditMode">
                                            {{ !row.item.serial ? '-' : row.item.serial }}
                                        </span>
                                        <b-input-group v-if="isInEditMode" label="Сериен №:">
                                            <b-form-input v-model="currentAsset.serial"></b-form-input>
                                        </b-input-group>
                                    </template>
                                    <template v-slot:cell(location)="row">
                                       <span v-show="!isInEditMode">
                                            {{ !row.item.location ? '-' : row.item.location }}
                                        </span>
                                        <b-input-group v-if="isInEditMode" label="Сериен №:">
                                            <b-form-input v-model="currentAsset.location"></b-form-input>
                                        </b-input-group>
                                    </template>
                                    <template v-slot:cell(type_of_asset)="row">
                                       <span v-show="!isInEditMode">
                                            {{ !row.item.type_of_asset ? '-' : (row.item.type_of_asset === "primary" ? 'Основен актив' : 'Вторичен актив') }}
                                        </span>
                                        <b-form-group v-if="isInEditMode">
                                            <b-form-select v-model="currentAsset.type_of_asset"
                                                           :options="[{ value: 'primary', text: 'Основен актив'},
                                                       { value: 'secondary', text: 'Вторичен'}]">

                                            </b-form-select>
                                        </b-form-group>
                                    </template>

                                    <template v-slot:cell(warranty)="row">
                                         <span v-if="!row.item.warranty">
                                            <b-btn size="sm" variant="primary" @click="createWarranty(row)">+-</b-btn>
                                        </span>
                                        <span v-else>
                                            {{ row.item.warranty.start}} - {{ row.item.warranty.end }}
                                        </span>
                                        <b-btn variant="warning" @click="createWarranty(row)">Регенерирай</b-btn>
                                    </template>
                                    <template v-slot:cell(purchaseDate)="row">
                                        <span v-if="!row.item.purchaseDate">
                                            <b-btn size="sm" variant="primary">+</b-btn>
                                        </span>
                                     </template>
                                    <template v-slot:cell(customer)="row">
                                         <span v-if="!row.item.customer">
<!--                                            <b-btn size="sm" variant="primary" @click="createWarranty(row)">+-</b-btn>-->
                                        </span>
                                        <span v-else>
                                            <a :href="`/customers/${row.item.customer.id}`">
                                             {{ row.item.customer.name }}
                                            {{ row.item.customer.lastname }}
                                            </a>
                                            <multiselect :options="customers"
                                                         :searchable="true"
                                                         :custom-label="customLabelForAc"
                                                         track-by="name"
                                                         v-model="customer"
                                                         @select="changeOwnerShip"
                                                         @search-change="getCustomersForAC">
                                                <template slot="option" slot-scope="props">
                                                    {{ props.option.name }}
                                                    {{ props.option.lastname }}
                                                </template>
                                                <template slot="singleLabel" slot-scope="props">
                                                    {{ props.option.name }}
                                                    {{ props.option.lastname }}
                                                </template>
                                            </multiselect>
                                        </span>
                                    </template>
                                    <template v-slot:cell(actions)="row">
                                        <b-btn-group>
                                            <b-btn @click="prepareForUpdate(row)">Редакция</b-btn>
                                            <b-btn @click="update(row)">Update</b-btn>
                                            <b-btn>Изтрий</b-btn>
                                        </b-btn-group>
                                     </template>

                                    <!--                                            <template slot="[serial]" slot-scope="data">-->
<!--                                                 <span v-if="data.item.serial === null">-->
<!--                                                  <b-btn @click="setEditModeOn(data.item, 'serial')"-->
<!--                                                         v-show="!isInEditMode"-->
<!--                                                         class="btn btn-primary btn-sm">-->
<!--                                                      <i class="fas fa-plus"></i>-->
<!--                                                  </b-btn>-->
<!--                                                  </span>-->
<!--                                                    <b-form v-if="isInEditMode && attributeToUpdate === 'serial'">-->
<!--                                                        <b-input-group>-->
<!--                                                            <b-form-input size="sm"-->
<!--                                                                          v-model="currentAsset.serial"></b-form-input>-->
<!--                                                            <b-input-group-append>-->
<!--                                                                <b-button variant="success" size="sm"-->
<!--                                                                          @click="isInEditMode = !isInEditMode">-->
<!--                                                                    Запази-->
<!--                                                                </b-button>-->
<!--                                                                <b-button variant="danger" size="sm"-->
<!--                                                                          @click="isInEditMode = !isInEditMode">-->
<!--                                                                    Откажи-->
<!--                                                                </b-button>-->
<!--                                                            </b-input-group-append>-->
<!--                                                        </b-input-group>-->
<!--                                                    </b-form>-->
<!--                                                    {{ data.item.serial }}-->
<!--                                            </template>-->
<!--                                            <template slot="[location]" slot-scope="data">-->
<!--                                                <span v-if="data.item.location === null">-->
<!--                                                    <b-btn @click="setEditModeOn(data.item, 'location')"-->
<!--                                                    v-show="!isInEditMode"-->
<!--                                                    class="btn btn-primary btn-sm">-->
<!--                                                        <i class="fas fa-plus"></i>-->
<!--                                                    </b-btn>-->
<!--                                                </span>-->
<!--                                            <b-form v-if="isInEditMode && attributeToUpdate === 'location'">-->
<!--                                                <b-input-group>-->
<!--                                                    <b-form-input size="sm"></b-form-input>-->
<!--                                                    <b-input-group-append>-->
<!--                                                        <b-button variant="success" size="sm">-->
<!--                                                            Запази-->
<!--                                                        </b-button>-->
<!--                                                        <b-button variant="danger" size="sm"-->
<!--                                                                  @click="isInEditMode = !isInEditMode">-->
<!--                                                            Откажи-->
<!--                                                        </b-button>-->
<!--                                                    </b-input-group-append>-->
<!--                                                </b-input-group>-->
<!--                                            </b-form>-->
<!--                                            {{ data.item.location }}++-->
<!--                                            </template>-->
<!--                                            <template slot="[department]" slot-scope="data">-->
<!--                                                  <span v-if="data.item.department === null">-->
<!--                                                      <b-btn @click="setEditModeOn(data.item, 'department')"-->
<!--                                                             v-show="!isInEditMode"-->
<!--                                                             class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>-->
<!--                                                      </b-btn>-->
<!--                                                  </span>-->
<!--                                                    <b-form v-if="isInEditMode && attributeToUpdate === 'department'">-->
<!--                                                        <b-input-group>-->
<!--                                                            <b-form-input size="sm"></b-form-input>-->
<!--                                                            <b-input-group-append>-->
<!--                                                                <b-button variant="success" size="sm">-->
<!--                                                                    Запази-->
<!--                                                                </b-button>-->
<!--                                                                <b-button variant="danger" size="sm"-->
<!--                                                                          @click="isInEditMode = !isInEditMode">-->
<!--                                                                    Откажи-->
<!--                                                                </b-button>-->
<!--                                                            </b-input-group-append>-->
<!--                                                        </b-input-group>-->
<!--                                                    </b-form>-->
<!--                                                    {{ data.item.department }}-->
<!--                                                </template>-->
<!--                                            <template slot="[warranty]" slot-scope="row">-->
<!--                                                dawqr-->
<!--                                                <strong>Валидна от:</strong>``-->
<!--                                                {{ data.item.warranty.start }}-`- -->
<!--                                                <strong>до:</strong>-->
<!--                                                {{ data.item.warranty.end }}-->
<!--                                            </template>-->
<!--                                            <template slot="[purchaseDate]" slot-scope="data">-->
<!--                                              <span v-if="data.item.purchaseDate === null">-->
<!--                                                  <b-btn @click="setEditModeOn(data.item, 'purchaseDate')"-->
<!--                                                         v-show="!isInEditMode"-->
<!--                                                         class="btn btn-primary btn-sm">-->
<!--                                                      <i class="fas fa-plus"></i>-->
<!--                                                  </b-btn>-->
<!--                                              </span>-->
<!--                                                <b-form v-if="isInEditMode && attributeToUpdate === 'purchaseDate'">-->
<!--                                                    <b-input-group>-->
<!--                                                        <b-form-input size="sm"></b-form-input>-->
<!--                                                        <b-input-group-append>-->
<!--                                                            <b-button variant="success" size="sm">-->
<!--                                                                Запази-->
<!--                                                            </b-button>-->
<!--                                                            <b-button variant="danger" size="sm"-->
<!--                                                                      @click="isInEditMode = !isInEditMode">-->
<!--                                                                Откажи-->
<!--                                                            </b-button>-->
<!--                                                        </b-input-group-append>-->
<!--                                                    </b-input-group>-->
<!--                                                </b-form>-->
<!--                                                {{ data.item.purchaseDate }}-->
<!--                                            </template>-->
                                </b-table>
                            </b-col>
                            <b-col cols="6">
<!--                                <b-form @submit="uploadFile" enctype="multipart/form-data">-->
<!--                                    <b-form-file v-model="file"></b-form-file>-->
<!--                                    <b-button variant="success" type="submit">Запази</b-button>-->
<!--                                </b-form>-->
<!--                                <div class="media" v-for="media in assetInfo.media">-->
<!--                                    <div v-if="media.media_type === 'image/jpeg'">-->
<!--                                        <b-img :src="'http://192.168.10.10/' + media.pathToMedia"-->
<!--                                               fluid>-->

<!--                                        </b-img>-->
<!--                                    </div>-->
<!--                                </div>-->

                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>

                    </b-tab>
                    <b-tab v-if="!loading" @click="tri(1)" :active="activeTab === 1">
                        <template slot="title">
                            <i class="fas fa-cogs"></i>
                            Компоненти
                        </template>
                        <b-card>
                            <div slot="header">
                                <h1>
                                    <i class="fas fa-cogs"></i>
                                    Компоненти
                                </h1>
                            </div>
<!--                            {{ assetInfo }}-->
<!--                            <b-btn variant="info" @click="addComponentToAsset">Добави</b-btn>-->

                            <component-list :components="assetInfo.components"></component-list>

                            <add-component-to-asset :id="assetInfo.id"></add-component-to-asset>

                        </b-card>
                    </b-tab>
                    <b-tab v-if="!loading" @click="tri(2)" :active="activeTab === 2">
                        <template slot="title">
                            <i class="fas fa-tools"></i>
                            Сервизна история
                        </template>
                        <div>
<!--                            {{ assetInfo}}-->
                            <service-history-table :maintenanceData="assetInfo" origin="asset"></service-history-table>
                        </div>
                    </b-tab>
                    <b-tab v-if="!loading" @click="tri(3)" :active="activeTab === 3">
                        <template slot="title">
                            <i class="fas fa-folder-open"></i>
                            Документи
                        </template>
                        {{ assetInfo.media }}
                    </b-tab>
                </b-tabs>
            </b-container>
            <!--            </b-card-body>-->
        </b-card>

    </b-container>
</template>

<script>
    import fancyBox from 'vue-fancybox';
    import MaintenanceIndex from "../../maintenances/MaintenanceIndex";
    import ComponentList from '../../components/components-list'
    import ServiceHistoryTable from "../../ServiceHistory/table";
    export default {
        components: {ServiceHistoryTable, MaintenanceIndex, ComponentList},
        props: ['id'],
        name: "AssetDetails",
        data() {
            return {
                assetInfo: [],
                assetMedia: [],
                loading: true,
                customer: '',
                customers: [],
                file: '',
                activeTab: '',
                currentAsset: {
                    id: null,
                    serial: '',
                    model: '',
                    title: '',
                    type_of_asset: '',
                    customer_id: '',
                    location: '',
                    department: '',
                    purchaseDate: '',
                },
                assetEntity: {},
                isInEditMode: false,
                attributeToUpdate: '',
                assetComponents: [],
                componentFields: [
                    {
                        label: '№',
                        key: 'num'
                    },
                    {
                        label: 'Наименование',
                        key: 'title'
                    },
                    {
                        label: 'Модел',
                        key: 'model'
                    },
                    {
                        label: 'Катедра',
                        key: 'department'
                    },
                    {
                        label: 'Сериен №',
                        key: 'serial'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    },
                ],
                assetDetailsFields: [
                    {
                        label: 'Наименование',
                        key: 'title'
                    },
                    {
                        label: 'Модел',
                        key: 'model'
                    },
                    {
                        label: 'Сериен №',
                        key: 'serial'
                    },
                    {
                        label: 'Тип на актива',
                        key: 'type_of_asset'
                    },
                    {
                        label: 'Местоположение',
                        key: 'location'
                    },

                    {
                        label: 'Гаранция',
                        key: 'warranty'
                    },
                    {
                        label: 'Катедра',
                        key: 'department'
                    },
                    {
                        label: 'Закупен / монтиран',
                        key: 'purchaseDate'
                    },
                    {
                        label: 'Собственик',
                        key: 'customer'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    },
                ],
                assetTableBusyState: false
            }
        },
        mounted() {
            // console.log(tabIndex)
            axios.get(`/api/assets/${this.$props.id}`)
            .then(
                (data) => {
                    setTimeout(() => {
                        console.log(data.data.data);
                        this.assetInfo = data.data.data
                       // console.log(this.activeTab)
                        this.loading = !this.loading
                        this.activeTab = parseInt(window.location.pathname.replace(`/assets/${this.$props.id}&tabIndex=`,''))
                    },100)
                }
            )
        },
        methods: {
            customLabelForAc({ name, lastname, city}) {
                return `${name} ${lastname} ${city}`
            },
            getCustomersForAC() {
                axios.get('/api/customers')
                    .then(
                        (data) => {
                            this.customers = data.data
                        }
                    )
            },
            changeOwnerShip(item) {
                // console.log("Asdasd", this.assetInfo[0].id)

                axios.post(`/api/assets/changeOwner`, {
                    asset_id: this.$props.id,
                    newId: item.id
                })
                    .then(
                        (data) => {
                            console.log(data.data)
                        }
                    )
            },
            refreshTable() {
                this.assetTableBusyState = true

                this.$refs.assetInfoTable.refresh()

                this.assetTableBusyState = false

            },
            createWarranty(item) {
                // console.log(item.item)
              axios.post(`/api/assets/createWarranty/${item.item.id}`, item.item.id)
                  .then(
                      (data) => {
                          this.$bvToast.toast(`Гаранционната карта е записана ${data.data.message}`)
                          this.$refs.assetInfoTable.refresh()
                      }
                  )
                  .then(
                      () => {
                          this.$refs.assetInfoTable.refresh()
                      }
                  )
            },
            addComponentToAsset(asset) {
              axios.post('/api/assets/addComponentToAsset', {
                  asset_id: asset.id,
                  rowdata: 'asdasd'
              })
            },
            tri(tabID) {
              console.log(tabID)
                // this
            },
            setActiveTab(tb) {
                console.log(tb)
                let origin = window.location.origin
                let tabIndex = parseInt(window.location.pathname.replace(`/assets/${this.$props.id}&tabIndex=`,''))
                let winHref = window.location.href = `${origin}/assets/${this.$props.id}&tabIndex=${tb}`
                window.location.href = winHref
            },
            setEditModeOn(assetToUpdate, attributeToUpdate) {
                this.isInEditMode = !this.isInEditMode
                this.assetEntity = assetToUpdate
                this.attributeToUpdate = attributeToUpdate
                assetToUpdate[attributeToUpdate] = this.currentAsset[attributeToUpdate];
            },
            update(data) {
                axios.put(`/api/assets/${this.currentAsset.id}`, this.currentAsset)
                    .then(
                        (data) => {
                            console.log(data.data)
                        }
                    )
                this.isInEditMode = false
            },
            prepareForUpdate(row) {
                this.isInEditMode = true
                this.currentAsset = row.item
                // this.currentAsset['customer_id'] = row.item.customer.id
                //
                // axios.put(`/api/assets/${this.currentAsset.id}`, this.currentAsset)
                //     .then(
                //         (data) => {
                //             console.log(data.data)
                //         }
                //     )
            },
            uploadFile(evt) {
                evt.preventDefault();
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('asset_id', this.assetInfo[0].id)
                axios.post('/api/assets/uploadFile', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(
                        (data) => {
                            if (data.status === 200) {
                                this.file = ''
                            }
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    )
            }
        }
    }
</script>

<style>
    /*.theclass {*/
    /*margin-right: 5px;*/
    /*border-radius: 0px 0px 0px 0px;*/
    /*color: #fff;*/
    /*border-bottom: 3px solid #9ed861;*/
    /*}*/
    /*.theclass a {*/
    /*font-weight: bold;*/
    /*border-radius: 0px 0px 0px 0px;*/

    /*color: #fff;*/
    /*}*/
</style>
