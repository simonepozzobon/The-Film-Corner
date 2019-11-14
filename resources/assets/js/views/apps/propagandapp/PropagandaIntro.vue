<template>
<ui-container>
    <ui-hero-banner
        image="/img/grafica/propaganda/bg-home-80.jpg"
        :full-width="true"
    >
        <ui-row
            align="center"
            ver-align="center"
        >

            <ui-block size="8">
                <ui-title
                    color="white"
                    font-size="h1"
                    align="center"
                    :uppercase="true"
                    :has-container="false"
                >
                    Propagand<span class="text-red">app</span>
                </ui-title>

                <ui-title
                    :title="$root.getCmd('the_project')"
                    color="white"
                    font-size="h4"
                    align="center"
                    :uppercase="true"
                    :has-container="false"
                />

                <ui-paragraph
                    color="white"
                    align="center"
                    size="lg"
                >
                    The app map proposal has been designed on the basis of the previous discussion among partners in order to create an interactive didactical resource that could join history and film around the topic of propaganda.
                    The app is aimed at building paths around different sub-topics related to propaganda that would help teachers conveying concepts and ideas around this topic through the general action of promoting analysis and reflection around
                    the use of film language in order to convey certain moods and feelings, that is at the very heart of propaganda.
                </ui-paragraph>

                <ui-button
                    color="red"
                    @click="goToHome"
                >
                    {{ this.$root.getCmd('enter') }}
                </ui-button>
            </ui-block>

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
    UiSpecialText,
    UiTitle,
    UiRow,
}
from '../../../ui'
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
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    methods: {
        goToHome: function () {
            this.$root.goTo('propaganda-home')
        },
        leave: function () {

        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
