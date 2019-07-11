<template>
    <div>
        <div class="row mt">
            <preview
                :title="preview_text"
                ref="preview"
            />
            <library
                :title="library_text"
                :library_media="library_media_parsed"
                :library_audio="library_audio_parsed"
            />
        </div>
        <control-bar/>
        <mixer />
        <selector-modal
            title="Select Channel"
            ref="selector"
        />
        <div id="waveform-0" class="d-none" ref="wave1"></div>
        <div id="waveform-1" class="d-none" ref="wave2"></div>
        <div id="waveform-2" class="d-none" ref="wave3"></div>
        <div id="waveform-3" class="d-none" ref="wave4"></div>
        <div id="waveform-4" class="d-none" ref="wave5"></div>
        <div id="waveform-5" class="d-none" ref="wave6"></div>
    </div>
</template>

<script>
import ControlBar from './ControlBar.vue'
import Library from './Library.vue'
import Mixer from './Mixer.vue'
import Preview from './Preview.vue'
import SelectorModal from './SelectorModal.vue'

import WaveSurfer from 'wavesurfer.js'
import RegionsPlugin from 'wavesurfer.js/src/plugin/regions.js'

export default {
    name: 'Soundscapes',
    components: {
        ControlBar,
        Library,
        Mixer,
        Preview,
        SelectorModal,
    },
    props: {
        preview_text: {
            type: String,
            default: '',
        },
        library_text: {
            type: String,
            default: '',
        },
        library_audio: {
            type: String,
            default: '',
        },
        library_media: {
            type: String,
            default: '',
        },
        random_image: {
            type: String,
            default: '',
        },
        open: {
            type: Boolean,
            default: false,
        },
        src: {
            type: String,
            default: null
        },
        vols: {
            type: String,
            default: null
        },
    },
    data: function() {
        return {
            players: null
        }
    },
    computed: {
        library_media_parsed: function() {
            if (this.library_media) {
                return JSON.parse(this.library_media)
            }
            return []
        },
        library_audio_parsed: function() {
            if (this.library_audio) {
                return JSON.parse(this.library_audio)
            }
            return []
        }
    },
    mounted: function() {
        if (this.open) {
            this.$root.srcs = JSON.parse(this.src)
        }
        this.$root.imageSelected = this.random_image
    }
}
</script>

<style lang="css">
</style>
