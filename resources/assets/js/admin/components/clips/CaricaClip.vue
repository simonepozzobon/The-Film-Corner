<template>
<block-panel
    title="Clip"
    :initial-state="initialState"
    :has-footer="true"
>
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
    <template v-slot:footer>
        <ui-button
            title="salva"
            color="green"
            theme="outline"
            :disable="isLoading"
            :has-spinner="isLoading"
            :has-margin="false"
            :has-container="false"
            @click="save"
        />
    </template>
</block-panel>
</template>

<script>
import {
    BlockPanel,
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
    gsap,
    TweenMax,
    TimelineMax,
    Power4,
    CSSPlugin
}
from 'gsap/all'

const plugins = [Power4, CSSPlugin]

export default {
    name: 'CaricaClip',
    components: {
        BlockPanel,
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
    props: {
        initialState: {
            type: Boolean,
            default: false,
        },
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            isLoading: false,
            id: null,
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
            keys: ['id', 'title', 'video'],
        }
    },
    watch: {
        title: function (title) {
            this.$emit('update', 'title', title)
        },
        video: function (video) {
            this.$emit('update', 'video', video)
        },
        initials: function (initials) {
            // console.log('winitials', this.initials);
            for (let i = 0; i < this.keys.length; i++) {
                let key = this.keys[i]
                if (initials.hasOwnProperty(key)) {
                    this[key] = initials[key]
                }
            }

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

            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start')

            this.master.fromTo(container, .6, {
                height: '0',
            }, {
                height: 'auto',
                ease: Power4.easeInOut,
            }, 'start')

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
        },
        save: function () {
            this.isLoading = true

            let data = new FormData()

            if (this.id != null && this.id > 0) {
                data.append('id', this.id)
            }

            data.append('title', this.title)
            data.append('video', this.video)

            this.$http.post('/api/v2/admin/clips/create-clip', data).then(response => {
                this.isLoading = false
                this.$emit('saved', response.data.clip)
            }).catch(() => {
                this.isLoading = false
            })
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
