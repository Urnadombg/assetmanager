<template>
<div>
    <b-card footer-bg-variant="light"
                header-bg-variant="dark">
             <b-container fluid>

                 <b-button-group>
                     <b-dropdown variant="outline-primary" text="Добави">
                         <div slot="text">
                             <i class="fas fa-plus"></i>
                             Добави
                         </div>
                         <b-dropdown-item v-b-modal.assetServiceRecord>Ново събитие</b-dropdown-item>
                     </b-dropdown>
                 </b-button-group>
             </b-container>
            <hr>
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
                    <template v-slot:cell(protocolId)="row">
                        {{ `SC-${String(row.item.id).padStart(10, '0')}` }}

                    </template>
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
                    <template slot="actions" slot-scope="data">
                        <b-dropdown right text="Menu">
                            <b-dropdown-item>Item 1</b-dropdown-item>
                            <b-dropdown-item>Item 2</b-dropdown-item>
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item>Item 3</b-dropdown-item>
                        </b-dropdown>
                    </template>
                    <template slot="row-details" slot-scope="row">
                            <div v-if="row.item.isWarrantyEvent === 0">
                                <b-card header-bg-variant="danger" header-text-variant="white">
                                    <div slot="header">
                                        <b-row>
                                            <b-col cols="10">
                                                <h1>Подробности за сервизното събитие</h1>
                                            </b-col>
                                            <b-col>
                                                <b-badge variant="warning" v-if="row.item.status === 1">
                                                    <h4>В процес на разрешаване!</h4>
                                                </b-badge>
                                                <b-badge variant="success" v-if="row.item.status === 2">
                                                    <h4>Разрешен!</h4>
                                                </b-badge>
                                            </b-col>
                                            <b-col class="text-right">
                                                <b-form-select v-model="row.item.status" :options="statusOptions"></b-form-select>
                                            </b-col>
                                        </b-row>
                                    </div>
                                    <br>

                                    <span>
                                    Сервизното събитие е създадено на <strong>{{ row.item.created_at }}, {{ $moment(row.item.created_at).fromNow() }}</strong>
                                    <span v-if="!row.item.updated_at === row.item.created_at">
                                        (последно обновен на {{ row.item.updated_at === row.item.created_at }})
                                    </span>
                                 </span>
                                    <br>

                                    <span>
                                    <strong>
                                        Обяснение към сервизното събитие:
                                    </strong>
                                </span>

                                    <p style="background-color: lightslategray; color: white; border-radius: 10px; padding: 25px;">
                                        {{ row.item.explanation }}
                                    </p>
                                    <hr />
                                    <br>
                                    {{ row.item }}
                                    <div slot="footer" class="text-center alignt-center">
                                        <b-btn-group >
                                            <b-btn variant="info">
                                                <i class="fa fa-print"></i>
                                                Разпечатай текущия протокол
                                            </b-btn>
                                            <b-btn variant="danger">
                                                <i class="fa fa-pen"></i>
                                                Редактирай
                                            </b-btn>
                                            <b-btn variant="info" :click="addNoteToMaintenance(row.item)">
                                                <i class="fa fa-plus"></i>
                                                Добави бележка
                                            </b-btn>
                                            <b-btn variant="primary">
                                                <i class="fa fa-envelope"></i>
                                                Изпрати по имейл на клиента
                                            </b-btn>
                                        </b-btn-group>
                                    </div>
                                </b-card>
                            </div>
                            <div v-else>
                                <div>
                                    <b-card header-bg-variant="warning" header-text-variant="white">
                                        <div slot="header">
                                            <h1>Подробности за сервизното събитие</h1>
                                        </div>
                                        <!--{{ row.item }}-->
                                        <span>
                                        Сервизното събитие е създадено на <strong>{{ row.item.created_at }}</strong>
                                        <span v-if="!row.item.updated_at === row.item.created_at">
                                            (последно обновен на {{ row.item.updated_at === row.item.created_at }})
                                        </span>
                                     </span>
                                        <br>
                                        <span>
                                        <strong>
                                            Обяснение към сервизното събитие:
                                        </strong>
                                    </span>
                                        <p style="background-color: lightslategray; color: white; border-radius: 10px; padding: 25px;">
                                            {{ row.item.explanation }}
                                        </p>
                                        <hr />
                                        <p>
                                            <span v-if="row.item.status === 0"><i class="fas fa-file"></i>Нов</span>
                                            <span v-if="row.item.status === 1" class="text-warning">В процес на разрешаване!</span>
                                            <span v-if="row.item.status === 2">Затворен</span>
                                            <span v-if="row.item.status === 3"></span>
                                        </p>
                                        <br>
                                        <b-card v-for="(note,index ) in row.item.notes"
                                                :key="row.item.id" :bg-variant="index % 2 !== 0 ? 'info' : 'warning'">
                                            <b-card-body >
                                                <b-row>
                                                    <b-col cols="2">
                                                        <i class="fa fa-sticky-note fa-4x"></i>
                                                    </b-col>
                                                    <b-col>
                                                        <!--Бележка от {{ row.item.created_at | moment().fromNow()}}-->
                                                        {{ note }}
                                                    </b-col>
                                                </b-row>
                                            </b-card-body>
                                            <br>
                                        </b-card>
                                        <div slot="footer" class="text-center alignt-center">
                                            <b-btn-group >
                                                <b-btn variant="info">
                                                    <i class="fa fa-print"></i>
                                                    Разпечатай текущия протокол
                                                </b-btn>
                                                <b-btn variant="danger">
                                                    <i class="fa fa-pen"></i>
                                                    Редактирай
                                                </b-btn>
                                                <b-btn variant="info">
                                                    <i class="fa fa-plus"></i>
                                                    Добави бележка
                                                </b-btn>
                                                <b-btn variant="primary">
                                                    <i class="fa fa-envelope"></i>
                                                    Изпрати по имейл на клиента
                                                </b-btn>
                                            </b-btn-group>
                                        </div>
                                    </b-card>
                                </div>
                            </div>
                    </template>

                </b-table>
        </b-card>
         <br>
        <b-card>
            <div slot="header">
                <h2>
                    Периферия123
                </h2>
            </div>
                <b-table :items="merged" ref="far"
                         :fields="componentTableFields"
                         @row-clicked="expandAdditionalInfo"
                         borderd
                         hover
                         selectable
                         striped
                         head-variant="light"
                         show-empty>
                    <template v-slot:cell(maintenance.id)="row">
                        {{ `SC-${String(row.item.id).padStart(10, '0')}` }}
                    </template>
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
                        key:'maintenance.id'
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
            this.$moment().locale('bg')
        },
        mounted () {
            this.dataItems = this.$props.maintenanceData
            this.getComponentServiceHistory();
            // console.log(this.$props)
        },
        methods: {
            addNoteToMaintenance(item) {
              console.log("DASD")
            },
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
