<template>
<b-modal
    ref="modal"
    v-if="modal"
    size="lg"
    class="ua-prop-modal"
>
    <template slot="modal-header">
        <ui-title
            :title="modal.title"
            :has-container="false"
            :has-margin="false"
        />
    </template>
    <div
        v-if="modal.type == 'text'"
        v-html="modal.description"
        class="ua-prop-modal__text"
    >
    </div>
    <div
        v-else-if="modal.type == 'gallery'"
        class="ua-prop-modal__gallery"
    >
        <swiper
            :options="swiperOption"
            ref="mySwiper"
        >
            <!-- slides -->
            <swiper-slide
                v-for="image in modal.medias"
                :key="image.id"
            >
                <img
                    :src="image.thumb"
                    class="ua-prop-modal__image"
                    :alt="image.title"
                />
                <ui-title
                    class="ua-prop-modal__title"
                    :title="image.title"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                />
                <p
                    v-html="image.description"
                    class="ua-prop-modal__paragraph"
                ></p>
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
    </div>
    <template slot="modal-footer">
        <ui-button
            title="Close"
            :has-container="false"
            :has-margin="false"
            :has-padding="false"
            color="primary"
            @click="hide"
        />
    </template>
</b-modal>
</template>

<script>
import 'swiper/dist/css/swiper.css'
import {
    swiper,
    swiperSlide
}
from 'vue-awesome-swiper'

import {
    UiButton,
    UiParagraph,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'ModalPanel',
    components: {
        UiButton,
        UiParagraph,
        UiTitle,
        swiper,
        swiperSlide,
    },
    props: {
        modal: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            swiperOption: {

            }
        }
    },
    methods: {
        show: function () {
            this.$refs.modal.show()
        },
        hide: function () {
            this.$refs.modal.hide()
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.ua-prop-modal {
    &__image {
        width: 100%;
        max-width: 100%;
        height: auto;
    }

    &__title {
        padding-top: $spacer * 1.618;
    }

    &__paragraph {
        padding-top: $spacer;
    }
}
</style>
