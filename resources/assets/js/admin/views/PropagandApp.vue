<template>
<div class="a-propaganda">
    <container padding="sm">
        <div class="a-propaganda__topbar">
            <div class="admin-apps__select">
                <ui-button
                    :has-container="false"
                    :has-margin="false"
                    title="Aggiungi Clip"
                    size="sm"
                    color="green-var"
                    @click="createClip"
                />
            </div>
            <div class="a-propaganda__per-page">
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
            <div class="a-propaganda__search">
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
            :items="clips"
            :fields="fields"
            :filter="filter"
            :current-page="currentPage"
            :per-page="perPage"
            @filtered="onFiltered"
            class="clips-table"
        >
            <template v-slot:cell(period)="data">
                {{ data.item.period.title }}
            </template>
            <template v-slot:cell(tools)="data">
                <ui-button
                    title="modifica"
                    theme="outline"
                    color="orange"
                    :has-container="false"
                    display="inline-block"
                />
                <ui-button
                    title="cancella"
                    theme="outline"
                    color="red"
                    :has-container="false"
                    display="inline-block"
                    @click="deleteClip(data.item)"
                />
            </template>
        </b-table>

        <div class="admin-clips__center">
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
}
from '../adminui'

import {
    UiButton,
}
from '../../ui'

import PropagandaFields from './mixins/PropagandaFields'

export default {
    name: 'PropagandApp',
    components: {
        Container,
        UiButton,
    },
    mixins: [PropagandaFields],
    data: function () {
        return {
            clips: [],
            clip: null,
            items: [],
            filter: null,
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
        }
    },
    watch: {
        clips: function (clips) {
            this.totalRows = clips.length
            this.currentPage = 1
        },
    },
    methods: {
        getClips: function () {
            this.$http.get('/api/v2/admin/clips').then(response => {
                if (response.data.success) {
                    // console.log(response.data);
                    this.clips = response.data.clips
                }
            })
        },
        onFiltered: function (filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
        createClip: function () {
            this.$root.goTo('clips-create')
        },
        deleteClip: function (item) {
            let url = '/api/v2/admin/clips/' + item.id
            this.$http.delete(url).then(response => {
                let idx = this.clips.findIndex(clip => clip.id == response.data.id)
                if (idx > -1) {
                    this.clips.splice(idx, 1)
                }
            })
        }
    },
    created: function () {
        this.getClips()
    },
    mounted: function () {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.a-propaganda {
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

.clips-table {
    &__preview {
        width: $spacer * 3;
    }
}
</style>
