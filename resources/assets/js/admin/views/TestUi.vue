<template>
<div class="admin-home">
    <container :contains="true">
        <panel-title
            title="Sfondo Chiaro"
            size="h2"
            class="para-single__sub-title"
            letter-spacing="12px"
        />
        <div class="test-panel">
            <section class="custom-input">
                <label
                    for="title"
                    class="custom-input__label"
                >
                    Titolo
                </label>
                <input
                    type="text"
                    name="title"
                    class="custom-input__input"
                    v-model="title"
                />
            </section>
        </div>
        <block-panel title="Sfondo scuro">
            <section class="custom-input">
                <label
                    for="title"
                    class="custom-input__label"
                >
                    Titolo
                </label>
                <input
                    type="text"
                    name="title"
                    class="custom-input__input"
                    v-model="title"
                />
            </section>
        </block-panel>
    </container>
</div>
</template>

<script>
import {
    BlockPanel,
    Container,
    PanelTitle,
}
from '../adminui'

export default {
    name: 'TestUi',
    components: {
        BlockPanel,
        Container,
        PanelTitle,
    },
    data: function () {
        return {
            title: null,
        }
    },
    mounted: function () {
        console.log('home');
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
@import '~styles/utilities/conversion';

$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

// colors
$ci-bg: $color-darken;
$ci-color: darken($ci-bg, 25);

// fonts
$ci-font-size: $font-size-base;
$ci-label-font-size: $ci-font-size * .8;

// label font
$ci-label-font-weight: 600;
$ci-label-letter-spacing: 5px;

// measurements
$ci-shift-x: $spacer * 1.618 * 0.6;
$ci-shift-y: $spacer * 1.618 * 0.5;
$ci-small: 0.8;

// input borders
$ci-border-color: darken($ci-bg, 5);
$ci-border-radius: $border-radius * 2;
$ci-border-size: $spacer / 10;

// Label position
$ci-font-size-spacer: $ci-font-size * 1.2;
$ci-label-top: $ci-border-size + ($ci-font-size-spacer / 2);
$ci-label-left: $ci-border-size + $ci-shift-x;

// padding
$ci-padding-x: $ci-shift-x;
$ci-padding-y: $ci-shift-y;

$ci-padding-top: $ci-label-top + $ci-font-size-spacer;
$ci-padding-right: $ci-padding-x;
$ci-padding-bottom: $ci-label-top;
$ci-padding-left: $ci-padding-x;

// shadows
$i-x: -3px;
$i-y: -3px;
$i-blur: 72px;
$i-spread: -70px;
$i-opacity: 0.7;
$ci-shadow-color: lighten($ci-border-color, 1);
$i-color: invert($ci-shadow-color);

// transitions
$ci-transition: all 0.1s linear;
$ci-transition-label: all 0.1s linear;

// measurements when focused
$ci-label-font-size-focused: $ci-label-font-size * $ci-small;
$ci-font-size-focused: $ci-font-size * (1 / $ci-small);

$ci-padding-top-focused: $ci-padding-top * $ci-small;

@debug unquote('testo') rem-to-px($ci-font-size) unquote(' -> ') rem-to-px($ci-font-size-focused);
@debug unquote('label') $ci-label-font-size unquote(' -> ') $ci-label-font-size-focused;
@debug unquote('padding-top') rem-to-px($ci-padding-top) unquote(' -> ') rem-to-px($ci-padding-top-focused);

// styles
.custom-input {
    position: relative;

    &__label {
        position: absolute;
        top: $ci-label-top;
        left: $ci-label-left;
        color: $ci-color;
        font-size: $ci-label-font-size;
        font-weight: $ci-label-font-weight;
        text-transform: uppercase;
        letter-spacing: $ci-label-letter-spacing;
        line-height: 1;

        transition: $ci-transition-label;
    }

    &__input {
        @include border-radius($ci-border-radius);
        width: 100%;
        max-width: 400px;
        padding: $ci-padding-top $ci-padding-right $ci-padding-bottom $ci-padding-left;
        font-size: $ci-font-size;
        background-color: $ci-bg;
        @include gradient-directional(lighten($ci-bg, 2), lighten($ci-bg, 3), -5deg);
        border: $ci-border-size solid $ci-border-color;
        box-shadow: inset $i-x $i-y $i-blur $i-spread rgba($i-color, $i-opacity), 2px 4px 12px -2px rgba($i-color, 0.02), 4px 8px 24px -4px rgba($i-color, 0.04);
        line-height: 1;

        transition: $ci-transition;

        &::placeholder {
            color: $gray-500;
            // Override Firefox's unusual default opacity; see https://github.com/twbs/bootstrap/pull/11526.
            opacity: 0.4;
            transition: $ci-transition;
        }

        &:focus {
            padding-top: $ci-padding-top-focused;
            color: $dark;
            font-size: $ci-font-size-focused;
            border-color: darken($ci-border-color, 4);
            outline: none;
            transition: $ci-transition;
        }

    }

    &:focus-within &__label,
    &__input:focus + &__label {
        color: lighten($ci-color, 10);
        font-size: $ci-label-font-size-focused;
        transition: $ci-transition-label;
    }
}

.test-panel {
    margin-top: $spacer * 2.5;
    margin-bottom: $spacer * 2.5;
}
</style>
