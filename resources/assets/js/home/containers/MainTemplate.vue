<template lang="html">
    <div class="">
        <ui-container>
            <ui-hero-banner image="./img/grafica/bg.jpg">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Welcome to The Film Corner Reloaded"
                    color="white"/>

                <ui-special-text color="white" align="center">
                    To access all the activities<br>
                    you need to register
                </ui-special-text>

                <ui-container>
                    <ui-row min-width="400px">
                        <ui-block :size="6" :hasContainer="false">
                            <ui-button color="white" :block="true">Register</ui-button>
                        </ui-block>
                        <ui-block :size="6" :hasContainer="false">
                            <ui-button color="white" :block="true">Login</ui-button>
                        </ui-block>
                    </ui-row>
                </ui-container>
            </ui-hero-banner>
            <ui-title title="The Project" :is-main="true"/>
            <ui-paragraph align="center">
                THE FILM CORNER. Online and offline activities for Film Literacy” project is aimed to the design, release and testing of an online digital virtual user- centered platform for Film Literacy, taking advantage of the opportunities offered by web 2.0 and crossmedia innovative approach in the digital era in order to raise the average film literacy level of EU young audiences. The general aim of the project is to contribute to draw an easy-going model for Film Literacy that could improve Film Literacy skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience...
            </ui-paragraph>
            <ui-link url="#">Leggi tutto</ui-link>
        </ui-container>
        <news></news>
    </div>
</template>

<script>
import News from '../components/News.vue'
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../ui'
export default {
    name: 'MainTemplate',
    components: {
        News,
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
}
</script>

<style lang="css" scoped>

.test {
    min-width: 400px;
}
</style>
