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
        v-if="modal.type == 'text' && modal.hasOwnProperty('description')"
        class="ua-prop-modal__text"
    >
        <modal-panel-text :content="modal" />

    </div>
    <div v-else-if="modal.type == 'text' && modal.hasOwnProperty('paratext')">
        <ul>
            <modal-panel-link
                v-for="paratext in modal.paratext"
                :key="paratext.id"
                :content="paratext"
            />
        </ul>
    </div>
    <div
        v-else-if="modal.type == 'image'"
        class="ua-prop-modal__gallery"
    >
        <swiper
            :options="swiperOption"
            ref="mySwiper"
        >
            <!-- slides -->
            <modal-panel-image
                v-for="paratext in modal.paratext"
                :key="paratext.id"
                :content="paratext"
            />
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
            :title="$root.getCmd('close')"
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
}
from 'vue-awesome-swiper'

import {
    UiButton,
    UiParagraph,
    UiTitle,
}
from '../../../ui'

import ModalPanelImage from './ModalPanelImage.vue'
import ModalPanelLink from './ModalPanelLink.vue'
import ModalPanelText from './ModalPanelText.vue'

export default {
    name: 'ModalPanel',
    components: {
        UiButton,
        UiParagraph,
        UiTitle,
        swiper,
        ModalPanelImage,
        ModalPanelLink,
        ModalPanelText,
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
                autoHeight: true,
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

<style lang="scss">
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
