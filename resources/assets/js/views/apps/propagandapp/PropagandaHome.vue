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
                <ui-roadmap />
            </ui-row>
        </ui-hero-banner>
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
    } from '../../../ui'
    export default {
        name: 'PropagandaHome',
        components: {
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
        methods: {
            enter: function () {},
            leave: function () {}
        },
    }
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
