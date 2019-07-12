<template>
<div class="admin-apps">
    <container padding="sm">
        <div class="admin-apps__topbar">
            <div class="admin-apps__select">
                <label for="app">Seleziona l'app</label>
                <select
                    class="form-control"
                    name="app"
                    v-model="app"
                >
                    <option value="null"></option>
                    <option
                        v-for="app in apps"
                        :key="app.id"
                        :value="app.slug"
                    >
                        {{ app.title }}
                    </option>
                </select>
            </div>
            <div class="admin-apps__per-page">
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
            <div class="admin-apps__search">
                <input
                    type="text"
                    class="form-control"
                    placeholder="cerca"
                    v-model="filter"
                />
            </div>
        </div>
    </container>
    <container>
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
            class="apps-table"
        >
            <template
                slot="thumb"
                slot-scope="data"
            >
                <img
                    :src="data.item.thumb | setThumbSrc"
                    class="apps-table__preview"
                >
            </template>
            <template
                slot="img"
                slot-scope="data"
            >
                <img
                    :src="data.item.img | setThumbSrc"
                    class="apps-table__preview"
                >
            </template>
            <template
                slot="leftSrc"
                slot-scope="data"
            >
                <img
                    :src="data.item.left.thumb | setThumbSrc"
                    class="apps-table__preview"
                >
            </template>
            <template
                slot="rightSrc"
                slot-scope="data"
            >
                <img
                    :src="data.item.right.thumb | setThumbSrc"
                    class="apps-table__preview"
                >
            </template>
        </b-table>

        <div class="admin-apps__center">
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

import fields from './apps/fields'

export default {
    name: 'Apps',
    components: {
        Container
    },
    data: function () {
        return {
            apps: [],
            app: null,
            items: [],
            filter: null,
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            fields: [],
        }
    },
    watch: {
        app: function (slug) {
            if (slug) {
                this.getAssets(slug)
            }
        },
        items: function (items) {
            this.totalRows = items.length
        },
    },
    methods: {
        getApps: function () {
            this.$http.get('/api/v2/admin/apps').then(response => {
                if (response.data.success) {
                    this.apps = response.data.apps
                }
            })
        },
        getAssets: function (slug) {
            let url = '/api/v2/admin/apps/load-assets/' + slug
            this.$http.get(url).then(response => {
                // console.log(response.data.assets);
                this.formatLibrary(response.data.assets, slug)
            })
        },
        formatLibrary: function (obj, slug) {
            console.log(obj);
            // console.log(slug);
            if (slug === 'types-of-images') {
                this.fields = fields.couples
            }
            else if (obj.type === 'images') {
                if (obj.hasSubLibraries) {
                    this.fields = fields.medias
                }
                else {
                    this.fields = fields.mediasSingle
                }
            }
            else if (obj.type === 'videos') {
                if (obj.hasSubLibraries) {
                    this.fields = fields.videos
                }
                else {
                    this.fields = fields.videosSingle
                }
            }
            else if (obj.type === 'audios') {
                if (obj.hasSubLibraries) {
                    this.fields = fields.audios
                }
                else {
                    this.fields = fields.audiosSingle
                }
            }
            else {
                this.fields = fields.medias
            }

            // has sublibraries
            let items = []

            if (obj.hasSubLibraries) {
                let libraries = obj.library
                for (let i = 0; i < libraries.length; i++) {
                    let library = libraries[i]

                    let key
                    if (obj.type === 'images') {
                        key = 'medias'
                    }
                    else if (obj.type === 'mix') {
                        if (library.type == 'images') {
                            key = 'medias'
                        }
                        else {
                            key = library.type
                        }
                    }
                    else {
                        key = obj.type
                    }

                    if (library.type != 'uploads') {
                        // console.log(library[key]);
                        let medias = library[key]
                        let formattedItems = this.formatAssets(medias, library.name, obj.type)

                        items = items.concat(formattedItems)
                    }
                }
            }
            else {
                // console.log(obj.library);
                let library = Object.assign([], obj.library)

                if (slug === 'frame-crop') {
                    library = obj.library[0].medias
                }

                let formattedItems = this.formatAssets(library, null, obj.type)
                items = formattedItems
            }



            // console.log(items);
            this.items = items
        },
        formatAssets: function (mediaArr, name = null, type = null) {
            // console.log(mediaArr);
            let formattedAssets = []

            for (let i = 0; i < mediaArr.length; i++) {
                let formattedAsset = this.formatAsset(mediaArr[i], name, type)
                formattedAssets.push(formattedAsset)
            }

            // console.log(formattedAssets);
            return formattedAssets
        },
        formatAsset: function (asset, name = null, type = null) {
            // console.log(asset, name, type);
            return {
                ...asset,
                library: name,
                type: type
            }
        },
        onFiltered: function (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        }
    },
    filters: {
        setThumbSrc: function (src) {
            return '/storage/' + src
        }
    },
    created: function () {
        this.getApps()
        this.getAssets('sound-studio')
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.admin-apps {
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
}

.apps-table {
    &__preview {
        width: $spacer * 3;
    }
}
</style>
