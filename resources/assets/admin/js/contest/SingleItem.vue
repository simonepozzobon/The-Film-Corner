<template lang="html">
    <div class="single-item">
        <div class="info thumb">
            <div class="play-btn">
                <i class="fa fa-play" @click="showPreview"></i>
            </div>
            <img :src="this.image" class="img-fluid">
        </div>
        <div class="info title">{{ session.title }}</div>
        <div class="info author">{{ author }} - ({{ authorEmail }})</div>
        <div class="info app">{{ appName }}</div>
        <div class="info date">{{ date }}</div>

        <div :id="'modal-'+this.session.token" class="modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Video Preview</div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <video :id="'video-'+this.session.token" class="embed-responsive-item video-js" controls preload="auto" width="640" height="264" :poster="this.image">
                                <source :src="this.video" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import videojs from 'video.js'

export default {
    name: 'SingleItem',
    props: {
        session: {
            type: Object,
            default: function() {},
        },
    },
    data: function() {
        return {
            player: {},
            playerReady: false,
        }
    },
    computed: {
        appName: function() {
            return this.session.app.title
        },
        author: function() {
            if (this.session.teacher) {
                return this.session.teacher.name
            }
            return null
        },
        authorEmail: function() {
            if (this.session.teacher) {
                return this.session.teacher.email
            }
            return null
        },
        date: function() {
            return moment(this.session.created_at).format('lll')
        },
        image: function() {
            if (this.session.img) {
                return this.session.img
            }
            return null
        },
        video: function() {
            if (this.session.video) {
                return this.session.video
            }
            return null
        },
    },
    methods: {
        loadPlayer: function() {
            this.player = videojs('video-'+this.session.token, {}, () => {
                this.playerReady = true
            })
        },
        resetPlayer: function() {
            if (this.playerReady) {
                this.player.pause()
                this.player.currentTime(0)
            }
        },
        showPreview: function() {
            $('#modal-'+this.session.token).modal('show')
        }
    },
    mounted: function() {
        this.loadPlayer()

        $('#modal-'+this.session.token).on('hide.bs.modal', e => {
            this.resetPlayer()
        })
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

    .single-item {
        display: table-row;

        > .info {
            display: table-cell;
            padding-bottom: $spacer / 2;


            &.thumb {
                position: relative;
                max-width: 64px;
                padding-right: $spacer;

                > .play-btn {
                    position: absolute;
                    width: 100%;
                    height: 100%;

                    > i {
                        position:absolute;
                        color: $tfc-dark-red;
                        left: calc(50% - 13px);
                        top: calc(50% - 8px);
                        transform: translate(-50%, -50%);
                        cursor: pointer;
                    }
                }
            }
        }
    }
</style>
