<template lang="html">
    <ui-container class="network-container" :contain="true">
        <net-folder
            v-if="item"
            :color="item.app.category.color_class"
            :title="item.title"
            :app="item.app.title"
            :cat="item.app.category.name"/>

        <net-preview
            v-if="hasPreview && hasContent"
            ref="preview"
            :type="content.media_type"
            :src="content.featured_media"
            :thumb="content.thumb"/>

        <net-player-controls
            v-if="hasControls && hasContent"
            @play="play"
            @pause="pause"
            @stop="stop"
            @forward="forward"
            @backward="backward"/>

        <net-content
            v-if="item && hasContent"
            :color="item.app.category.color_class"
            :notes="content.notes"/>
    </ui-container>
</template>

<script>
import { UiContainer, UiRow } from '../../ui'
import { NetContent, NetFolder, NetPlayerControls, NetPreview } from '../../uinet'

export default {
    name: 'NetworkSingle',
    components: {
        NetContent,
        NetFolder,
        NetPlayerControls,
        NetPreview,
        UiContainer,
        UiRow,
    },
    data: function() {
        return {
            item: null,
            hasControls: true,
            hasPreview: true,
            hasContent: false,
            color: 'green',
        }
    },
    watch: {
        item: function(item) {
            if (this.content)
                this.hasContent = true
                console.log(this.content);
                if (this.content.media_type == 'video')
                    this.hasControls = true
            else
                this.content = false
        },
    },
    computed: {
        content: function() {
            if (this.item.content)
                return this.item.content

            return null
        },
    },
    methods: {
        getData: function() {
            let url = '/api/v2/get-network-single/' + this.$route.params.id
            this.$http.get(url).then(response => {
                if (response.data.success)
                    this.item = response.data.item
            })
        },
        play: function() {
            let player = this.$refs.preview.player
            player.play()
        },
        pause: function() {
            let player = this.$refs.preview.player
            player.pause()
        },
        stop: function() {
            let player = this.$refs.preview.player
            player.pause()
            player.currentTime(0)
        },
        backward: function() {
            let player = this.$refs.preview.player
            player.pause()
            let position = player.currentTime()
            if (position >= 5) {
                player.currentTime(position - 5)
            } else {
                player.currentTime(0)
            }
        },
        forward: function() {
            let player = this.$refs.preview.player
            player.pause()
            let position = player.currentTime()
        },
    },
    created: function() {
        this.getData()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
