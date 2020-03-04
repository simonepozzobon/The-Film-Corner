<template>
<div class="ua-search-form">
    <ui-row>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('title')"
                name="title"
                :value.sync="search.title"
                :placeholder="$root.getCmd('write_a_title')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                :title="$root.getCmd('historical_period')"
                name="period"
                :options="options.periods"
                :value.sync="search.period"
                :placeholder="$root.getCmd('select_an_historical_period')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('director')"
                name="director"
                :value.sync="search.director"
                :placeholder="$root.getCmd('write_a_director')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                :title="$root.getCmd('genre')"
                name="genre"
                :options="options.genres"
                :value.sync="search.genre"
                :placeholder="$root.getCmd('select_a_genre')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('year_of_production')"
                name="year"
                :value.sync="search.year"
                :placeholder="$root.getCmd('write_a_year_of_production')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                :title="$root.getCmd('format')"
                name="format"
                :options="options.formats"
                :value.sync="search.format"
                :placeholder="$root.getCmd('select_a_format')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('nationality')"
                name="country"
                :value.sync="search.country"
                :placeholder="$root.getCmd('write_a_nationality')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('people')"
                name="cast"
                :value.sync="search.cast"
                :placeholder="$root.getCmd('write_peoples')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <text-input
                :title="$root.getCmd('topic')"
                name="topic"
                :value.sync="search.topic"
                :placeholder="$root.getCmd('write_a_topic')"
            />
        </ui-block>
        <ui-block
            :size="6"
            :has-container="false"
        >
            <select-input
                :title="$root.getCmd('student_age')"
                name="age_range"
                :options="options.ages"
                :value.sync="search.age"
                :placeholder="$root.getCmd('select_age_range')"
            />
        </ui-block>
    </ui-row>
    <div class="ua-search-form__btns">
        <ui-button
            :title="$root.getCmd('search')"
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
    props: {
        options: {
            type: Object,
            default: function () {
                return {}
            },
        },
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
                age: null,
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
            console.log('query', query);
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
