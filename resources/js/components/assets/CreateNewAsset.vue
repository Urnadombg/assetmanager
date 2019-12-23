<template>
    <b-container fluid>
        <b-card>
            <div slot="title">
                <h2>
                    Създаване на нов актив
                </h2>
            </div>

<!--                <b-container fluid>-->
<!--                  <b-row>-->
<!--                      <b-col>-->
<!--                          <b-form-group id="title-form-group" label="Наименование на изделието" label-for="title-input">-->
<!--                              <b-form-input-->
<!--                                  id="title-input"-->
<!--                                  name="title-input"-->
<!--                                  v-model="$v.asset.title.$model"-->
<!--                                  :state="$v.asset.title.$dirty ? !$v.asset.title.$error : null"-->
<!--                                  aria-describedby="title-input-live-feedback"-->
<!--                                  size="lg"-->
<!--                              ></b-form-input>-->

<!--                              <b-form-invalid-feedback id="title-input-live-feedback">-->
<!--                                  Това поле е задължително-->
<!--                              </b-form-invalid-feedback>-->
<!--                          </b-form-group>-->
<!--                          <b-form-group id="model-form-group" label="Модел" label-for="model-input">-->
<!--                              <b-form-input-->
<!--                                  id="model-input"-->
<!--                                  name="model-input"-->
<!--                                  v-model="$v.asset.model.$model"-->
<!--                                  :state="$v.asset.model.$dirty ? !$v.asset.model.$error : null"-->
<!--                                  aria-describedby="model-input-live-feedback"-->
<!--                                  size="lg"-->
<!--                              ></b-form-input>-->

<!--                              <b-form-invalid-feedback id="model-input-live-feedback">-->
<!--                                  model-->
<!--                              </b-form-invalid-feedback>-->
<!--                          </b-form-group>-->
<!--                          <b-form-group id="serial-form-group" label="Сериен №" label-for="serial-input">-->
<!--                              <b-form-input-->
<!--                                  id="serial-input"-->
<!--                                  name="serial-input"-->
<!--                                  v-model="asset.serial"-->
<!--                                  aria-describedby="serial-input-live-feedback"-->
<!--                                  size="lg"-->
<!--                              ></b-form-input>-->
<!--                          </b-form-group>-->
<!--                          <b-form-group id="type_of_asset-form-group" label="Тип на изделието" label-for="type_of_asset-input">-->
<!--                              <b-form-input-->
<!--                                  id="type_of_asset-input"-->
<!--                                  name="type_of_asset-input"-->
<!--                                  v-model="$v.asset.type_of_asset.$model"-->
<!--                                  :state="$v.asset.type_of_asset.$dirty ? !$v.asset.type_of_asset.$error : null"-->
<!--                                  aria-describedby="type_of_asset-input-live-feedback"-->
<!--                                  size="lg"-->
<!--                              ></b-form-input>-->

<!--                              <b-form-invalid-feedback id="type_of_asset-input-live-feedback">-->

<!--                              </b-form-invalid-feedback>-->
<!--                          </b-form-group>-->
<!--                      </b-col>-->
<!--                      <b-col cols="4">-->
<!--                          sdfbr <br>-->
<!--                          <img src="https://via.placeholder.com/350">-->
<!--                      </b-col>-->
<!--                  </b-row>-->
<!--                </b-container>-->

<!--                <b-form-group id="customer_id-form-group" label="Клиент" label-for="customer_id-input">-->
<!--                <b-input-group>-->
<!--                    <b-form-input-->
<!--                        id="customer_id-input"-->
<!--                        name="customer_id-input"-->
<!--                        v-model="asset.customer_id"-->
<!--                        aria-describedby="customer_id-input-live-feedback"-->
<!--                        size="lg"-->
<!--                    ></b-form-input>-->
<!--                    <b-input-group-append>-->
<!--                        <b-button variant="success">-->
<!--                            Избери от списъка-->
<!--                        </b-button>-->
<!--                    </b-input-group-append>-->
<!--                </b-input-group>-->


<!--                    <b-form-invalid-feedback id="customer_id-input-live-feedback">-->
<!--                        деявд-->
<!--                    </b-form-invalid-feedback>-->
<!--                </b-form-group>-->
<!--                <b-button type="submit" block variant="primary">-->
<!--                    Създай нов-->
<!--                </b-button>-->

            <b-form @submit="onSubmit" @reset="onReset">
            <b-row>
                <b-col cols="6">
                    <b-form-group id="title-form-group"
                                  label="Наименование"
                                  class="text-lg-left"
                                  label-for="title-input">
                        <b-form-input
                            id="title-input"
                            name="title-input"
                            v-model="$v.asset.title.$model"
                            :state="$v.asset.title.$dirty ? !$v.asset.title.$error : null"
                            aria-describedby="title-input-live-feedback"
                            size="lg"
                        ></b-form-input>

                        <b-form-invalid-feedback id="title-input-live-feedback" v-show="!$v.asset.title.required">
                            Задължително поле!
                        </b-form-invalid-feedback>
                        <b-form-invalid-feedback id="title-input-live-feedback" v-show="!$v.asset.title.minLength">
                            Това поле трябва да съдържа поне 3 символа!
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col cols="6">

                </b-col>
                <b-col cols="6">
                    <b-form-group id="model-form-group"
                                  label="Модел"
                                  class="text-lg-left"
                                  label-for="model-input">
                        <b-form-input
                            id="model-input"
                            name="model-input"
                            v-model="$v.asset.model.$model"
                            :state="$v.asset.model.$dirty ? !$v.asset.model.$error : null"
                            aria-describedby="model-input-live-feedback"
                            size="lg"
                        ></b-form-input>

                        <b-form-invalid-feedback id="model-input-live-feedback">
                            Полето модел е задължително
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group id="serial-form-group"
                                  label="Сериен №"
                                  label-for="serial-input"
                                  class="text-lg-left">
                        <b-form-input
                            id="serial-input"
                            name="serial-input"
                            v-model="asset.serial"
                            aria-describedby="serial-input-live-feedback"
                            size="lg"
                        ></b-form-input>

                        <b-form-invalid-feedback id="serial-input-live-feedback">
                            Сериеният номер е задължителен!
                        </b-form-invalid-feedback>
                    </b-form-group>
                    <b-form-group id="type_of_asset-form-group"
                                  label="Тип на изделието"
                                  class="text-lg-left"
                                  label-for="type_of_asset-input">
                        <b-form-select :options="typeOfAssets" text-field="label"
                                       id="type_of_asset-input"
                                       name="type_of_asset-input"
                                       v-model="asset.type_of_asset"
                                       aria-describedby="type_of_asset-input-live-feedback"
                                       size="lg"
                        ></b-form-select>

                        <b-form-invalid-feedback id="type_of_asset-input-live-feedback">
                            zadyl
                        </b-form-invalid-feedback>
                    </b-form-group>

                </b-col>
                <b-col cols="6">
                    <image-uploader
                        :preview="true"
                        :className="['fileinput', { 'fileinput--loaded': hasImage }]"
                        capture="environment"
                        :debug="1"
                        doNotResize="gif"
                        :autoRotate="true"
                        outputFormat="verbose"
                        @input="setImage"
                    >
                        <label for="fileInput" slot="upload-label">
                            <figure>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="32"
                                    height="32"
                                    viewBox="0 0 32 32"
                                >
                                    <path
                                        class="path1"
                                        d="M9.5 19c0 3.59 2.91 6.5 6.5 6.5s6.5-2.91 6.5-6.5-2.91-6.5-6.5-6.5-6.5 2.91-6.5 6.5zM30 8h-7c-0.5-2-1-4-3-4h-8c-2 0-2.5 2-3 4h-7c-1.1 0-2 0.9-2 2v18c0 1.1 0.9 2 2 2h28c1.1 0 2-0.9 2-2v-18c0-1.1-0.9-2-2-2zM16 27.875c-4.902 0-8.875-3.973-8.875-8.875s3.973-8.875 8.875-8.875c4.902 0 8.875 3.973 8.875 8.875s-3.973 8.875-8.875 8.875zM30 14h-4v-2h4v2z"
                                    ></path>
                                </svg>
                            </figure>
                            <span class="upload-caption">{{ hasImage ? "Replace" : "Click to upload" }}
                           </span>
                        </label>
                    </image-uploader>
                </b-col>
                <b-col cols="12" class="text-lg-left">
                    <label for="customer" class="text-left">Клиент</label>
                    <multiselect v-model="customer"
                                 :options="customers"
                                 :searchable="true"
                                 :loading="isLoading"
                                 :internal-search="false"
                                 :clear-on-select="false"
                                 id="customer"
                                 :options-limit="300"
                                 :limit="3"
                                 @select="setCustomerId"
                                 @search-change="getCustomers"
                                 label="name">
                    </multiselect>
                </b-col>
                <b-col>
                    <b-button block type="submit">
                        Запази
                    </b-button>
                </b-col>
            </b-row>
            </b-form>
        </b-card>
        {{ asset }}
    </b-container>
</template>

<script>
    import { required, minLength } from 'vuelidate/lib/validators';
    import Multiselect from 'vue-multiselect'
    export default {
        name: "CreateNewAsset",
        data() {
            return {
                typeOfAssets: [
                    {
                        label: 'Основен',
                        value: 'primary',
                    },
                    {
                        label: 'Компонент / ДНМА',
                        value: 'secondary',
                    },
                ],
                hasImage: false,
                image: null,
                customers: [],
                customer: '',
                isLoading: false,
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
        mounted() {
          this.getCustomers()
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
            setCustomerId(customer) {
                this.asset.customer_id = customer.id
            },
            limitText (count) {
                return `and ${count} other countries`
            },
            clearAll () {
                this.selectedCountries = []
            },
            async getCustomers() {
                await axios.get('/api/customers')
                    .then(
                        (data) => {
                            this.isLoading = true
                            this.customers = data.data
                            this.isLoading = false
                        }
                    )
            },
            setImage: function(output) {
                this.hasImage = true;
                this.image = output;
                console.log(this.image);
            },
            onSubmit(e) {
                e.preventDefault();
                this.$v.$touch();

                axios.post('/api/assets/', this.asset)
                    .then(
                        (data) => {
                      console.log(data.data.asset_id)

                            window.location.href = `/assets/${data.data.asset_id}`
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
