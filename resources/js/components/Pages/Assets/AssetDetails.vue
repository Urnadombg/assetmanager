<template>
    <b-container fluid>
        <b-card
                header-bg-variant="dark"
                header-text-variant="white"
                text-variant="black"
                body-bg-variant="white">
            <div slot="header">
                <h1>
                    {{ assetInfo[0].title }}
                    {{ assetInfo[0].model }}
                </h1>
                <b-row>
                    <b-col cols="1">
<!--                        Сериен № <strong>{{ assetInfo[0].serial < 0 ? 'Добави': assetInfo[0].serial }}</strong>-->
                    </b-col>
                    <b-col>
<!--                        Клиент: <strong> {{ assetInfo[0].customer.name }} {{ assetInfo[0].customer.lastname }}</strong>-->
                    </b-col>
                </b-row>
            </div>
<!--            <b-card-body>-->
                <b-container fluid>
                    <b-tabs fill card >
                        <b-tab title-item-class="theclass">
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
                                          <b-table :items="assetInfo"
                                                   :fields="assetDetailsFields"
                                                   small caption-top stacked>
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
                                                          <b-form-input size="sm" v-model="currentAsset.serial"></b-form-input>
                                                          <b-input-group-append>
                                                              <b-button variant="success" size="sm" @click="isInEditMode = !isInEditMode">
                                                                  Запази
                                                              </b-button>
                                                              <b-button variant="danger" size="sm" @click="isInEditMode = !isInEditMode">
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
                                                              <b-button variant="danger" size="sm" @click="isInEditMode = !isInEditMode">
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
                                                              <b-button variant="danger" size="sm" @click="isInEditMode = !isInEditMode">
                                                                  Откажи
                                                              </b-button>
                                                          </b-input-group-append>
                                                      </b-input-group>
                                                  </b-form>
                                                  {{ data.item.department }}
                                              </template>
                                              <template slot="[purchaseDate]" slot-scope="data">
                                                  <span v-if="data.item.purchaseDate === null">
                                                      <b-btn @click="setEditModeOn(data.item, 'purchaseDate')"
                                                             v-show="!isInEditMode"
                                                             class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></b-btn>
                                                  </span>
                                                  <b-form v-if="isInEditMode && attributeToUpdate === 'purchaseDate'">
                                                      <b-input-group>
                                                          <b-form-input size="sm"></b-form-input>
                                                          <b-input-group-append>
                                                              <b-button variant="success" size="sm">
                                                                  Запази
                                                              </b-button>
                                                              <b-button variant="danger" size="sm" @click="isInEditMode = !isInEditMode">
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
                                          <div v-for="image in assetMedia">
<!--                                              <b-img fluid :src="'http://192.168.10.10/' + image.pathToMedia"></b-img>-->
<!--                                              <img :src="'http://192.168.10.10/' + image.pathToMedia">-->
                                          </div>
                                      </b-col>
                                  </b-row>
                              </b-card-body>
                            </b-card>

                        </b-tab>
                        <b-tab title="Компоненти" title-item-class="theclass">
                            <template slot="title">
                                <i class="fas fa-cogs"></i>
                                Компоненти
                            </template>
                            <b-card>
                                <div slot="header">
                                    <h1>Компоненти</h1>
                                </div>
                                <b-table :items="assetComponents" small hover :fields="componentFields">
                                    <template slot="[num]" slot-scope="data">
                                        {{ data.index +1}}
                                    </template>
                                    <template slot="[actions]">
                                        <b-btn-group>
                                            <b-btn>dder</b-btn>
                                            <b-btn>dder</b-btn>
                                            <b-btn>dder</b-btn>
                                        </b-btn-group>
                                    </template>
                                </b-table>
                            </b-card>
                        </b-tab>
                        <b-tab title="Профилактики" title-item-class="theclass">
                            <template slot="title">
                                <i class="fas fa-tools"></i>
                                Профилактики
                            </template>
                        </b-tab>
                        <b-tab title="Документи" title-item-class="theclass">
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

    export default {
        props: ['id'],
        name: "AssetDetails",
        data (){
            return {
                assetInfo: [],
                assetMedia: [],
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
            axios.get(`/api/assets/${this.$props.id}`)
                .then(
                    (data) => {
                        // console.log(data)
                        this.assetInfo = data.data
                        this.assetMedia = data.data[0].media
                        this.assetComponents = data.data[0].components
                    }
                )
        },
        methods: {
            setEditModeOn(assetToUpdate, attributeToUpdate) {
                this.isInEditMode = !this.isInEditMode
                this.assetEntity = assetToUpdate
                this.attributeToUpdate = attributeToUpdate
                assetToUpdate[attributeToUpdate] = this.currentAsset[attributeToUpdate];
            },
            updateAsset() {

            }
        }
    }
</script>

<style>
.theclass {
    background-color: #071b28;
    margin-right: 5px;
    border-radius: 0px 0px 0px 0px;
    color: #fff;
    border-bottom: 3px solid #9ed861;
}
    .theclass a {
        font-weight: bold;
        border-radius: 0px 0px 0px 0px;

        color: #fff;
    }
</style>
