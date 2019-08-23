<template>
    <b-container fluid>
        <h1>
            Детайли
        </h1>
        <b-card bg-variant="info"
                header-bg-variant="info"
                header-text-variant="white"
                text-variant="black"
                body-bg-variant="white">
            <div slot="header">
                <h1>
                    {{ assetInfo.title }}
                    {{ assetInfo.model }}
                </h1>
                <b-row>
                    <b-col cols="1">
                        Сериен № <strong>{{ assetInfo.serial }}</strong>
                    </b-col>
                    <b-col>
                        Клиент: <strong> {{ assetInfo.customer }}</strong>
                    </b-col>
                </b-row>
            </div>
<!--            <b-card-body>-->
                <b-container fluid>
                    <b-tabs fill card>
                        <b-tab title="Детайли" title-item-class="theclass">
                            <b-card>
                                <div slot="header">
                                    <h1>Детайли</h1>
                                </div>
                              <b-card-body>
                                  <b-row>
                                      <b-cols>
                                          <b-col cols="6">
                                              <b-table :items="assetInfo"
                                                       :fields="assetDetailsFields"
                                                       small caption-top stacked>
                                              </b-table>
                                          </b-col>
                                          <b-col cols="6">
                                              Lorem ipsum dolor sit amet,
                                              consectetur adipisicing elit. Ab alias consequuntur,
                                              dignissimos facilis fuga harum id ipsam laborum maxime nesciunt
                                              reprehenderit similique sit vel vero, voluptatem. Beatae delectus numquam sapiente.
                                          </b-col>
                                      </b-cols>
                                  </b-row>
                              </b-card-body>
<!--                                {{ assetInfo }}-->
                            </b-card>
                        </b-tab>
                        <b-tab title="Компоненти" title-item-class="theclass">
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
                        <b-tab title="Профилактики" title-item-class="theclass"></b-tab>
                        <b-tab title="Документи" title-item-class="theclass"></b-tab>
                    </b-tabs>
                </b-container>
<!--            </b-card-body>-->
        </b-card>
    </b-container>
</template>

<script>
    export default {
        props: ['id'],
        name: "AssetDetails",
        data (){
            return {
                assetInfo: [],
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
                        console.log(data.data)
                        this.assetInfo = data.data
                        this.assetComponents = data.data[0].components
                    }
                )
        }
    }
</script>

<style>
.theclass {
    background-color: #1b4b72;
    border-radius: 5px 5px 0px 0px;
    color: #fff;
}
    .theclass a {
        font-weight: bold;
        color: #fff;
    }
</style>
