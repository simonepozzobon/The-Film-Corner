<template>
<div class="a-clip-panel__group">
    <ui-title
        title="Carica Clip"
        tag="span"
        font-size="h4"
        :has-padding="false"
        :has-margin="false"
        :has-container="false"
    />
    <hr class="a-clip-panel__divider">

    <div class="a-clip-panel__row form-group row">
        <label
            for="title"
            class="col-md-1"
        >
            Titolo
        </label>
        <div class="col-md-11">
            <input
                type="text"
                name="title"
                class="form-control"
                v-model="title"
            />
        </div>
    </div>

    <file-input
        label="Video"
        name="video"
        accept="video/mp4"
        label-size="col-md-1"
        input-size="col-md-11"
        :has-crop="false"
        :has-preview="false"
        @update="updateFile"
    />

    <div
        class="a-clip-panel__row form-group row preview"
        ref="preview"
    >
        <label
            for="video-preview"
            class="col-md-1"
        >
            Anteprima video
        </label>
        <div class="col-md-11">
            <div class="ua-video-preview">
                <video-player
                    class="video-player-box ua-video-preview__player"
                    ref="player"
                    :options="playerOptions"
                    :playsinline="true"
                    @ready="previewReady"
                />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../../adminui'
import 'video.js/dist/video-js.css'
import {
    videoPlayer
}
from 'vue-video-player'

import {
    UiButton,
    UiTitle,
}
from '../../../ui'

import {
    TimelineMax,
    Power4,
    CSSPlugin,
}
from 'gsap'

export default {
    name: 'CaricaClip',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
        videoPlayer,
    },
    data: function () {
        return {
            isLoading: false,
            master: null,
            title: null,
            video: null,
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: '/video/empty-session.mp4'
                }],
                poster: '/video/empty-session.png',
            },
        }
    },
    watch: {
        title: function () {
            this.$emit('update', 'title', this.title)
        },
    },
    methods: {
        updateFile: function (file, src) {
            this.video = file
            this.isLoading = true
            this.changeSrc(src)
        },
        initAnim: function () {
            CSSPlugin.defaultTransformPerspective = 500
            let container = this.$refs.preview

            this.master = new TimelineMax({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', '+=0')

            this.master.from(container, .6, {
                height: 0,
                ease: Power4.easeInOut,
            })
            this.master.set(container, {
                height: 'auto'
            })

            this.master.progress(1).progress(0)
        },
        changeSrc: function (src = null) {
            return new Promise((resolve, reject) => {
                if (src) {
                    this.playerOptions.sources[0]['src'] = src
                    this.playerOptions.poster = ''
                    this.$nextTick(resolve)
                }
                else {
                    reject()
                }
            })
        },
        previewReady: function () {
            if (this.isLoading) {
                this.$nextTick(() => {
                    this.showPlayer()
                    this.isLoading = false
                })
            }
        },
        showPlayer: function () {
            if (this.master) {
                this.master.play()
            }
        },
        hidePlayer: function () {
            if (this.master) {
                this.master.reverse()
            }
        }
    },
    mounted: function () {
        this.initAnim()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.preview {
    overflow: hidden;
}

// .a-clip-panel__group {
//     background-color: rgba($red, .3);
// }
.ua-video-preview {
    width: 100%;
    height: 100%;
    @include border-radius($spacer / 2);
    background-color: $dark-gray;
    overflow: hidden;
    z-index: 1;

    &__player {
        max-width: 100%;
    }
}
</style>
