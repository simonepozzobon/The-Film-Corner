<template>
<swiper
    :options="swiperOption"
    ref="mySwiper"
    class="slider-library"
>
    <!-- slides -->
    <swiper-slide
        class="slider-library__slide"
        v-for="clip in clips"
        :key="clip.id"
    >
        <ui-image
            class="slider-library__img"
            :src="clip.image.thumb"
            :alt="clip.title"
            :full-width="true"
            @click="changeVideo(clip)"
        />
    </swiper-slide>
    <!-- Optional controls -->
    <div
        class="swiper-pagination"
        slot="pagination"
    ></div>
    <div
        class="swiper-button-prev"
        slot="button-prev"
    ></div>
    <div
        class="swiper-button-next"
        slot="button-next"
    ></div>
</swiper>
</template>

<script>
import 'swiper/dist/css/swiper.css'
import {
    swiper,
    swiperSlide
}
from 'vue-awesome-swiper'

import {
    UiImage,
}
from '../../../ui'

export default {
    name: 'SliderLibrary',
    components: {
        swiper,
        swiperSlide,
        UiImage,
    },
    props: {
        clips: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {
            swiperOption: {
                slidesPerView: 3,
                spaceBetween: 30,
            }
        }
    },
    methods: {
        changeVideo: function (clip) {
            this.$emit('change-video', clip)
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.slider-library {
    margin-top: $spacer * 2;
}
</style>
