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

    &#{$self}--ismain {
        text-align: center;
        margin-bottom: $spacer * 2;
        padding-top: $spacer * 3;
    }

    &#{$self}--align-center {
        text-align: center;
    }

    &#{$self}--text-normal {
        letter-spacing: 2px;
        text-transform: none;
    }

    &#{$self}--h1 { font-size: $h1-font-size; }
    &#{$self}--h2 { font-size: $h2-font-size; }
    &#{$self}--h3 { font-size: $h3-font-size; }
    &#{$self}--h4 { font-size: $h4-font-size; }
    &#{$self}--h5 { font-size: $h5-font-size; }
    &#{$self}--h6 { font-size: $h6-font-size; }
}
</style>
