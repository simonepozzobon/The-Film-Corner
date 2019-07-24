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
    <ui-app-channel-results />
</ui-container>
</template>

<script>
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
            channels: [{
                period: '1917',
                color: 'red',
                label: 'Russian Revolution',
            }, {
                period: '1922-1945',
                color: 'orange',
                label: 'Fascism and Nazism',
            }, {
                period: '1939-1945',
                color: 'green-var',
                label: 'Second World War',
                isActive: true,
            }, {
                period: '1946-1990',
                color: 'teal',
                label: 'Cold war',
            }],
        }
    },
    watch: {
        '$root.user': function (user) {
            this.setWelcome()
        }
    },
    methods: {
        setWelcome: function () {
            this.title = 'Welcome ' + this.$root.user.name
            console.log(this.title);
        },
        enter: function () {},
        leave: function () {},
        selectChannel: function (channel) {

        }

    },
    mounted: function () {
        this.$nextTick(this.setWelcome)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
