<template>
<div>
        <b-card footer-bg-variant="light"
                header-bg-variant="dark">
            <div slot="header">
                <h2>
                    {{ dataItems.title }}
                    {{ dataItems.model }}
                </h2>
            </div>
             <b-button-group>
                 <b-dropdown variant="outline-primary" text="Добави">
                     <div slot="text">
                         <i class="fas fa-plus"></i>
                         Добави
                     </div>
                     <b-dropdown-item @click="addAssetIssue = true">Ново събитие</b-dropdown-item>
<!--                     <b-dropdown-item href="#novo">Ново събитие към съществуващ протокол</b-dropdown-item>-->
                 </b-dropdown>
             </b-button-group>

<!--            <create-new-case-form :assets="dataItems" :origin="'asset'" v-show="!addAssetIssue" v-on:refreshTable="logs"></create-new-case-form>-->
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
                    <template slot="title" slot-scope="data">
                        {{ data.item.title }}
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
                        <span v-if="data.item.status === 2"></span>
                        <span v-if="data.item.status === 3"></span>
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
                            <h1>hello</h1>
                            {{ row.item }}
                        </b-card>
                    </template>
                </b-table>
            <b-button @click="logs">manual refres</b-button>
            <div v-if="assetServiceIssue">
                <h2>
                    Добавяне на нов сервизен запис
                </h2>
                <hr>
                <service-form></service-form>
            </div>

            <div slot="footer">
                <b-button-group>
                    <b-dropdown block text="Menu">
                        <b-dropdown-item>Добави ново събитие</b-dropdown-item>
                        <b-dropdown-item>Добави събитие към съществуващ протокол</b-dropdown-item>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item>Item 3</b-dropdown-item>
                    </b-dropdown>
                </b-button-group>
            </div>
        </b-card>

        <b-card>
            <div slot="header">
                <h2>
                    Периферия
                </h2>
            </div>
            <b-row>
                <create-new-case-form :assets="dataItems" :origin="'component'" v-show="addAssetIssue"></create-new-case-form>

            </b-row>
                <b-table :items="merged" ref="far"
                         :fields="componentTableFields"
                         @row-selected="rowSelected"
                         borderd
                         responsive
                         hover
                         selectable
                         striped
                         head-variant="light"
                         show-empty>
                    <template slot="title" slot-scope="data">
                        {{ data.item.title }}
                        {{ data.item.model }}
                    </template>
                    <template slot="maintenance.isWarrantyEvent" slot-scope="data">
                        <span v-if="data.item.maintenance.isWarrantyEvent === 1" style="color: green;">
                            <i class="fas fa-check"></i>
                        </span>
                        <span v-if="data.item.maintenance.isWarrantyEvent !== 1" style="color: red;">
                            <i class="fas fa-times"></i>
                        </span>
                        <!--{{ data.item.maintenance.isWarrantyEvent === 1 ? "DA" : "new" }}-->
                    </template>
                    <template slot="maintenance.protocolUUID" slot-scope="data">
                        {{ data.item.maintenance.protocolUUID }}
                    </template>
                </b-table>


            <div v-if="componentServiceIssue">
                <h2>
                    Добавяне на нов сервизен запис
                </h2>
                <hr>
                <service-form></service-form>
            </div>


            <div slot="footer">
                <b-btn variant="primary"
                       style="background-color: mediumblue"
                       @click="componentServiceIssue = !componentServiceIssue"
                       v-if="!componentServiceIssue">
                    <i class="fas fa-plus"></i>
                    Добави нов запис
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
                editor: ClassicEditor,
                editorData: '<p>Rich-text editor content.</p>',
                editorConfig: {
                    // The configuration of the rich-text editor.
                },
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
                        label: 'Модел на изделието',
                        key:'model'
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
                    {
                        label: 'Наименование на изделието',
                        key:'title'
                    },
                    {
                        label: 'Модел на изделието',
                        key:'model'
                    },
                    {
                        label: 'Сериен № на изделието',
                        key:'serial'
                    },
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
            }
        },
        created() {
            this.$on('refreshTable', function(data){
                this.logs(data)
                // console.log("refreshing")
            });
        },
        mounted () {
            // this.dataItems = this.$props.maintenanceData[0]
            // setTimeout(() => {
            //     this.$props.maintenanceData.forEach(d => {
            //         d.maintenances.forEach(assetMaintenance => {
            //             // this.merged.push(assetMaintenance)
            //         })
            //         d.components.forEach(compo => {
            //             compo.maintenances.forEach(mdt => {
            //                 this.merged.push({
            //                     title: compo.title,
            //                     model: compo.model,
            //                     serial: compo.serial,
            //                     maintenance: mdt
            //                 })
            //                 this.componentMaintenanceData.push(mdt)
            //             })
            //         })
            //     })
            // },0)
            // axios.get(`/assets/${this.$props.id}`)
            this.getData();
        },
        methods: {
            getData() {
                axios.get(`/assets/${this.$props.id}`)
                    .then(
                        (data) => {
                            this.dataItems = data.data
                        }
                    )
            },
            logs(data) {
                // this.dataItems.maintenances.push(data)

                // this.$root.$emit('bv::refresh::table', 'tata')
                // this.$refs.tata.refresh()
                // console.log("LogData", data)
            },
            expandAdditionalInfo(row) {
                row._showDetails = !row._showDetails
            },
            rowSelected(te){
                console.log(te)
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
