<template>
    <div>
        <b-table :items="componentsx"
                 bordered
                 responsive
                 head-variant="light"
                 large
                 hover
                 :fields="tableFields">
            <template slot="nomer" slot-scope="data">
                {{ data.index +1 }}
            </template>
            <template slot="[warranty]" slot-scope="data">
                <strong>Валидна от:</strong>
                {{ data.item.warranty.start }}
                <strong>до:</strong>
                {{ data.item.warranty.end }}
            </template>
            <template slot="actions">
                <b-btn-group>
                    <b-btn variant="primary">Виж</b-btn>
                    <b-btn variant="secondary">Редакция</b-btn>
                    <b-btn variant="danger">Изтриване</b-btn>
                </b-btn-group>
            </template>
        </b-table>
    </div>
</template>

<script>
    export default {
        props: ['components'],
        name: "ComponentList",
        data () {
            return {
                componentsx: [],
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
                        label: 'Модел',
                        key: 'model'
                    },
                    {
                        label: 'сериен №',
                        key: 'serial'
                    },
                    {
                        label: 'Гаранция',
                        key: 'warranty'
                    },
                    {
                        label: 'Действия',
                        key: 'actions'
                    },
                ],
                loading: true,
            }
        },
        mounted () {
            this.componentsx = this.$props.components
        },
        methods: {
            getComponentsInfo() {

            }
        }
    }
</script>

<style scoped>

</style>
