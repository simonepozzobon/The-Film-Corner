<template>
<div class="video-slider-preview">
    <div class="video-slider-preview__image">
        <ui-image
            :src="movie.thumb"
            :has-margin="false"
        />
    </div>
    <div class="video-slider-preview__button mt-2">
        <ui-button
            :title="$root.getCmd('open')"
            color="yellow"
            align="center"
            @click="openModal"
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
export default {
    name: 'VideoSliderPreview',
    components: {
        UiImage,
        UiButton
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
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.video-slider-preview {
    cursor: pointer;
}
</style>
