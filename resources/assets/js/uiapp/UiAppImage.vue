<template>
    <div
        class="ui-app-image"
        :class="[
            colorClass,
            borderDirectionClass,
        ]">
        <ui-title
            :title="title"
            :color="titleColor"
            :has-padding="false"
            ref="title"/>
        <img :src="src" alt="" class="ui-app-image__image" />
    </div>
</template>

<script>
import { UiTitle } from '../ui'

export default {
    name: 'UiAppImage',
    components: {
        UiTitle,
    },
    props: {
        img: {
            type: String,
            default: '/img/test-app/1.png',
        },
        title: {
            type: String,
            default: 'title',
        },
        borderDirection: {
            type: String,
            default: 'left',
        },
        color: {
            type: String,
            default: 'dark-gray'
        },
        titleColor: {
            type: String,
            default: 'white',
        },
        src: {
            type: String,
            default: '/img/test-app/1.png',
        }
    },
    computed: {
        colorClass: function() {
            if (this.color != 'dark-gray') {
                return 'ui-app-image--' + this.color
            }
        },
        borderDirectionClass: function() {
            if (this.borderDirection == 'right') {
                return 'ui-app-image--border-right'
            } else {
                return 'ui-app-image--border-left'
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-image {
    width: 100%;
    height: 100%;
    background-color: $dark-gray;
    padding: $spacer;
    @include app-block-padding;

    &__image {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: auto;
    }

    &--border-left {
        @include border-left-radius(24px);
    }

    &--border-right {
        @include border-right-radius(24px);
    }

    &--green {
        background-color: $green;
    }
}
</style>
