<template>
    <div>
        <b-card header-bg-variant="primary" body-bg-variant="white">
            <div slot="header">
                <h1>
                    Добавяне на нов сервизен запис
                </h1>
            </div>

            <b-form-group id="protocolId-form-group" label="№ на протокола" label-for="protocolId-input">
                <b-form-input
                    id="protocolId-input"
                    name="protocolId-input"
                    v-model="entity.protocolId"
                    disabled
                    size="lg"
                ></b-form-input>
            </b-form-group>
            <b-row>
                <b-col cols="12">
                    <h2>
                        {{ entity.asset.title }} {{ entity.asset.model }}
                    </h2>
                    <span>
                    Сериен № {{ entity.asset.serial }}
                </span>
<!--                    {{ typeof entity.component }}-->
<!--                    <multiselect :options="entity.component" v-model="entity.asset" label="title"></multiselect>-->
                </b-col>
                <b-col>
                    <h4>
                        Описание на проблема:
                    </h4>
                    <ckeditor
                        id="editorData"
                        :editor="editor"
                        v-model="entity.explanation"
                        :config="editorConfig">
                    </ckeditor>
                </b-col>
                <b-col cols="12"></b-col>
                <b-col cols="12">
                    <b-form-group id="isWarrantyEvent-form-group" label="Събитието гаранционно ли е?" label-for="isWarrantyEvent-input">
                        <b-form-select :options="[{ label: 'Да, гаранционно е събитието', value: true}, { label: 'Не, не е гаранционно', value: false}]"
                                       text-field="label"
                                       v-model="entity.isWarrantyEvent">

                        </b-form-select>
<!--                        <b-form-radio-->
<!--                            v-model="$v.isWarrantyEvent.$model"-->
<!--                            :state="$v.isWarrantyEvent.$dirty ? !$v.isWarrantyEvent.$error : null"-->
<!--                            aria-describedby="isWarrantyEvent-input-live-feedback"-->
<!--                            size="lg"-->
<!--                            value="yes"-->
<!--                        >-->
<!--                            Да, покрива го гаранцията-->
<!--                        </b-form-radio>-->

<!--                        <b-form-radio-->
<!--                            v-model="$v.isWarrantyEvent.$model"-->
<!--                            :state="$v.isWarrantyEvent.$dirty ? !$v.isWarrantyEvent.$error : null"-->
<!--                            aria-describedby="isWarrantyEvent-input-live-feedback"-->
<!--                            value="no"-->
<!--                            size="lg"-->
<!--                        >-->
<!--                            Не, не е гаранционно събитие-->
<!--                        </b-form-radio>-->
                        <b-form-invalid-feedback id="isWarrantyEvent-input-live-feedback">
                            Моля, отбележи
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-button block variant="primary" @click="save()">Запиши!</b-button>
                </b-col>
                <b-col cols="6">
                    <b-button block variant="danger">Откажи!</b-button>
                </b-col>
            </b-row>

        </b-card>

        <b-toast id="assetSaved" variant="success" solid>
            <template v-slot:toast-title>
                <div class="d-flex flex-grow-1 align-items-baseline">
                    <b-img blank blank-color="#ff5555" class="mr-2" width="12" height="12"></b-img>
                    <strong class="mr-auto">Notice!</strong>
                    <small class="text-muted mr-2">42 seconds ago</small>
                </div>
            </template>
            This is the content of the toast.
            It is short and to the point.
        </b-toast>

    </div>
</template>

<script>
    import { required, minLength} from 'vuelidate/lib/validators'
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        name: "CreateNewCaseForm",
        props: ['assets', 'origin'],
        data (){
            return {

                entity: {
                    chooseProtocol: false,
                    protocolId:'',
                    perform_on: '',
                    isWarrantyEvent: '',
                    status: 1,
                    explanation: '',
                    asset: '',
                    component: '',
                },

                editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the rich-text editor.
                },
            }
        },
        validations: {
            protocolId: {
                required
            },
            perform_on: {
                required
            },
            isWarrantyEvent: {
                required
            },
            status: {
                required
            },
            explanation: {
                required,
                minLength: minLength(10)
            }
        },
        mounted() {
           this.getProtocolId();
            if (this.$props.origin === 'asset') {
                // if (this.$props.assets.warranty)
                setTimeout(() => {
                    this.entity.asset = this.$props.assets
                    // this.entity.component = this.entity.asset.components
                    // console.log(Object.keys(this.entity))

                },70)
            } else if (this.$props.origin === 'component') {
                this.entity.component = this.$props.assets.components
            }
        },
        methods: {
            save() {

                // console.log(this.entity)
                axios.post('/api/maintenances', this.entity)
                    .then(
                        (data) => {
                            console.log(data)
                            // this.$bvToast.show('assetSaved');
                            // this.$root.$emit('bv::refresh::table', 'assetMaintenanceTable')
                            // console.log(data.data)
                            this.$emit('refreshTable', this.entity);
                        }
                    )
                    .catch(
                        (er) => {
                            console.log(er)
                        }
                    )
            },
            getProtocolId() {
                axios.get('/api/maintenances/getRmaNumber')
                    .then(
                        (data) => {
                            if  (data.data.length < 0) {
                                alert("NEE");
                            }
                            this.entity.protocolId = data.data
                        }
                    )
            }
        }
    }
</script>

<style scoped>

</style>
