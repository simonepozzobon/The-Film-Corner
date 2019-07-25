<template>
<ui-container>
    <ui-hero-banner
        image="/img/grafica/propaganda/bg-app-80.jpg"
        :full-width="true"
    >
        <ui-row
            align="center"
            ver-align="center"
        >
            <ui-title
                :title="title"
                font-size="h1"
                align="center"
                :uppercase="false"
                :has-container="true"
            />

            <ui-row
                :full-width="true"
                ver-align="center"
                align="center"
            >
                <ui-special-text
                    :has-padding="false"
                    display="inline-block"
                    class="mr-3"
                    text="search the clips and didactical content through the timeline below or through the"
                />

                <ui-button
                    title="Advanced search engine"
                    color="red"
                    :has-container="false"
                    :has-margin="false"
                />
            </ui-row>

            <ui-roadmap
                :channels="channels"
                @select-channel="selectChannel"
            />

            <ui-row
                align="center"
                :full-width="true"
            >
                <ui-button
                    title="Go to the creative challenges"
                    color="yellow"
                    :has-container="false"
                    :has-margin="false"
                />
            </ui-row>
        </ui-row>
    </ui-hero-banner>
    <ui-app-channel-results
        :contents="results"
        :title="currentChannelTitle"
    />
</ui-container>
</template>

<script>
import Channels from '../../../dummies/PropagandAppContent'
import Utility from '../../../Utilities'

import {
    UiBlock,
    UiButton,
    UiContainer,
    UiHeroBanner,
    UiHeroImage,
    UiLink,
    UiParagraph,
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow,
}
from '../../../ui'

import {
    UiAppChannelResults
}
from '../../../uiapp'

export default {
    name: 'PropagandaHome',
    components: {
        UiAppChannelResults,
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function () {
        return {
            title: 'Welcome',
            channels: [],
            currentChannel: null,
            results: [],
        }
    },
    watch: {
        '$root.user': function (user) {
            this.setWelcome()
        },
        currentChannel: function (channel) {
            this.results = channel.contents
        },
    },
    computed: {
        currentChannelTitle: function () {
            if (this.currentChannel && this.currentChannel.hasOwnProperty('label')) {
                return this.currentChannel.label
            }

            return null
        },
    },
    methods: {
        getData: function () {
            // perform api call
            this.channels = Channels
            this.debug()
        },
        debug: function () {
            this.selectChannel(this.channels[2])
        },
        setWelcome: function () {
            this.title = 'Welcome ' + Utility.capitalize(this.$root.user.name)
            // console.log(this.title);
        },
        enter: function () {},
        leave: function () {},
        selectChannel: function (selected) {
            this.channels = this.channels.map(channel => {

                delete channel.isActive

                if (channel.id == selected.id) {
                    channel.isActive = true
                }

                return channel
            })

            this.currentChannel = selected
        }

    },
    created: function () {
        this.getData()
    },
    mounted: function () {
        this.$nextTick(this.setWelcome)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
