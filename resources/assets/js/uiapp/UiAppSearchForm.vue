<template>
<div class="ua-search-form">
    <ui-row>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="Title"
                name="title"
                :value.sync="search.title"
                :placeholder="placeholders.title"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                title="Historical period"
                name="period"
                :value.sync="search.period"
                :placeholder="placeholders.period"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="Director"
                name="director"
                :value.sync="search.director"
                :placeholder="placeholders.director"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                title="Genre"
                name="genre"
                :value.sync="search.genre"
                :placeholder="placeholders.genre"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="Year of production"
                name="year"
                :value.sync="search.year"
                :placeholder="placeholders.year"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                title="Format"
                name="format"
                :value.sync="search.format"
                :placeholder="placeholders.format"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="Nationality"
                name="country"
                :value.sync="search.country"
                :placeholder="placeholders.country"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="People"
                name="cast"
                :value.sync="search.cast"
                :placeholder="placeholders.cast"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                title="Topic"
                name="topic"
                :value.sync="search.topic"
                :placeholder="placeholders.topic"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                title="Student age"
                name="age_range"
                :value.sync="search.age_range"
                :placeholder="placeholders.age_range"
            />
        </ui-block>
    </ui-row>
    <div class="ua-search-form__btns">
        <ui-button
            title="Search"
            color="red"
            :has-container="false"
            @click="startSearch"
        />
    </div>
</div>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiRow,
}
from '../ui'

import SelectInput from './sub/search-form/SelectInput.vue'
import TextInput from './sub/search-form/TextInput.vue'

export default {
    name: 'UiAppSearchForm',
    components: {
        SelectInput,
        TextInput,
        UiBlock,
        UiButton,
        UiRow,
    },
    data: function () {
        return {
            search: {
                title: null,
                period: null,
                director: null,
                genre: null,
                year: null,
                format: null,
                country: null,
                cast: null,
                topic: null,
                age_range: null,
            },
            placeholders: {
                title: 'Write a title',
                period: 'Select an historical period',
                director: 'Write a director',
                genre: 'Select a genre',
                year: 'Write a year of production',
                format: 'Select a format',
                country: 'Write a nationality',
                cast: 'Write peoples',
                topic: 'Write a topic',
                age_range: 'Select age',
            }
        }
    },
    methods: {
        cleanQuery: function () {
            let query = {}

            for (let key in this.search) {
                if (this.search.hasOwnProperty(key) && this.search[key] != null) {
                    query[key] = this.search[key]
                }
            }

            return query
        },
        startSearch: function () {
            let query = this.cleanQuery(this.search)
            this.$emit('search', query)
        }
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.ua-search-form {
    &__btns {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    .ua-select-input,
    .ua-text-input {
        label {
            font-size: $font-size-lg;
            font-weight: bold;
            letter-spacing: 1px;
        }
    }
}
</style>
