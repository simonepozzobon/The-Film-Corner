<template>
<div class="admin-translate">
    <container padding="sm">
        <div class="admin-translate__topbar">
            <div class="admin-translate__select">
                <label for="app">Cosa Tradurre</label>
                <select
                    class="form-control"
                    name="app"
                    v-model="translation"
                >
                    <option value="apps">Apps</option>
                    <option value="app_categories">Percorso didattico</option>
                    <option value="app_sections">Studio</option>
                    <option value="general_texts">Testi Generali</option>
                </select>
            </div>
            <div class="admin-translate__per-page">
                <label for="perpage">
                    Per pagina
                </label>
                <select
                    name="perpage"
                    v-model="perPage"
                    class="form-control"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="admin-translate__search">
                <input
                    type="text"
                    class="form-control"
                    placeholder="cerca"
                    v-model="filter"
                />
            </div>
        </div>
    </container>
    <translate-create
        ref="panel"
        :initial="form"
        :languages="languages"
        @saved="saved"
    />
    <container :has-margin="false">
        <b-table
            striped
            hover
            sortable
            :items="items"
            :fields="fields"
            :filter="filter"
            :current-page="currentPage"
            :per-page="perPage"
            @filtered="onFiltered"
        >
            <template
                slot="description"
                slot-scope="data"
            >
                <div v-html="data.item.description"></div>
            </template>
            <template
                slot="languages"
                slot-scope="data"
            >
                <div class="admin-translate__state">
                    <translate-state
                        :languages="languages"
                        :item="data.item"
                    />
                </div>
            </template>

            <template
                slot="tools"
                slot-scope="data"
            >
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    title="Traduci"
                    size="sm"
                    color="lightest-gray"
                    @click="translate(data.item)"
                />
            </template>
        </b-table>
        <div class="admin-translate__center">
            <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                align="center"
                class="my-0"
            />
        </div>
    </container>
</div>
</template>

<script>
import {
    Container
}
from '../adminui'

import {
    UiButton
}
from '../../ui'

import TranslateCreate from '../components/TranslateCreate.vue'
import TranslateState from '../components/TranslateState.vue'
import fields from './translate/fields'

export default {
    name: 'Translate',
    components: {
        Container,
        TranslateCreate,
        TranslateState,
        UiButton,
    },
    data: function () {
        return {
            translation: null,
            filter: null,
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            languages: [],
            items: [],
            fields: [],
            form: {},
        }
    },
    watch: {
        items: function (items) {
            this.totalRows = items.length
        },
        translation: function (translation) {
            this.getTranslation(translation)
        }
    },
    methods: {
        getLanguages: function () {
            this.$http.get('/api/v2/admin/translate').then(response => {
                this.languages = response.data
            })
        },
        getTranslation: function (translation) {
            let data = new FormData()
            data.append('type', translation)
            this.$http.post('/api/v2/admin/translate/elements', data).then(response => {
                let options = fields.find(field => field.value == translation)
                this.items = response.data
                this.fields = options.fields
            })
        },
        onFiltered: function (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
        translate: function (item) {
            this.$refs.panel.show()
        },
        saved: function (item) {}
    },
    created: function () {
        this.getLanguages()
    },
    mounted: function () {
        this.$nextTick(() => {
            this.translation = 'apps'
        })
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-translate {
    &__topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__select {
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__per-page {
        margin-left: auto;
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__search {
        max-width: 200px;
    }

    &__state {
        display: flex;
        justify-content: flex-start;
    }
}
</style>
