<template>
<div v-if="hasContainer">
    <component
        ref="title"
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
                displayClass,
                hoverableClass,
                xPaddingClass,
                shadowsTypeClass,
            ]"
    >
        {{ title }}
        <slot></slot>
    </component>
</div>
<component
    v-else
    ref="title"
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
            displayClass,
            hoverableClass,
            xPaddingClass,
            shadowsTypeClass,
        ]"
>
    {{ title }}
    <slot></slot>
</component>
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
        },
        display: {
            type: String,
            default: null,
        },
        hasContainer: {
            type: Boolean,
            default: true,
        },
        hasShadows: {
            type: Boolean,
            default: false,
        },
        shadowsType: {
            type: Number,
            default: 0,
        },
        hoverable: {
            type: Boolean,
            default: false,
        },
        xPadding: [String, Boolean],
    },
    computed: {
        alignClass: function () {
            if (this.align == 'center') {
                return 'ui-title--align-center'
            }
        },
        mainClass: function () {
            if (this.isMain) {
                return 'ui-title--ismain'
            }
        },
        fontSizeClass: function () {
            return 'ui-title--' + this.fontSize
        },
        colorClass: function () {
            if (this.color) {
                return 'text-' + this.color
            }
        },
        uppercaseClass: function () {
            if (!this.uppercase) {
                return 'ui-title--text-normal'
            }
        },
        paddingClass: function () {
            if (!this.hasPadding) {
                return 'ui-title--no-padding'
            }
        },
        marginClass: function () {
            if (!this.hasMargin) {
                return 'ui-title--no-margin'
            }
        },
        displayClass: function () {
            if (this.display) {
                return 'ui-title--' + this.display
            }
        },
        hoverableClass: function () {
            if (this.hoverable) {
                return 'ui-title--hoverable'
            }
        },
        xPaddingClass: function () {
            if (this.xPadding === true || this.xPadding === 'true') {
                return 'ui-title--x-padding'
            }
        },
        shadowsClass: function () {
            if (this.hasShadows) {
                return 'ui-title--has-shadows'
            }
            return null
        },
        shadowsTypeClass: function () {
            if (this.hasShadows) {
                if (this.shadowsType == 2) {
                    return 'ui-title--has-shadows-2'
                }
                else if (this.shadowsType == 3) {
                    return 'ui-title--has-shadows-3'
                }
                else {
                    return 'ui-title--has-shadows'
                }
            }
            else {
                return null
            }
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
$color: lighten($gray-200, 4);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

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

    &--hoverable:hover {
        text-decoration: underline;
    }

    &--hoverable {
        cursor: pointer;
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

    &--x-padding {
        padding-left: $spacer;
        padding-right: $spacer;
    }

    &--no-margin {
        margin-bottom: 0;
    }

    &--h1 {
        font-size: $h1-font-size;
    }
    &--h2 {
        font-size: $h2-font-size;
    }
    &--h3 {
        font-size: $h3-font-size;
    }
    &--h4 {
        font-size: $h4-font-size;
    }
    &--h5 {
        font-size: $h5-font-size;
    }
    &--h6 {
        font-size: $h6-font-size;
    }

    &--inline-block {
        display: inline-block;
    }

    &--has-shadows {
        position: relative;
        @include custom-text-shadow-custom($darken, -1px, 3px, 8px, 0.05);
    }

    &--has-shadows-2 {
        $c: white;
        $size: 2px;
        $size_1: 2px;
        $size_2: 2px;
        $opacity: 0.9;

        // @include custom-text-shadow-custom($red, $size, $size_1, $size_2, $opacity);
        text-shadow: $size $size_1 $size_2 rgba($c, $opacity), (-$size) (-$size_1) ($size_2) rgba($c, $opacity), (0) ($size_1) ($size_2) rgba($c, $opacity), (0) (-$size_1) ($size_2) rgba($c, $opacity),;
    }

    &--has-shadows-3 {
        $b: darken(white, 20);
        $size: 1px;
        $size_1: -1px;
        $size_2: 0;
        $opacity: 0;
        // @include custom-text-shadow-custom($darken, $size, $size_1, $size_2, $opacity);
        text-shadow: $size $size_1 $size_2 rgba($b, $opacity), (-$size) (-$size_1) ($size_2) rgba($b, $opacity), (0) ($size_1) ($size_2) rgba($b, $opacity), (0) (-$size_1) ($size_2) rgba($b, $opacity),;
        // text-shadow: $size $size_1 $size_2 rgba($red, $opacity), ($size * .33) ($size_1 * -1.618) ($size_2 * 0.66) rgba($green, $opacity), ($size * -1.618) ($size_1 * .66) ($size_2 * 0.33) rgba($yellow, $opacity);
    }
}
</style>
