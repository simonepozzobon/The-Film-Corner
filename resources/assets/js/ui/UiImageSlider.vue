<template>
<swiper
    :options="swiperOption"
    ref="mySwiper"
    class="slider-library"
>
    <!-- slides -->
    <swiper-slide
        class="slider-library__slide"
        v-for="image in images"
        :key="image.id"
    >
        <img
            class="slider-library__img"
            :src="image.thumb"
            :alt="image.title"
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

import UiImage from './UiImage.vue'

export default {
    name: 'SliderLibrary',
    components: {
        swiper,
        swiperSlide,
        UiImage,
    },
    props: {
        images: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {
            swiperOption: {
                slidesPerView: 6,
                spaceBetween: 30,
            }
        }
    },
    methods: {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.slider-library {
    margin-top: $spacer * 2;

    &__slide {
        overflow: hidden;
        @include border-radius(12px);
    }

    &__img {
        max-width: 100%;
        height: auto;
    }
}
</style>
