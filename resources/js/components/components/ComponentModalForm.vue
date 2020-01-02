<template>
    <b-container fluid>
        <b-card>
            <div slot="title">
                <h2>
                    Създаване на нов актив
                </h2>
            </div>
            <b-form @submit="onSubmit" @reset="onReset">
                <b-container fluid>
                    <b-row>
                        <b-col>
                            <b-form-group id="title-form-group" label="Наименование на изделието" label-for="title-input">
                                <b-form-input
                                    id="title-input"
                                    name="title-input"
                                    v-model="$v.component.title.$model"
                                    :state="$v.component.title.$dirty ? !$v.component.title.$error : null"
                                    aria-describedby="title-input-live-feedback"
                                    size="lg"
                                ></b-form-input>

                                <b-form-invalid-feedback id="title-input-live-feedback">
                                    Това поле е задължително
                                </b-form-invalid-feedback>
                            </b-form-group>
                            <b-form-group id="model-form-group" label="Модел" label-for="model-input">
                                <b-form-input
                                    id="model-input"
                                    name="model-input"
                                    v-model="$v.component.model.$model"
                                    :state="$v.component.model.$dirty ? !$v.component.model.$error : null"
                                    aria-describedby="model-input-live-feedback"
                                    size="lg"
                                ></b-form-input>

                                <b-form-invalid-feedback id="model-input-live-feedback">
                                    model
                                </b-form-invalid-feedback>
                            </b-form-group>
                            <b-form-group id="serial-form-group" label="Сериен №" label-for="serial-input">
                                <b-form-input
                                    id="serial-input"
                                    name="serial-input"
                                    v-model="component.serial"
                                    aria-describedby="serial-input-live-feedback"
                                    size="lg"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col cols="4">
                            sdfbr <br>
                            <img src="https://via.placeholder.com/350">
                        </b-col>
                    </b-row>
                </b-container>
                <b-button type="submit" block variant="primary">
                    Създай нов
                </b-button>
            </b-form>
        </b-card>
    </b-container>
</template>

<script>
    import { required, minLength } from 'vuelidate/lib/validators';

    export default {
        name: "ComponentModalForm",
        props: ['id'],
        data() {
            return {
                component: {
                    title: '',
                    model: '',
                    serial: '',
                    asset_id: ''
                },
            }
        },
        validations: {
            component: {
                title: {
                    required
                },
                model: {
                    required
                },
            },
        },
        methods: {
            onSubmit(e) {
                e.preventDefault();
                this.$v.$touch();
                this.component.asset_id = this.$props.id

                if(this.$v.$invalid) {
                    this.$bvToast.toast('Формата за добавяне на компонент е невалидна!', {
                        title: 'Невалидни данни',
                        variant: 'danger',
                    })
                } else {
                    axios.post(`/api/assets/addComponentToAsset`, this.component)
                        .then(
                            (data) => console.log(data)
                        )
                }
            },
            onReset() {

            }
        }
    }
</script>

<style scoped>

</style>
