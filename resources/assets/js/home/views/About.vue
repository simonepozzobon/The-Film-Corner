<template lang="html">
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="The Project"
                    color="white"/>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                “THE FILM CORNER. Online and offline activities for Film Literacy” project is aimed to the design, release and testing of an online digital virtual user-centered platform for Film Literacy, taking advantage of the opportunities offered by web 2.0 and crossmedia innovative approach in the digital era in order to raise the average film literacy level of EU young audiences. The general aim of the project is to contribute to draw an easy-going model for Film Literacy that could improve Film Literacy skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience.
            </ui-paragraph>
            <ui-paragraph>
                The platform consists of an interactive narrative-based environmental layout with game-based didactical resources integrated as apps the user can interact with. Didactical resources will be both based on generic Film Literacy skills and on a set of EU national and non-national films. The platform is to be developed in at least 4 EU languages including english, french, italian and serbian.
            </ui-paragraph>
            <ui-paragraph>
                In november 2017, an international conference will take place in the frame of the 10th edition of “Piccolo Grande Cinema” Festival, a film festival dedicated to young audience promoted by Fondazione Cineteca Italiana. During the international conference the platform blueprint will be officially presented and some panels discussing several issues concerning Film Literacy, cross-media and Audience Development and engagement will be discussed. A call for papers will be issued and keynote speakers, including representants from other film literacy project financed in the frame of the Creative Europe Programme will be invited.
            </ui-paragraph>
            <ui-paragraph>
                <ui-list>
                    <ui-list-item>
                        PROJECT TITLE: The Film Corner. New online and offline activities for Film Literacy
                    </ui-list-item>
                    <ui-list-item>
                        CONTRACT REFERENCE: 2016-2127/001-001-577573-CREA-1-2016-1-IT-MED-AUDEV
                    </ui-list-item>
                    <ui-list-item>
                        LEADING INSTITUTION: Fondazione Cineteca Italiana, Milan, Italy
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiTitle } from '../ui'

export default {
    name: 'About',
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiTitle,
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
