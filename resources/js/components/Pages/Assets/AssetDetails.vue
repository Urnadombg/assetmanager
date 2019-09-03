<template>
    <b-container fluid>
        <b-card
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
                <b-tabs card no-body v-model="activeTab">
                    <b-tab v-if="!loading">
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
                                        <b-table :items="[assetInfo]"
                                                 :fields="assetDetailsFields"
                                                 class="table-responsive"
                                                 stacked
                                                 small>
                                            <template slot="[serial]" slot-scope="data">
                                                 <span v-if="data.item.serial === null">
                                                  <b-btn @click="setEditModeOn(data.item, 'serial')"
                                                         v-show="!isInEditMode"
                                                         class="btn btn-primary btn-sm">
                                                      <i class="fas fa-plus"></i>
                                                  </b-btn>
                                                  </span>
                                                    <b-form v-if="isInEditMode && attributeToUpdate === 'serial'">
                                                        <b-input-group>
                                                            <b-form-input size="sm"
                                                                          v-model="currentAsset.serial"></b-form-input>
                                                            <b-input-group-append>
                                                                <b-button variant="success" size="sm"
                                                                          @click="isInEditMode = !isInEditMode">
                                                                    Запази
                                                                </b-button>
                                                                <b-button variant="danger" size="sm"
                                                                          @click="isInEditMode = !isInEditMode">
                                                                    Откажи
                                                                </b-button>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </b-form>
                                                    {{ data.item.serial }}
                                            </template>
                                            <template slot="[location]" slot-scope="data">
                                            <span v-if="data.item.location === null">
                                            <b-btn @click="setEditModeOn(data.item, 'location')"
                                            v-show="!isInEditMode"
                                            class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                                            </b-btn>
                                            </span>
                                            <b-form v-if="isInEditMode && attributeToUpdate === 'location'">
                                                <b-input-group>
                                                    <b-form-input size="sm"></b-form-input>
                                                    <b-input-group-append>
                                                        <b-button variant="success" size="sm">
                                                            Запази
                                                        </b-button>
                                                        <b-button variant="danger" size="sm"
                                                                  @click="isInEditMode = !isInEditMode">
                                                            Откажи
                                                        </b-button>
                                                    </b-input-group-append>
                                                </b-input-group>
                                            </b-form>
                                            {{ data.item.location }}
                                            </template>
                                            <template slot="[department]" slot-scope="data">
                                                  <span v-if="data.item.department === null">
                                                      <b-btn @click="setEditModeOn(data.item, 'department')"
                                                             v-show="!isInEditMode"
                                                             class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>
                                                      </b-btn>
                                                  </span>
                                                    <b-form v-if="isInEditMode && attributeToUpdate === 'department'">
                                                        <b-input-group>
                                                            <b-form-input size="sm"></b-form-input>
                                                            <b-input-group-append>
                                                                <b-button variant="success" size="sm">
                                                                    Запази
                                                                </b-button>
                                                                <b-button variant="danger" size="sm"
                                                                          @click="isInEditMode = !isInEditMode">
                                                                    Откажи
                                                                </b-button>
                                                            </b-input-group-append>
                                                        </b-input-group>
                                                    </b-form>
                                                    {{ data.item.department }}
                                                </template>
                                            <template slot="[warranty]" slot-scope="data">
                                                <strong>Валидна от:</strong>
                                                {{ data.item.warranty.start }}
                                                <strong>до:</strong>
                                                {{ data.item.warranty.end }}
                                            </template>
                                            <template slot="[purchaseDate]" slot-scope="data">
                                              <span v-if="data.item.purchaseDate === null">
                                                  <b-btn @click="setEditModeOn(data.item, 'purchaseDate')"
                                                         v-show="!isInEditMode"
                                                         class="btn btn-primary btn-sm">
                                                      <i class="fas fa-plus"></i>
                                                  </b-btn>
                                              </span>
                                                <b-form v-if="isInEditMode && attributeToUpdate === 'purchaseDate'">
                                                    <b-input-group>
                                                        <b-form-input size="sm"></b-form-input>
                                                        <b-input-group-append>
                                                            <b-button variant="success" size="sm">
                                                                Запази
                                                            </b-button>
                                                            <b-button variant="danger" size="sm"
                                                                      @click="isInEditMode = !isInEditMode">
                                                                Откажи
                                                            </b-button>
                                                        </b-input-group-append>
                                                    </b-input-group>
                                                </b-form>
                                                {{ data.item.purchaseDate }}
                                            </template>
                                        </b-table>
                                    </b-col>
                                    <b-col cols="6">
                                        <b-form @submit="uploadFile" enctype="multipart/form-data">
                                            <b-form-file v-model="file"></b-form-file>
                                            <b-button variant="success" type="submit">Запази</b-button>
                                        </b-form>
                                        <div class="media" v-for="media in assetInfo.media">
                                            <div v-if="media.media_type === 'image/jpeg'">
                                                <b-img :src="'http://192.168.10.10/' + media.pathToMedia"
                                                       fluid></b-img>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>

                    </b-tab>
                    <b-tab v-if="!loading">
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
                            <component-list :components="assetInfo.components"></component-list>
                        </b-card>
                    </b-tab>
                    <b-tab v-if="!loading">
                        <template slot="title">
                            <i class="fas fa-tools"></i>
                            Сервизна история
                        </template>
                        <div>
<!--                            {{ assetInfo.maintenances }}-->
                            <service-history-table :maintenanceData="[assetInfo]" origin="asset"></service-history-table>
                        </div>
                    </b-tab>
                    <b-tab v-if="!loading">
                        <template slot="title">
                            <i class="fas fa-folder-open"></i>
                            Документи
                        </template>
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
                        label: 'Действия',
                        key: 'actions'
                    },
                ]
            }
        },
        mounted() {
            // console.log();
            axios.get(`/api/assets/${this.$props.id}`)
            .then(
                (data) => {
                    setTimeout(() => {
                        // console.log(data.data.data);
                        this.assetInfo = data.data.data
                        this.loading = !this.loading
                    },100)
                }
            )
        },
        methods: {
            setActiveTab(tb) {
                console.log(this.activeTab)
            },
            setEditModeOn(assetToUpdate, attributeToUpdate) {
                this.isInEditMode = !this.isInEditMode
                this.assetEntity = assetToUpdate
                this.attributeToUpdate = attributeToUpdate
                assetToUpdate[attributeToUpdate] = this.currentAsset[attributeToUpdate];
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
