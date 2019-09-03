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
                v-model="editorData"
                :config="editorConfig">

            </ckeditor>
        </b-form-group>
<!--    </b-container>-->
</div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        name: "ServiceForm",
        data () {
            return {
                formData: {
                    asset_id: null,
                    protocolUID: '',
                    component_id: null,
                },
                editor: ClassicEditor,
                editorData: '',
                editorConfig: {
                    // The configuration of the rich-text editor.
                },
            }
        }
    }
</script>

<style scoped>

</style>
