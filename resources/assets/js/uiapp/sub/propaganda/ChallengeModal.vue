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
    <div class="ua-prop-modal__text">
        <div v-if="type == 'video'">
            <video-player
                class="video-player-box"
                ref="player"
                :options="playerOptions"
                :playsinline="true"
            />
        </div>
        <div v-else-if="type == 'image'">
            <ui-image :src="modal.url" />
        </div>
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
    UiButton,
    UiParagraph,
    UiTitle,
    UiImage,
}
from '../../../ui'

import 'video.js/dist/video-js.css'
import {
    videoPlayer
}
from 'vue-video-player'

export default {
    name: 'ChallengeModal',
    components: {
        UiButton,
        UiParagraph,
        UiTitle,
        UiImage,
        videoPlayer,
    },
    props: {
        modal: {
            type: Object,
            default: function () {
                return {}
            },
        },
        type: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/video/empty-session.mp4'
                }]
            },
        }
    },
    watch: {
        modal: function (modal) {
            if (this.type == 'video') {
                this.playerOptions.sources[0].src = this.modal.url
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
</style>
