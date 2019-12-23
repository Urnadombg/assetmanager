<template>
    <div>
        <b-card header-bg-variant="primary" body-bg-variant="white">
            <div slot="header">
                <h1>
                    Добавяне на нов сервизен запис
                </h1>
            </div>
            <b-form @submit.prevent="save">
            <b-form-group id="protocolId-form-group" label="№ на протокола" label-for="protocolId-input">
                <b-form-input
                    id="protocolId-input"
                    name="protocolId-input"
                    v-model.trim="$v.entity.protocolId.$model"
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

                    <b-form-group id="explanation-form-group" label="Описание на проблема / събитието" label-for="explanation-input">
                        <b-textarea
                            id="explanation-input"
                            name="explanation-input"
                            v-model="$v.entity.explanation.$model"
                            :state="$v.entity.explanation.$dirty ? !$v.entity.explanation.$error : null"
                            aria-describedby="explanation-input-live-feedback"
                            rows="8"
                            size="lg"
                        ></b-textarea>
                        <b-form-invalid-feedback id="explanation-input-live-feedback">
                            <div v-if="$v.entity.explanation.$invalid">
                                  <span v-if="$v.entity.explanation.required">
                                    Това поле e задължително и трябва да съдържа минимум {{ $v.entity.explanation.$params.minLength.min }} символа!
                                </span>
                                <span v-if="$v.entity.explanation.minLength">
                                    Това поле трябва да е поне 5 символа!
                                </span>
                            </div>
                        </b-form-invalid-feedback>
                    </b-form-group>
<!--                    <ckeditor-->
<!--                        id="editorData"-->
<!--                        :editor="editor"-->
<!--                        v-model="entity.explanation"-->
<!--                        :config="editorConfig">-->
<!--                    </ckeditor>-->
                </b-col>
                <b-col cols="12"></b-col>
                <b-col cols="12">
                    <b-form-group id="isWarrantyEvent-form-group" label="Гаранционно събитие?" label-for="isWarrantyEvent-input">
                        <b-form-select
                            :options="[{ label: 'Да, гаранционно е събитието', value: true}, { label: 'Не, не е гаранционно', value: false}]"
                            text-field="label"
                            id="isWarrantyEvent-input"
                            name="isWarrantyEvent-input"
                            v-model="$v.entity.isWarrantyEvent.$model"
                            :state="$v.entity.isWarrantyEvent.$dirty ? !$v.entity.isWarrantyEvent.$error : null"
                            aria-describedby="isWarrantyEvent-input-live-feedback"
                            size="lg"
                        ></b-form-select>

                        <b-form-invalid-feedback id="isWarrantyEvent-input-live-feedback">
                            Nevalidno
                        </b-form-invalid-feedback>
                    </b-form-group>
<!--                    <b-form-group id="isWarrantyEvent-form-group" label="Събитието гаранционно ли е?" label-for="isWarrantyEvent-input">-->
<!--                        <b-form-select :options="[{ label: 'Да, гаранционно е събитието', value: true}, { label: 'Не, не е гаранционно', value: false}]"-->
<!--                                       text-field="label"-->
<!--                                       v-model.trim="$v.entity.isWarrantyEvent.$model">-->

<!--                        </b-form-select>-->
<!--&lt;!&ndash;                        <b-form-radio&ndash;&gt;-->
<!--&lt;!&ndash;                            v-model="$v.isWarrantyEvent.$model"&ndash;&gt;-->
<!--&lt;!&ndash;                            :state="$v.isWarrantyEvent.$dirty ? !$v.isWarrantyEvent.$error : null"&ndash;&gt;-->
<!--&lt;!&ndash;                            aria-describedby="isWarrantyEvent-input-live-feedback"&ndash;&gt;-->
<!--&lt;!&ndash;                            size="lg"&ndash;&gt;-->
<!--&lt;!&ndash;                            value="yes"&ndash;&gt;-->
<!--&lt;!&ndash;                        >&ndash;&gt;-->
<!--&lt;!&ndash;                            Да, покрива го гаранцията&ndash;&gt;-->
<!--&lt;!&ndash;                        </b-form-radio>&ndash;&gt;-->

<!--&lt;!&ndash;                        <b-form-radio&ndash;&gt;-->
<!--&lt;!&ndash;                            v-model="$v.isWarrantyEvent.$model"&ndash;&gt;-->
<!--&lt;!&ndash;                            :state="$v.isWarrantyEvent.$dirty ? !$v.isWarrantyEvent.$error : null"&ndash;&gt;-->
<!--&lt;!&ndash;                            aria-describedby="isWarrantyEvent-input-live-feedback"&ndash;&gt;-->
<!--&lt;!&ndash;                            value="no"&ndash;&gt;-->
<!--&lt;!&ndash;                            size="lg"&ndash;&gt;-->
<!--&lt;!&ndash;                        >&ndash;&gt;-->
<!--&lt;!&ndash;                            Не, не е гаранционно събитие&ndash;&gt;-->
<!--&lt;!&ndash;                        </b-form-radio>&ndash;&gt;-->
<!--                        <b-form-invalid-feedback id="isWarrantyEvent-input-live-feedback">-->
<!--                            Моля, отбележи-->
<!--                        </b-form-invalid-feedback>-->
<!--                    </b-form-group>-->
                </b-col>
                <b-col cols="6">
                    <b-button block variant="primary" @click="save()">Запиши!</b-button>
                </b-col>
                <b-col cols="6">
                    <b-button block variant="danger">Откажи!</b-button>
                </b-col>
            </b-row>
            </b-form>
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
            entity: {
                protocolId: {
                    required
                },
                // perform_on: {
                //     required
                // },
                isWarrantyEvent: {
                    required
                },
                // status: {
                //     required
                // },
                explanation: {
                    required,
                    minLength: minLength(5)
                }
            }
        },
        mounted() {
           this.getProtocolId();
            if (this.$props.origin === 'asset') {
                // if (this.$props.assets.warranty)
                console.log("SH", this.$props)
                setTimeout(() => {
                    this.entity.asset = this.$props.assets
                    // this.entity.component = this.entity.asset.components
                    // console.log(Object.keys(this.entity))c
                    // console.log("set", this.entity)

                },70)
            } else if (this.$props.origin === 'component') {
                this.entity.component = this.$props.assets.components
            }
        },
        methods: {
            save() {
                this.$v.entity.$touch()
                if (this.$v.entity.$invalid) {
                    this.$bvToast.toast("Формата за запис на ново сервизно събитие е невалидна!",{
                        title: "Не мога да запиша формата",
                        toaster: "b-toaster-top-full",
                        variant: "danger"
                    })
                } else {
                    console.log(this.entity)
                    // axios.post('/api/maintenances', this.entity)
                    //     .then(
                    //         (data) => {
                    //             this.$bvToast.show('assetSaved');
                    //             this.$root.$emit('bv::refresh::table', 'assetMaintenanceTable')
                    //             // console.log("data", data.data)
                    //             this.$emit('refreshTable', this.entity);
                    //         }
                    //     )
                    //     .catch(
                    //         (er) => {
                    //             console.log(er)
                    //         }
                    //     )
                }

            },
            getProtocolId() {
                axios.get('/api/maintenances/getRmaNumber')
                    .then(
                        (data) => {
                            if  (data.data.length < 0) {
                                alert("NEE");
                            }
                            else {
                                this.entity.protocolId = data.data
                            }
                        }
                    )
            }
        }
    }
</script>

<style scoped>

</style>
