<template>
<swiper-slide>
    <img
        :src="src"
        class="ua-prop-modal__image"
        :alt="title"
    />
    <ui-title
        class="ua-prop-modal__title"
        :title="title"
        :has-container="false"
        :has-padding="false"
        :has-margin="false"
    />
    <p
        v-html="description"
        class="ua-prop-modal__paragraph"
    ></p>
</swiper-slide>
</template>

<script>
import {
    UiTitle
}
from '../../../ui'

import {
    swiperSlide
}
from 'vue-awesome-swiper'

export default {
    name: 'ModalPanelImage',
    components: {
        UiTitle,
        swiperSlide,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            description: null,
        }
    },
    watch: {
        '$root.locale': function (locale) {
            this.translateDescription()
        }
    },
    computed: {
        src: function () {
            if (this.content && this.content.media) {
                return this.content.media
            }
        },
    },
    methods: {
        translateDescription: function () {
            let locale = this.$root.locale
            let description = this.content.translations.find(translation => translation.locale == locale)
            if (description) {
                this.description = description.content
            }
            else {
                this.description = this.content.content
            }
        }
    },
    mounted: function () {
        this.translateDescription()
    },
}
</script>
