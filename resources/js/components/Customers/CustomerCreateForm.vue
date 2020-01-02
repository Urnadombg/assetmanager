<template>
    <div>
       <b-card>
           <b-container fluid>
               <b-row>
                   <b-col>
                       <form @submit.prevent="saveCustomer">
                           <b-form-group id="name-form-group" label="Име" label-for="name-input">
                               <b-form-input
                                   id="name-input"
                                   name="name-input"
                                   v-model="$v.customer.name.$model"
                                   :state="$v.customer.name.$dirty ? !$v.customer.name.$error : null"
                                   aria-describedby="name-input-live-feedback"
                                   size="lg"
                               ></b-form-input>

                               <b-form-invalid-feedback id="name-input-live-feedback">
                                   Towa pole e zad
                               </b-form-invalid-feedback>
                           </b-form-group>

                           <b-form-group id="lastname-form-group" label="Фамилия" label-for="lastname-input">
                               <b-form-input
                                   id="lastname-input"
                                   name="lastname-input"
                                   v-model="$v.customer.lastname.$model"
                                   :state="$v.customer.lastname.$dirty ? !$v.customer.lastname.$error : null"
                                   aria-describedby="lastname-input-live-feedback"
                                   size="lg"
                               ></b-form-input>

                               <b-form-invalid-feedback id="lastname-input-live-feedback">
                                   зад
                               </b-form-invalid-feedback>
                           </b-form-group>
                           <b-form-group id="phone-form-group" label="Телефон за връзка" label-for="phone-input">
                               <b-form-input
                                   id="phone-input"
                                   name="phone-input"
                                   v-model="$v.customer.phone.$model"
                                   pattern="[789][0-9]{9}"
                                   :state="$v.customer.phone.$dirty ? !$v.customer.phone.$error : null"
                                   aria-describedby="phone-input-live-feedback"
                                   size="lg"
                               ></b-form-input>

                               <b-form-invalid-feedback id="phone-input-live-feedback">
                                   ---
                               </b-form-invalid-feedback>
                           </b-form-group>
                           <b-form-group id="address-form-group" label="Адрес" label-for="address-input">
                               <b-form-input
                                   id="address-input"
                                   name="address-input"
                                   v-model="$v.customer.address.$model"
                                   :state="$v.customer.address.$dirty ? !$v.customer.address.$error : null"
                                   aria-describedby="address-input-live-feedback"
                                   size="lg"
                               ></b-form-input>

                               <b-form-invalid-feedback id="address-input-live-feedback">
                                   adresa e zad
                               </b-form-invalid-feedback>
                           </b-form-group>
                           <b-form-group id="city-form-group" label="Град" label-for="city-input">
                               <b-form-input
                                   id="city-input"
                                   name="city-input"
                                   v-model="$v.customer.city.$model"
                                   :state="$v.customer.city.$dirty ? !$v.customer.city.$error : null"
                                   aria-describedby="city-input-live-feedback"
                                   size="lg"
                               ></b-form-input>

                               <b-form-invalid-feedback id="city-input-live-feedback">
                                   grada
                               </b-form-invalid-feedback>
                           </b-form-group>
                           <b-btn variant="success" @click="saveCustomer">Запази</b-btn>
                       </form>
                   </b-col>
                   <b-col>
                       <h2>
                           hireo
                       </h2>
                       <b-checkbox v-model="createCompany">фирмени данни</b-checkbox>
                       <div v-if="createCompany">

                       </div>
                   </b-col>
               </b-row>
           </b-container>
       </b-card>
    </div>
</template>

<script>
    import { required } from 'vuelidate/lib/validators'
    export default {
        name: "CustomerCreateForm",
        data() {
            return {
                customer: {
                    name: '',
                    lastname: '',
                    phone: '',
                    address: '',
                    city: '',
                    legalEntity_id: '',
                },
                createCompany: false,

            }
        },
        validations() {
            if(this.createCompany) {
                // this.$bvToast.toast('oaosdkasd');
                return  {
                    customer: {
                        name: {
                            required
                        },
                        lastname: {
                            required
                        },
                        phone: {
                            required
                        },
                        address: {
                            required
                        },
                        city: {
                            required
                        }

                    },

                }
            } else {
                return {
                    customer: {
                        name: {
                            required
                        },
                        lastname: {
                            required
                        },
                        phone: {
                            required
                        },
                        address: {
                            required
                        },
                        city: {
                            required
                        }
                    }
                }
            }
        },
        methods: {
            saveCustomer(){
                this.$v.$touch()
                // if(!this.$v.$invalid) {
                    axios.post(`/api/customers`, this.customer)
                        .then(
                            (data) => {
                                this.$bvToast.toast(`${this.customer.name} has been saved`);
                                console.log(data)
                            }
                        )
                        .catch(
                            (error) => {
                                this.$bvToast.toast(`Error ${error}`, {
                                    type: 'error'
                                })
                            }
                        )
                // }

            }
        }
    }
</script>

<style scoped>

</style>
