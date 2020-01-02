<template>
    <div>
        <b-card>
            <div slot="header">
                <h3>
                    {{ `${ customerData.name} ${customerData.lastname}` }}
                </h3>
            </div>

            <b-card-body>
                <sui-form>
                    <sui-form-field>
                        <label>First Name</label>
                        <input placeholder="First Name" >
                    </sui-form-field>
                    <sui-form-field>
                        <label>Last Name</label>
                        <input placeholder="Last Name" >
                    </sui-form-field>
                    <sui-form-field>
                        <sui-checkbox label="I agree to the Terms and Conditions" />
                    </sui-form-field>
                    <sui-button type="submit">Submit</sui-button>
                </sui-form>
                <b-table :items="customerData.assets"
                         :fields="tableFields"
                         id="assettable"
                         bordered
                         ref="table"
                         head-variant="dark"
                         show-empty
                         hover
                         striped
                         responsive
                >
                    <template v-slot:cell(nomer)="data" style="width: 3%">
                        {{ data.index + 1 }}
                    </template>
                    <template v-slot:cell(title)="data">
                        {{ data.item.title }} {{ data.item.model }}
                    </template>
                    <template v-slot:cell(actions)="data">
                        <b-btn-group>
                            <b-btn variant="info" @click="goToAssetFile(data.item, 0)">
                                <i class="fa fa-eye"></i>
                            </b-btn>
                            <b-btn variant="warning" @click="goToAssetFile(data.item,1)">
                                <i class="fa fa-cogs"></i>
                            </b-btn>
                            <b-btn variant="primary" @click="goToAssetFile(data.item,2)">
                                <i class="fa fa-tools"></i>
                            </b-btn>
                            <b-btn variant="success" @click="goToAssetFile(data.item,3)">
                                <i class="fa fa-folder"></i>
                            </b-btn>
                        </b-btn-group>
                    </template>
                </b-table>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    export default {
        name: "CustomerDetails",
        data () {
            return {
                customerID: window.location.pathname.replace('/customers/',''),
                customerData: '',
                tableFields: [
                    {
                        label: '№',
                        key: 'nomer'
                    },
                    {
                        label: 'Наименование на актива',
                        key: 'title'
                    },
                    {
                        label: 'сериен №',
                        key: 'serial',
                        sortable: true
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    }]
            }
        },
        mounted() {
            axios.get(`/api/customers/${this.customerID}`)
                .then(
                    (data) => {
                        this.customerData = data.data;
                    }
                )
        },
        methods: {
            goToAssetFile(asset, tabIndex) {
                window.location.href = `/assets/${asset.id}&tabIndex=${tabIndex}`
            },
        }
    }
</script>

<style scoped>

</style>
