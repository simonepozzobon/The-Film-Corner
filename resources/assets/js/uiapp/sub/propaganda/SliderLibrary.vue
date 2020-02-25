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
