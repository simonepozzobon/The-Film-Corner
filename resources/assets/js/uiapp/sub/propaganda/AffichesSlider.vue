<template>
<swiper
    :options="swiperOption"
    ref="mySwiper"
    class="affiches-library"
>
    <!-- slides -->
    <swiper-slide
        class="affiches-library__slide"
        v-for="affiche in affiches"
        :key="affiche.id"
    >
        <video-slider-preview
            :movie="affiche"
            @open-modal="openModal"
        />
    </swiper-slide>
    <!-- Optional controls -->
    <div
        class="swiper-pagination"
        slot="pagination"
    ></div>
    <div
        class="swiper-button-prev affiches-library__prev"
        slot="button-prev"
        @click="slidePrev"
    ></div>
    <div
        class="swiper-button-next affiches-library__next"
        slot="button-next"
        @click="slideNext"
    ></div>
</swiper>
</template>

<script>
import 'swiper/dist/css/swiper.css'
import VideoSliderPreview from './VideoSliderPreview.vue'
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
    name: 'VideoSlider',
    components: {
        swiper,
        swiperSlide,
        VideoSliderPreview,
        UiImage
    },
    props: {
        affiches: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {
            swiperOption: {
                slidesPerView: 5,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            }
        }
    },
    methods: {
        openModal: function (affiche) {
            // console.log('clicked slider');
            this.$emit('open-modal', affiche)
        },
        slideNext: function () {
            if (this.$refs.mySwiper && typeof this.$refs.mySwiper.slideNext === 'function') {
                this.$refs.mySwiper.slideNext()
            }
        },
        slidePrev: function () {
            if (this.$refs.mySwiper && typeof this.$refs.mySwiper.slidePrev === 'function') {
                this.$refs.mySwiper.slidePrev()
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.affiches-library {
    &__slide {
        max-width: 100%;
    }

    &__next,
    &__prev {
        background-color: $white;
        padding: $spacer * 2;
        @include border-radius(8px);
        z-index: 2;
    }
}
</style>
