<template>
<div>
    <ui-title
        :title="option.label"
        :has-container="false"
    />
    <slot></slot>
</div>
</template>

<script>
import {
    UiButton,
    UiTitle,
}
from '../../ui'
import TranslateCreateLanguage from './TranslateCreateLanguage.vue'

export default {
    name: 'TranslateLoop',
    components: {
        TranslateCreateLanguage,
        UiButton,
        UiTitle,
    },
    props: {
        option: {
            type: Object,
            default: function () {
                return {}
            },
        },
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
        languages: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {}
    },
    computed: {
        initialFormat: function () {
            // console.log(this.initial, 'lingue', this.languages);
        },
    },
    methods: {
        loaded: function () {

        },
    },
    mounted: function () {
        // console.log(this.languages);
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
