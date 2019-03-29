<template lang="html">
    <a
        :href="url"
        :target="target"
        class="ui-link"
        :class="[
            btnClass,
            colorClass,
            blockClass,
            spacingClass,
            marginClass,
            disabledClass
        ]">
        <slot></slot>
    </a>
</template>

<script>
export default {
    name: 'UiLink',
    props: {
        color: {
            type: String,
            default: 'black',
        },
        block: {
            type: Boolean,
            default: false,
        },
        isDisabled: {
            type: Boolean,
            default: false
        },
        url: {
            type: String,
            default: '#'
        },
        target: {
            type: String,
            default: '_self'
        },
        text: {
            type: String,
            default: 'Link'
        },
        isSimple: {
            type: Boolean,
            default: true,
        },
        hasSpace: {
            type: Boolean,
            default: true,
        },
        hasMargin: {
            type: Boolean,
            default: true,
        },
    },
    computed: {
        colorClass: function() {
            if (this.color && !this.isSimple) {
                return 'btn-'+this.color
            } else if (this.color && this.isSimple) {
                return 'text-'+this.color
            }
        },
        blockClass: function() {
            if (this.block) {
                return 'btn-block'
            }
        },
        btnClass: function() {
            if (!this.isSimple) {
                return 'btn'
            }
        },
        spacingClass: function() {
            if (!this.hasSpace) {
                return 'ui-link--no-spacing'
            }
        },
        marginClass: function() {
            if (!this.hasMargin) {
                return 'ui-link--no-margin'
            }
        },
        disabledClass: function() {
            if (this.isDisabled) {
                return 'disabled'
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-link {
    $self: &;
    margin-bottom: $spacer;
    z-index: 1;
    font-size: $font-size-base * 0.75;
    letter-spacing: 3px;
    text-decoration: underline;
    font-weight: $font-weight-bold;

    &#{$self}--no-spacing {
        letter-spacing: normal;
    }

    &#{$self}--no-margin {
        margin-bottom: 0;
    }
}
</style>
