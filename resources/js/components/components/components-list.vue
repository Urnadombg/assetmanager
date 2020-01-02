<template>
    <div>
        <b-table :items="componentsx"
                 bordered
                 responsive
                 head-variant="light"
                 large
                 hover
                 @click="rowSelected"
                 :fields="tableFields">
            <template v-slot:cell(nomer)="row">
                {{ row.index +1 }}
            </template>
            <template v-slot:cell(show_details)="row">
                {{ row }}
            </template>
            <template v-slot:cell(warranty)="row">
                <div v-if="row.item.warranty">
                    <strong>Валидна от:</strong>
                    {{ row.item.warranty.start }}
                    <strong>до:</strong>
                    {{ row.item.warranty.end }}
                </div>
                <div v-else>
                    Няма данни за гаранционна карта
                </div>

            </template>
            <template v-slot:cell(actions)="row">
                <b-btn-group>
                    <b-btn variant="primary " @click="row.item._showDetails = !row.item._showDetails" >Виж</b-btn>
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

            },
            rowSelected(row) {
                console.log(row)
                row._showDetails = !row._showDetails
            }
        }
    }
</script>

<style scoped>

</style>
