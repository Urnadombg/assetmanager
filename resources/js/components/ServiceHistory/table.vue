<template>
<div>
    <!--<b-card>-->
        <!--<div slot="header">-->
            <!--<h1>-->
                <!--Сервизна история-->
            <!--</h1>-->
        <!--</div>-->
        <!--<b-card-body>-->
            <b-card footer-bg-variant="light"
                    header-bg-variant="dark">
                <div slot="header">
                    <h2>
                        {{ dataItems.title }}
                        {{ dataItems.model }}
                    </h2>
                    <!--{{ dataItems[0].model }}-->
                </div>

                <!--<b-card-body>-->
                    <!--{{ dataItems.maintenances }}-->
                    <b-table :items="dataItems.maintenances"
                             :fields="assetTableFields"
                             borderd
                             responsive
                             hover
                             striped
                             head-variant="light"
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
                            <!--{{ data.item.maintenance.isWarrantyEvent === 1 ? "DA" : "new" }}-->
                        </template>
                        <template slot="protocolUUID" slot-scope="data">
                            {{ data.item.protocolUUID }}
                        </template>
                        <template slot="title" slot-scope="data">
                            {{ data.item.title }}
                        </template>
                    </b-table>


                <div v-if="assetServiceIssue">
                    <h2>
                        Добавяне на нов сервизен запис
                    </h2>
                    <hr>
                    <b-form-group id="editorData-form-group" label="Описание на проблема" label-for="-input">
                        <ckeditor
                                id="editorData"
                                :editor="editor"
                                v-model="editorData"
                                :config="editorConfig">

                        </ckeditor>
                    </b-form-group>
                </div>

                <div slot="footer">
                    <b-btn variant="primary"
                           style="background-color: mediumblue"
                           @click="assetServiceIssue = !assetServiceIssue"
                           v-if="!assetServiceIssue">
                        <i class="fas fa-plus"></i>
                        Добави нов запис
                    </b-btn>
                    <b-btn variant="warning"
                           @click="assetServiceIssue = !assetServiceIssue"
                           v-if="assetServiceIssue">
                        Отказ
                    </b-btn>
                </div>
                <!--</b-card-body>-->
            </b-card>

            <b-card>
                <div slot="header">
                    <h2>
                        Периферия
                    </h2>
                </div>
                <!--<b-card-body>-->
                    <b-table :items="merged" :fields="componentTableFields" borderd responsive hover striped head-variant="light">
                        <template slot="title" slot-scope="data">
                            {{ data.item }}--
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
                        <template slot="title" slot-scope="data">
                            {{ data.item.title }}
                        </template>
                    </b-table>


                <div v-if="componentServiceIssue">
                    <h2>
                        Добавяне на нов сервизен запис
                    </h2>
                    <hr>
                    <b-form-group id="explanation-form-group" label="Кратко описание на проблема" label-for="explanation-input">
                        <b-form-textarea
                            id="explanation-input"
                            name="explanation-input"
                            aria-describedby="explanation-input-live-feedback"
                            size="lg"
                        ></b-form-textarea>
                    </b-form-group>
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
                <!--</b-card-body>-->
            </b-card>



        <!--</b-card-body>-->
    <!--</b-card>-->
</div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        name: "service-history-table",
        props: ['origin','maintenanceData'],
        data () {
            return {
                calledFrom: null,
                dataItems: [],
                asset_entity: {},
                component_entity: {},
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
                        key:'protocolUUID'
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
        mounted () {
            this.dataItems = this.$props.maintenanceData[0]
            this.$props.maintenanceData.forEach(d => {
                d.maintenances.forEach(assetMaintenance => {
                    // this.merged.push(assetMaintenance)
                })
                d.components.forEach(compo => {
                    compo.maintenances.forEach(mdt => {
                        this.merged.push({
                            title: compo.title,
                            model: compo.model,
                            serial: compo.serial,
                            maintenance: mdt
                        })
                    })
                })
            })
            console.log(this.merged);
        }
    }
</script>

<style scoped>

</style>
