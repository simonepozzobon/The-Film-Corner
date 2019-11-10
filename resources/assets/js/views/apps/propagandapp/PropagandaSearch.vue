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
                title="Advanced Search"
                font-size="h1"
                align="center"
                :uppercase="false"
                :has-container="true"
            />

            <ui-container :contain="true">
                <ui-app-search-form @search="performSearch" />
            </ui-container>
        </ui-row>
    </ui-hero-banner>
    <ui-app-channel-results
        :contents="results"
        :title="title"
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
    UiAppChannelResults,
    UiAppSearchForm,
}
from '../../../uiapp'

export default {
    name: 'PropagandaHome',
    components: {
        UiAppChannelResults,
        UiAppSearchForm,
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
            title: null,
            results: [],
        }
    },
    watch: {
        results: function (results) {
            if (results.length > 0) {
                this.title = 'My results'
            }
            else {
                this.title = null
            }
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
            this.debug()
        },
        debug: function () {
            // this.selectChannel(this.channels[2])
        },
        enter: function () {},
        leave: function () {},
        performSearch: function (query) {
            // perform search request
            console.log(query);
        },

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
