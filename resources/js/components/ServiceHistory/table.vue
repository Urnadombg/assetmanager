<template>
<div>
    <b-btn v-b-modal.modal-lg variant="primary">
        open
    </b-btn>
    <b-modal id="modal-lg" size="lg" :title="`Добавяне на нов сервизен запис към ${dataItems.title} ${dataItems.model},${dataItems.serial}`">
        <create-new-case-form></create-new-case-form>
    </b-modal>
        <b-card footer-bg-variant="light"
                header-bg-variant="dark">
             <b-container fluid>
                 <b-button-group>
                     <b-dropdown variant="outline-primary" text="Добави">
                         <div slot="text">
                             <i class="fas fa-plus"></i>
                             Добави
                         </div>
                         <b-dropdown-item @click="addIssueToAsset">Ново събитие</b-dropdown-item>
                     </b-dropdown>
                 </b-button-group>
             </b-container>
            <create-new-case-form :assets="dataItems"
                                  :origin="'asset'"
                                  v-show="assetServiceIssue">
            </create-new-case-form>
            <hr>
<!--            {{ dataItems.maintenances }}-->
                <b-table :items="dataItems.maintenances"
                         :fields="assetTableFields"
                         borderd
                         ref="tata"
                         responsive
                         hover
                         selectable
                         striped
                         head-variant="light"
                         @row-clicked="expandAdditionalInfo"
                         show-empty>
                    <template slot="title" slot-scope="data">
                        {{ data.item.title }}
                    </template>
                    <template v-slot:empty="scope">
                        <h4 class="text-center">Няма записи!</h4>
                        <br>
                        <b-btn block>Добави нов сервизен запис</b-btn>
                    </template>
                    <template slot="isWarrantyEvent" slot-scope="data">
                        <span v-if="data.item.isWarrantyEvent === 1" style="color: green;">
                            <i class="fas fa-check"></i>
                        </span>
                        <span v-if="data.item.isWarrantyEvent !== 1" style="color: red;">
                            <i class="fas fa-times"></i>
                        </span>
                    </template>
                    <template slot="status" slot-scope="data">
                        <span v-if="data.item.status === 0"><i class="fas fa-file"></i>Нов</span>
                        <span v-if="data.item.status === 1">В процес на разрешаване!</span>
                        <span v-if="data.item.status === 2">Затворен</span>
                        <span v-if="data.item.status === 3"></span>
                        <div v-show="statusEditing" :key="data.item.status">
                            {{ data.item.id }}
                            <b-form-select v-model="data.item.status" :options="statusOptions">
                            </b-form-select>
                            <b-btn @click="changeCaseStatus(data.item)">
                                Запази
                            </b-btn>
                        </div>
                        <b-btn variant="info" clsas="text-rigth" @click="statusEditing = !statusEditing">Промени</b-btn>
                    </template>
                    <template slot="protocolId" slot-scope="data">
                        {{ data.item.protocolNumber }}
                    </template>
                    <template slot="title" slot-scope="data">
                        <span v-if="data.item.pivot.asset_id === dataItems.id">
                            {{ dataItems.title }}
                        </span>
                    </template>
                    <template slot="model" slot-scope="data">
                        <span v-if="data.item.pivot.asset_id === dataItems.id">
                            {{ dataItems.model }}
                        </span>
                    </template>
                    <template slot="serial" slot-scope="data">
                        {{ dataItems.serial }}
                    </template>
                    <template slot="row-details" slot-scope="row">
                        <b-card>
                            <h1>Подробности за сервизното събитие</h1>
                            {{ row.item }}
                            <div slot="footer">
                                footer
                            </div>
                        </b-card>
                    </template>
                    <template slot="actions" slot-scope="data">
                        <b-dropdown right text="Menu">
                            <b-dropdown-item>Item 1</b-dropdown-item>
                            <b-dropdown-item>Item 2</b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item>Item 3</b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
            <div v-if="assetServiceIssue">
            </div>

            <div slot="footer">
            </div>
        </b-card>
        <b-card>
            <div slot="header">
                <h2>
                    Периферия
                </h2>
            </div>
<!--            {{ dataItems.components}}-->
                <b-table :items="merged" ref="far"
                         :fields="componentTableFields"
                         @row-clicked="expandAdditionalInfo"
                         borderd
                         hover
                         selectable
                         striped
                         head-variant="light"
                         show-empty>
                    <template v-slot:cell(title)="row">
                        {{ row.item.com.title }} {{ row.item.com.model }}
                    </template>
                    <template v-slot:cell(serial)="row">
                        {{row.item.com.serial}}
                    </template>
                    <template v-slot:cell(maintenance.perform_on)="row">
                        {{row.item.perform_on}}
                    </template>
                    <template v-slot:cell(maintenance.explanation)="row">
                        {{row.item.explanation}}
                    </template>
                    <template v-slot:empty="scope">
                        <h4 class="text-center">Няма записи!</h4>
                        <br>
                        <b-btn block>Добави нов сервизен запис</b-btn>
                    </template>
                    <template slot="row-details" slot-scope="row">
                        <b-card>
                            <h1>Подробности за сервизното събитие</h1>
                            {{ row.item }}
                            <div slot="footer">
                                footer
                            </div>
                        </b-card>
                    </template>
                    <template slot="maintenance.protocolUUID" slot-scope="data">
                        {{ data.item.maintenance.protocolUUID }}
                    </template>
                </b-table>
            <div slot="footer">
                <b-btn variant="primary"
                       style="background-color: mediumblue"
                       @click="componentServiceIssue = !componentServiceIssue"
                       v-if="!componentServiceIssue">
                    <i class="fas fa-plus"></i>
                    Добавяне на нов сервизен запис
                </b-btn>
                <b-btn variant="warning"
                       @click="componentServiceIssue = !componentServiceIssue"
                       v-if="componentServiceIssue">
                    Отказ
                </b-btn>
            </div>

        </b-card>

</div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import ServiceForm from "./ServiceForm";
    import CreateNewCaseForm from "./CreateNewCaseForm";

    export default {
        name: "service-history-table",
        components: {CreateNewCaseForm, ServiceForm},
        props: ['origin','maintenanceData'],
        data () {
            return {
                calledFrom: null,
                dataItems: [],
                componentMaintenanceData: [],
                addAssetIssue: false,
                addComponentIssue: false,
                merged: [],
                componentTableFields: [
                    {
                        label: '№ на протокола',
                        key:'maintenance.protocolUUID'
                    },
                    {
                        label: 'Наименование на изделието',
                        key:'title'
                    },
                    {
                        label: 'Сериен № на изделието',
                        key:'serial'
                    },
                    {
                        label: 'Сервизно събитие от',
                        key:'maintenance.perform_on'
                    },
                    {
                        label: 'Статус',
                        key: 'status'
                    },
                    {
                        label: 'Гаранционно събитие',
                        key:'maintenance.isWarrantyEvent'
                    },
                    {
                        label: 'Кратко обяснение',
                        key:'maintenance.explanation'
                    }

                ],
                componentServiceIssue: false,
                assetServiceIssue: false,
                assetTableFields: [
                    {
                        label: '№ на протокола',
                        key:'protocolId'
                    },
                    // {
                    //     label: 'Наименование на изделието',
                    //     key:'title'
                    // },
                    // {
                    //     label: 'Модел на изделието',
                    //     key:'model'
                    // },
                    // {
                    //     label: 'Сериен № на изделието',
                    //     key:'serial'
                    // },
                    {
                        label: 'Сервизно събитие от',
                        key:'perform_on'
                    },
                    {
                        label: 'Статус',
                        key: 'status'
                    },
                    {
                        label: 'Гаранционно събитие',
                        key:'isWarrantyEvent'
                    },
                    {
                        label: 'Кратко обяснение',
                        key:'explanation'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    }

                ],
                tableFields: [
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
                statusOptions: [
                    {
                        value: 0,
                        text: 'Нов'
                    },
                    {
                        value: 1,
                        text: 'В процес на разрешаване!'
                    },
                    {
                        value: 2,
                        text: 'Затворен'
                    },

                ],
                statusEditing: false,
            }
        },
        created() {
            this.$on('refreshTable', function(data){
                this.logs(data)
                // console.log("refreshing")
            });
        },
        mounted () {
            this.dataItems = this.$props.maintenanceData
            this.getComponentServiceHistory();
            // console.log(this.$props)
        },
        methods: {
            getComponentServiceHistory() {
             let componentHist = []
              return this.dataItems.components.forEach(cop => {
                   cop.maintenances.forEach((maint, index) => {
                       axios.get(`/api/components/${maint.pivot.component_id}`)
                           .then(
                               (data) => {
                                   maint['com'] = data.data
                                   this.merged.push(maint);
                               }
                           )

                   })
                  return this.merged || [];
              })
            },
            addIssueToAsset() {
              this.addAssetIssue = true
            },
            getData() {
                axios.get(`/assets/${this.$props.maintenanceData.id}`)
                    .then(
                        (data) => {
                            // console.log("DAAA", data.data[0])
                            this.dataItems = data.data[0]
                        }
                    )
            },
            expandAdditionalInfo(row) {
                row._showDetails = !row._showDetails
            },
            rowSelected(te){
                console.log(te)
            },
            changeCaseStatus(serviceCase) {
                axios.patch(`/api/maintenances/${serviceCase.id}/setStatus`, { status: serviceCase.status} )
                    .then(
                        (data) => {
                            console.log(data)
                        }
                    )
                    .catch(
                        (error) => {
                            console.log(error)
                        }
                    )
                this.statusEditing = false
            },
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
