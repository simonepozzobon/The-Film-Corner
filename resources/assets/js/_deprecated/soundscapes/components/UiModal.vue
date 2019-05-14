<template lang="html">
    <div ref="modal" class="modal fade" id="library-preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ title }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video-player
                        class="video-player-box"
                        ref="videoPlayer"
                        :options="playerOptions"
                        :playsinline="true">
                    </video-player>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'video.js/dist/video-js.css'
import {videoPlayer} from 'vue-video-player'

export default {
    name: 'UiModal',
    props: {
        title: {
            type: String,
            default: '',
        }
    },
    data: function() {
        return {
            playerOptions: {
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: ''
                }],
                poster: '/img/test-app/1.png',
            }
        }
    },
    methods: {
        changeSrc: function(src, poster) {
            this.playerOptions.sources[0].src = '/storage/' + src
            this.playerOptions.poster = '/storage/' + poster
            $(this.$refs.modal).modal('show')
            $(this.$refs.modal).on('hide.bs.modal', () => {
                this.$refs.videoPlayer.player.pause()
                this.$refs.videoPlayer.player.currentTime(0)
            })

        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
</style>
