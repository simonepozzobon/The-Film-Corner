<template>
<b-modal
    ref="modal"
    v-if="modal"
    size="lg"
    class="ua-prop-modal"
>
    <template slot="modal-header">
        <ui-title
            :title="modal | translate('title', $root.locale)"
            :has-container="false"
            :has-margin="false"
        />
    </template>
    <div class="ua-prop-modal__text">
        <video-player
            v-if="src"
            class="video-player-box ua-video-preview__player"
            ref="player"
            :options="playerOptions"
            :playsinline="true"
            @ready="$emit('ready')"
        />
        <p v-html="translatedDescription">
        </p>
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
import {
    UiTitle,
    UiButton
}
from '../../../ui'
import TranslationFilter from '../../../TranslationFilter'

import {
    videoPlayer
}
from 'vue-video-player'

export default {
    name: 'SliderModalPanel',
    mixins: [TranslationFilter],
    components: {
        UiTitle,
        UiButton,
        videoPlayer
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
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/video/empty-session.mp4'
                }],
                poster: '/video/empty-session.png',
            },
            src: null,
        }
    },
    watch: {
        modal: function () {
            console.log('modal changed');
        }
    },
    computed: {
        player: function () {
            return this.$refs.player.player
        },
        translatedDescription: function () {
            if (this.modal.hasOwnProperty('description')) {
                return this.$options.filters.translate(this.modal, 'description', this.$root.locale)
            }
            else if (this.modal.hasOwnProperty('details') && this.modal.details.length > 0) {
                let detail = this.modal.details[0]
                return this.$options.filters.translate(detail, 'abstract', this.$root.locale)
            }
            return this.$options.filters.translate(this.modal, 'description', this.$root.locale)
        },
    },
    methods: {
        show: function () {
            if (this.$refs.modal) {
                console.log('modal showing', this.modal);
                this.src = null

                if (this.modal.hasOwnProperty('video')) {
                    this.src = this.modal.video
                }
                else if (this.modal.hasOwnProperty('url')) {
                    this.src = this.modal.url
                }

                this.changeSrc()

                this.$nextTick(() => {
                    this.$refs.modal.show()
                })
            }
        },
        hide: function () {
            if (this.$refs.modal) {
                this.$refs.modal.hide()
            }
        },
        changeSrc: function () {
            if (this.src) {
                delete this.playerOptions.poster
                this.playerOptions.sources[0].src = this.src
                // console.log('dentro cambia', this.src);

                return true
            }

            return false
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
