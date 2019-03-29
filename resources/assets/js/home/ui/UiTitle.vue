<template lang="html">
    <div>
        <component
            :is="tag"
            class="ui-title"
            :class="[
                mainClass,
                alignClass,
                fontSizeClass,
                colorClass,
                uppercaseClass,
                paddingClass,
                marginClass,
            ]">
                {{ title }}
        </component>
    </div>
</template>

<script>
export default {
    name: 'UiTitle',
    props: {
        title: {
            type: String,
            default: null
        },
        color: {
            type: String,
            default: null
        },
        isMain: {
            type: Boolean,
            default: false,
        },
        uppercase: {
            type: Boolean,
            default: true,
        },
        tag: {
            type: String,
            default: 'h2',
        },
        fontSize: {
            type: String,
            default: 'h4',
        },
        align: {
            type: String,
            default: null,
        },
        hasPadding: {
            type: Boolean,
            default: true,
        },
        hasMargin: {
            type: Boolean,
            default: true,
        }
    },
    computed: {
        alignClass: function() {
            if (this.align == 'center') {
                return 'ui-title--align-center'
            }
        },
        mainClass: function() {
            if (this.isMain) {
                return 'ui-title--ismain'
            }
        },
        fontSizeClass: function() {
            return 'ui-title--' + this.fontSize
        },
        colorClass: function() {
            if (this.color) {
                return 'text-' + this.color
            }
        },
        uppercaseClass: function() {
            if (!this.uppercase) {
                return 'ui-title--text-normal'
            }
        },
        paddingClass: function() {
            if (!this.hasPadding) {
                return 'ui-title--no-padding'
            }
        },
        marginClass: function() {
            if (!this.hasMargin) {
                return 'ui-title--no-margin'
            }
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.ui-title {
    $self: &;
    padding-top: $spacer;
    margin-bottom: $spacer;
    text-transform: uppercase;
    font-weight: $font-weight-bold;

    &--ismain {
        text-align: center;
        margin-bottom: $spacer * 2;
        padding-top: $spacer * 3;
    }

    &--align-center {
        text-align: center;
    }

    &--text-normal {
        letter-spacing: 2px;
        text-transform: none;
    }

    &--no-padding {
        padding-top: 0;
    }

    &--no-margin {
        margin-bottom: 0;
    }

    &--h1 { font-size: $h1-font-size; }
    &--h2 { font-size: $h2-font-size; }
    &--h3 { font-size: $h3-font-size; }
    &--h4 { font-size: $h4-font-size; }
    &--h5 { font-size: $h5-font-size; }
    &--h6 { font-size: $h6-font-size; }
}
</style>
