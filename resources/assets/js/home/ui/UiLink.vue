<template lang="html">
    <a :href="link"
        :target="target"
        class="ui-link"
        :class="isDisabledClass">
        <slot></slot>
    </a>
</template>

<script>
export default {
    name: 'UiAction',
    props: {
        url: {
            type: String,
            default: null,
        },
        isDisabled: {
            type: Boolean,
            default: false
        },
        target: {
            type: String,
            default: '_self'
        },
    },
    computed: {
        isDisabledClass: function() {
            if (this.isDisabled) {
                return 'disabled'
            }
            return null
        },
        link: function() {
            if (this.target == '_self') {
                return '#'
            }
            return this.url
        },
        isExternal: function() {
            if (this.target == '_self') {
                return false
            }
            return true
        },
    },
    methods: {
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.ui-link {
    color: $black;
    text-decoration: underline;
    font-weight: $font-weight-bold;
}
</style>
