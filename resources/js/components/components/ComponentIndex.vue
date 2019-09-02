<template>
    <div>
        <b-card>
            <div slot="header">
                <h1>
                    Компоненти
                </h1>
            </div>
            <div class="demo">
                <div v-if="selected" style="padding-top:10px; width: 100%;">
                    You have selected <code>{{selected.name}}, the {{selected.race}}</code>
                </div>
                <div class="autosuggest-container">
                    <vue-autosuggest
                        v-model="query"
                        :suggestions="filteredOptions"
                        @focus="focusMe"
                        @click="clickHandler"
                        @input="onInputChange"
                        @selected="onSelected"
                        :get-suggestion-value="getSuggestionValue"
                        :input-props="{id:'autosuggest__input', placeholder:'Do you feel lucky, punk?'}">
                        <div slot-scope="{suggestion}" style="display: flex; align-items: center;">
                            <img :style="{ display: 'flex', width: '25px', height: '25px', borderRadius: '15px', marginRight: '10px'}" :src="suggestion.item.avatar" />
                            <div style="{ display: 'flex', color: 'navyblue'}">{{suggestion.item.name}}</div>
                        </div>
                    </vue-autosuggest>
                </div>
            </div>
            <b-card-body>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="total"
                    :per-page="perPage"
                    aria-controls="components-table"
                    size="md"
                    fill
                >

                </b-pagination>

                <p class="mt-3">Current Page: {{ currentPage }}</p>
                <br>
                    <b-form-group id="search-form-group" label="Търсене" label-for="search-input">
                        <b-form-input
                            id="search-input"
                            name="search-input"
                            v-model="filter"
                            aria-describedby="search-input-live-feedback"
                            size="lg"
                        ></b-form-input>
                    </b-form-group>
                <br>
                <b-table
                :items="components"
                id="components-table"
                bordered
                ref="table"
                head-variant="dark"
                :busy.sync="isBusy"
                :fields="tableFields"
                hover
                striped
                responsive
                @filtered="onFiltered"
                :current-page="currentPage"
                :per-page="0">
                >
                    <template slot="table-busy">
                        <div >
                            <b-spinner class="align-content-lg-center"></b-spinner>
                            <strong>Зарежда...</strong>
                        </div>
                    </template>
                    <template slot="nomer" slot-scope="data">
                        {{ data.index + 1}}
                    </template>
                    <template slot="asset" slot-scope="data">
                        <a :href="'/assets/' + data.item.id">
                            {{ data.item.asset.title }}
                            {{ data.item.asset.model }}
                            <span>, сериен № </span>
                            {{ data.item.asset.serial }}
                        </a>
                    </template>
                    <template slot="actions" slot-scope="data">
                        <b-btn-group fill>
                            <b-button variant="success" href="#">
                                Виж
                            </b-button>
                            <b-button variant="primary" href="#">
                                Виж
                            </b-button>
                            <b-button variant="danger" href="#">
                                Виж
                            </b-button>
                        </b-btn-group>
                    </template>
                </b-table>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import { VueAutosuggest } from 'vue-autosuggest';

    export default {
        name: "ComponentIndex",
        components: {
            VueAutosuggest
        },
        data() {
            return {
                query: "",
                selected: "",
                suggestions: [
                    {
                        data: [
                            {
                                id: 1,
                                name: "Frodo",
                                race: "Hobbit",
                                avatar: "https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/Elijah_Wood_as_Frodo_Baggins.png/220px-Elijah_Wood_as_Frodo_Baggins.png"
                            },
                            {
                                id: 2,
                                name: "Samwise",
                                race: "Hobbit",
                                avatar: "https://upload.wikimedia.org/wikipedia/en/thumb/7/7b/Sean_Astin_as_Samwise_Gamgee.png/200px-Sean_Astin_as_Samwise_Gamgee.png"
                            },
                            {
                                id: 3,
                                name: "Gandalf",
                                race: "Maia",
                                avatar: "https://upload.wikimedia.org/wikipedia/en/thumb/e/e9/Gandalf600ppx.jpg/220px-Gandalf600ppx.jpg"
                            },
                            {
                                id: 4,
                                name: "Aragorn",
                                race: "Human",
                                avatar: "https://upload.wikimedia.org/wikipedia/en/thumb/3/35/Aragorn300ppx.png/150px-Aragorn300ppx.png"
                            }
                        ]
                    }
                ],
                components: [],
                tableFields: [
                    {
                        label: '№',
                        key: 'nomer',
                        sortable: false
                    },
                    {
                        label: 'Наименование',
                        key: 'title',
                        sortable: false
                    },
                    {
                        label: 'Модел',
                        key: 'model',
                        sortable: false
                    },
                    {
                        label: 'Заведен към',
                        key: 'asset',
                        sortable: false
                    },
                    {
                        label: 'Действия',
                        key: 'actions',
                        sortable: false
                    },
                ],
                isBusy: true,
                currentPage: 1,
                perPage: '',
                sortBy: 'serial',
                total: '',
                filter: null,
                filterOn: [],
            }
        },
        mounted() {
            this.getComponents();
        },
        methods: {
            async getComponents() {
                // // console.log(ctx)
                // let request = axios.get(`/api/components?page=${this.currentPage}`);
                // this.isBusy = true
                //
                // return request.then(
                //     (data) => {
                //         this.currentPage = data.data.meta.current_page
                //         this.perPage = data.data.meta.per_page
                //         this.total = data.data.meta.total
                //         this.isBusy = false
                //         return data.data.data
                //     }
                // )
                //     .catch(
                //         (error) => console.log(error)
                //     )
                this.components = axios.get(`/api/components?page=${this.currentPage}`)
                    .then(
                        (data) => {
                            this.total = data.data.meta.total
                            this.currentPage = data.data.meta.current_page
                            // this.components = data.data.data
                            return data.data.data

                        }
                    )

                    .then(components => {
                        this.components = components
                        this.isBusy = false
                    })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                // this.totalRows = filteredItems.length
                // this.currentPage = 1
                console.log(filteredItems)
            },
            clickHandler(item) {
                // event fired when clicking on the input
            },
            onSelected(item) {
                this.selected = item.item;
            },
            onInputChange(text) {
                // event fired when the input changes
                console.log(text)
            },
            /**
             * This is what the <input/> value is set to when you are selecting a suggestion.
             */
            getSuggestionValue(suggestion) {
                return suggestion.item.name;
            },
            focusMe(e) {
                console.log(e) // FocusEvent
            }
        },
        computed: {
            filteredOptions() {
                return [
                    {
                        data: this.suggestions[0].data.filter(option => {
                            return option.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1;
                        })
                    }
                ];
            }
        }
    }

</script>

<style scoped>
    .demo {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    input {
        width: 260px;
        padding: 0.5rem;
    }

    ul {
        width: 100%;
        color: rgba(30, 39, 46,1.0);
        list-style: none;
        margin: 0;
        padding: 0.5rem 0 .5rem 0;
    }
    li {
        margin: 0 0 0 0;
        border-radius: 5px;
        padding: 0.75rem 0 0.75rem 0.75rem;
        display: flex;
        align-items: center;
    }
    li:hover {
        cursor: pointer;
    }

    .autosuggest-container {
        display: flex;
        justify-content: center;
        width: 280px;
    }

    #autosuggest { width: 100%; display: block;}
    .autosuggest__results-item--highlighted {
        background-color: rgba(51, 217, 178,0.2);
    }
</style>
