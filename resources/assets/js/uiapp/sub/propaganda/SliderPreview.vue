<template>
<div class="cp-preview">
    <div class="cp-preview__title">
        {{ movie | translate('title', $root.locale) }}
    </div>
    <div class="cp-preview__thumb">
        <ui-image
            :src="movie.thumb"
            :has-margin="false"
        />
    </div>
    <div class="cp-preview__modal">
        <ui-button
            :title="$root.getCmd('read_more')"
            color="yellow"
            align="center"
            :has-margin="false"
            :has-container="false"
            @click="openModal"
        />
        <ui-button
            :title="$root.getCmd('open')"
            color="yellow"
            align="center"
            :has-margin="false"
            :has-container="false"
            @click="changeVideo"
        />
    </div>
</div>
</template>

<script>
import {
    UiImage,
    UiButton,
}
from '../../../ui'

import TranslationFilter from '../../../TranslationFilter'

export default {
    name: 'SliderPreview',
    mixins: [TranslationFilter],
    components: {
        UiImage,
        UiButton,
    },
    props: {
        movie: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    methods: {
        openModal: function () {
            this.$emit('open-modal', this.movie)
        },
        changeVideo: function () {
            console.log('changeVideo');
            this.$emit('change-video', this.movie)
        }
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.cp-preview {
    background-color: rgba(0,0,0, 0.1);
    padding: $spacer;
    @include border-radius(5px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    &__title {
        text-align: center;
    }

    &__thumb {
        margin-top: $spacer;
    }

    &__modal {
        margin-top: $spacer;
    }
}
</style>
