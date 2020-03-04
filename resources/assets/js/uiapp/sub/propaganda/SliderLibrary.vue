<template>
<swiper
    :options="swiperOption"
    ref="mySwiper"
    class="slider-library"
>
    <!-- slides -->
    <swiper-slide
        class="slider-library__slide"
        v-for="movie in movies"
        :key="movie.id"
    >
        <slider-preview
            :movie="movie"
            @open-modal="openModal"
            @change-video="changeVideo"
        />
    </swiper-slide>
    <!-- Optional controls -->
    <div
        class="swiper-pagination"
        slot="pagination"
    ></div>
    <div
        class="swiper-button-prev slider-library__prev"
        slot="button-prev"
        @click="slidePrev"
    ></div>
    <div
        class="swiper-button-next slider-library__next"
        slot="button-next"
        @click="slideNext"
    ></div>
</swiper>
</template>

<script>
import 'swiper/dist/css/swiper.css'
import SliderPreview from './SliderPreview.vue'
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
        SliderPreview,
        UiImage,
    },
    props: {
        movies: {
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
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            }
        }
    },
    methods: {
        changeVideo: function (movie) {
            console.log('library changed', movie);
            this.$emit('change-video', movie)
        },
        openModal: function (movie) {
            this.$emit('open-modal', movie)
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

<style lang="scss">
@import '~styles/shared';

.slider-library {
    margin-top: $spacer * 2;

    &__next,
    &__prev {
        background-color: $white;
        padding: $spacer * 2;
        @include border-radius(8px);
        z-index: 2;
    }
}
</style>
