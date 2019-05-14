<template lang="html">
    <ui-block
        class="net-item"
        :class="colorClass"
        :size="4"
        :full-height="true">
        <div
            class="net-item__preview"
            @click="$root.goToWithParams('network-single', {id: idx})">
            <div class="net-item__overlay"></div>
            <img :src="previewSrc" :alt="title" class="net-item__image">
        </div>
        <div class="net-item__details">
            <ui-title
                :title="title"
                :color="titleColor"
                align="center"
                :has-margin="false"
                :hoverable="true"
                @click.native="$root.goToWithParams('network-single', {id: idx})"/>
            <div class="net-item__category">
                {{ category }}
            </div>
            <div class="net-item__app">
                {{ appName }}
            </div>
            <net-interactions
                class="net-item__interactions"
                :color="titleColor"
                :comments="comments"
                :likes="likes"
                :views="views"/>
        </div>
    </ui-block>
</template>

<script>
import { UiBlock, UiTitle } from '../ui'
import NetInteractions from './NetInteractions.vue'
export default {
    name: 'NetItem',
    components: {
        UiBlock,
        UiTitle,
        NetInteractions,
    },
    props: {
        idx: {
            type: Number,
            default: null,
            required: true,
        },
        color: {
            type: String,
            default: 'green'
        },
        previewType: {
            type: String,
            default: 'image'
        },
        previewSrc: {
            type: String,
            default: '/img/test-app/1.png'
        },
        title: {
            type: String,
            default: 'Titolo'
        },
        category: {
            type: String,
            default: 'Categoria',
        },
        categorySlug: {
            type: String,
            default: null,
        },
        appName: {
            type: String,
            default: 'AppName'
        },
        appSlug: {
            type: String,
            default: null
        },
        views: {
            type: Number,
            default: 0,
        },
        likes: {
            type: Number,
            default: 0,
        },
        comments: {
            type: Number,
            default: 0,
        }
    },
    computed: {
        titleColor: function() {
            if (this.color == 'yellow') {
                return 'dark'
            }
            return 'white'
        },
        colorClass: function() {
            return 'net-item--' + this.color
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-item {
    margin-bottom: $spacer * 2;

    &__image {
        max-width: 100%;
        max-height: 100%;
        width: 100%;
    }

    &__preview {
        position: relative;
        overflow: hidden;
        @include border-radius(8px);
    }

    &__overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 1;
    }

    &__details {
        width: 100%;
        padding: $spacer;
        @include border-radius(8px);
    }

    &__category,
    &__app {
        color: $white;
        text-align: center;
    }

    &--green & {
        &__details {
            background-color: $green;
        }

        &__overlay {
            background-color: rgba($green, .3);
        }
    }

    &--yellow & {
        &__details {
            background-color: $yellow;
        }

        &__overlay {
            background-color: rgba($yellow, .3);
        }

        &__category,
        &__app {
            color: $black;
        }
    }

    &--red & {
        &__details {
            background-color: $red;
        }

        &__overlay {
            background-color: rgba($red, .3);
        }
    }
}
</style>
