<template>
<div>
<!--    <b-container fluid>-->
    <b-row>
        <b-col cols="12" class="text-capitalize text-lg-center">
            <h1>
                Протокол №
            </h1>
        </b-col>
        <b-col cols="2"></b-col>
    </b-row>
        <b-form-group id="editorData-form-group" label-for="-input">
            <div slot="label">
                <strong>Описание на проблема:</strong>
            </div>
            <ckeditor
                id="editorData"
                :editor="editor"
                v-model="$v.serviceRecord.explanation.$model"
                :state="$v.serviceRecord.explanation.$dirty ? !$v.serviceRecord.explanation.$error : null"
                aria-describedby="serviceRecord.explanation-input-live-feedback"
                :config="editorConfig">
            </ckeditor>


        </b-form-group>
<!--    </b-container>-->
</div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    import {minLength, required, between} from 'vuelidate/lib/validators';
    export default {
        name: "ServiceForm",
        data () {
            return {
                initQuestions: {
                    existingProtocol: false,

                },
                serviceRecord: {
                    asset_id: null,
                    protocolUID: '',
                    component_id: null,
                    isWarrantyEvent: '',
                    explanation: '',
                },
                editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the rich-text editor.
                },
            }
        },
        validations: {
            // if (this.asset_id !== null) {
            //     return {
                serviceRecord: {
                    asset_id: {
                        required
                    },
                    isWarrantyEvent: {
                        required
                    },
                    explanation: {
                        required,
                        // minLenght: minLenght(10)
                        minLength: minLength(10)

                    }
                }
                // }
            // } else {
            //     return {
            //         serviceRecord: {
            //             component_id: {
            //                 required
            //             }
            //         }
            //     }
            // }
            // serviceRecord: {
            //     isWarrantyEvent: {
            //         required
            //     }
            // }
        },

    }
</script>

<style scoped>

</style>
