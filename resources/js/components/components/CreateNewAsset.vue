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
                                  v-model="$v.asset.title.$model"
                                  :state="$v.asset.title.$dirty ? !$v.asset.title.$error : null"
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
                                  v-model="$v.asset.model.$model"
                                  :state="$v.asset.model.$dirty ? !$v.asset.model.$error : null"
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
                                  v-model="asset.serial"
                                  aria-describedby="serial-input-live-feedback"
                                  size="lg"
                              ></b-form-input>
                          </b-form-group>
                          <b-form-group id="type_of_asset-form-group" label="Тип на изделието" label-for="type_of_asset-input">
                              <b-form-input
                                  id="type_of_asset-input"
                                  name="type_of_asset-input"
                                  v-model="$v.asset.type_of_asset.$model"
                                  :state="$v.asset.type_of_asset.$dirty ? !$v.asset.type_of_asset.$error : null"
                                  aria-describedby="type_of_asset-input-live-feedback"
                                  size="lg"
                              ></b-form-input>

                              <b-form-invalid-feedback id="type_of_asset-input-live-feedback">

                              </b-form-invalid-feedback>
                          </b-form-group>
                      </b-col>
                      <b-col cols="4">
                          sdfbr <br>
                          <img src="https://via.placeholder.com/350">
                      </b-col>
                  </b-row>
                </b-container>

                <b-form-group id="customer_id-form-group" label="Клиент" label-for="customer_id-input">
                <b-input-group>
                    <b-form-input
                        id="customer_id-input"
                        name="customer_id-input"
                        v-model="asset.customer_id"
                        aria-describedby="customer_id-input-live-feedback"
                        size="lg"
                    ></b-form-input>
                    <b-input-group-append>
                        <b-button variant="success">
                            Избери от списъка
                        </b-button>
                    </b-input-group-append>
                </b-input-group>


                    <b-form-invalid-feedback id="customer_id-input-live-feedback">
                        деявд
                    </b-form-invalid-feedback>
                </b-form-group>
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
        name: "CreateNewAsset",
        data() {
            return {
                asset: {
                    title: '',
                    model: '',
                    serial: '',
                    type_of_asset: '',
                    customer_id: '',
                    location: '',
                    department: '',
                    purchaseDate: '',
                },
            }
        },
        validations: {
            asset: {
                title: {
                    required
                },
                model: {
                    required
                },
                type_of_asset: {
                    required
                },
            },
        },
        methods: {
            onSubmit(e) {
                e.preventDefault();
                this.$v.$touch();
                axios.post('/api/assets/', this.asset)
                    .then(
                        (data) => {
                            window.location.href = '/assets'
                        }
                    )
                    .catch((error)=>console.log(error))
            },
            onReset() {

            }
        }
    }
</script>

<style scoped>

</style>
