<template>
<div class="admin-news">
    <container padding="sm">
        <div class="admin-news__topbar">
            <div class="admin-news__create">
                <ui-button
                    title="Crea News"
                    color="lightest-gray"
                    :has-container="false"
                    :has-margin="false"
                    @click="create"
                />
            </div>
            <div class="admin-news__per-page">
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
            <div class="admin-news__search">
                <input
                    type="text"
                    class="form-control"
                    placeholder="cerca"
                    v-model="filter"
                />
            </div>
        </div>
    </container>
    <news-panel
        ref="panel"
        :initial="current"
        @undo="undo"
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
            class="admin-news-table"
        >
            <template v-slot:cell(thumb)="data">
                <img
                    :src="data.item.thumb"
                    class="admin-news-table__preview"
                >
            </template>
            <template v-slot:cell(tools)="data">
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    :has-spinner="data.item.isDeleting"
                    :update-spinner-size="true"
                    size="sm"
                    title="elimina"
                    color="danger"
                    @click="destroy(data.item)"
                />
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    size="sm"
                    title="modifica"
                    color="warning"
                    @click="edit(data.item)"
                />
            </template>
        </b-table>
        <div class="admin-news__center">
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
    Container,
    DynamicForm,
}
from '../adminui'

import {
    UiButton
}
from '../../ui'

import NewsPanel from '../components/NewsPanel.vue'

export default {
    name: 'News',
    components: {
        Container,
        DynamicForm,
        NewsPanel,
        UiButton,
    },
    data: function () {
        return {
            items: [],
            form: null,
            filter: null,
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            fields: [{
                    key: 'id',
                    label: 'ID',
                    sortable: true,
                },
                {
                    key: 'thumb',
                    label: 'Immagine',
                    sortable: true,
                },
                {
                    key: 'title',
                    label: 'Titolo',
                    sortable: true,
                },
                {
                    key: 'tools',
                    label: '',
                    sortable: false,
                }
            ],
            current: null,
            isDeleting: false
        }
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/admin/news').then(response => {
                if (response.data.success) {
                    this.items = response.data.items
                }
            })
        },
        onFiltered: function (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
        showPanel: function () {
            this.$refs.panel.show()
        },
        hidePanel: function () {
            this.$refs.panel.hide()
        },
        edit: function (item) {
            this.current = item
            this.$nextTick(() => {
                this.showPanel()
            })
        },
        undo: function () {
            this.hidePanel()
            this.$nextTick(() => {
                this.current = null
            })
        },
        create: function () {
            this.current = Object.assign({}, null)
            this.$nextTick(() => {
                this.showPanel()
            })
        },
        saved: function (obj) {
            let idx = this.items.findIndex(item => item.id === Number(obj.id))
            if (idx > -1) {
                this.items.splice(idx, 1, obj)
            }
            else {
                this.items.push(obj)
            }

            this.$nextTick(() => {
                this.undo()
            })
        },
        destroy: function (obj) {
            let idx = this.items.findIndex(item => item.id === Number(obj.id))
            if (idx > -1) {
                this.items.splice(idx, 1, {
                    ...obj,
                    isDeleting: true,
                })
            }

            let url = '/api/v2/admin/news/' + obj.id
            this.$http.delete(url).then(response => {
                if (response.data.success) {
                    if (idx > -1) {
                        setTimeout(() => {
                            this.items.splice(idx, 1)
                        }, 500)
                    }
                }
            })
        },
    },
    created: function () {
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-news {
    &__center {
        display: flex;
        justify-content: center;
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

    &__topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__search {
        max-width: 200px;
    }
}

.admin-news-table {
    &__preview {
        max-width: 100%;
        max-height: 64px;
    }
}
</style>
