<template lang="html">
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="International Conference"
                    color="white"/>
                <ui-special-text color="white" align="center">
                    General Informations
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph :has-padding="false">
                The conference is part of The Film Corner project aimed to the creation of an online interactive platform for film education addressed to European schools.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Where and When"/>
                2017, Thu, November 9th, 5pm Italian time, MIC-Interactive Film Museum, viale Fulvio Testi, 121, Milan, Italy<br>
                2017, Fri, November, 10th, 9 am-6 pm Italian time, Cinema Oberdan, Viale Vittorio Veneto, 2, Milan, Italy
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="The Film Corner An Introduction"/>
                The Film Corner. Online and offline activities for Film Literacy project aims to design, release and test an online platform for film education, exploiting the opportunities available through web 2.0 and thus developing innovative crossmedia approaches to teaching appropriate to the digital era in order to raise the levels of film literacy of young audiences across the European Union.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                The project involves 5 European institutions in 4 EU countries: Fondazione Cineteca Italiana (Milan, Italy) as coordinator; The Film Space (London, UK); The Nerve Centre (Derry, Northern Ireland); Jugoslovenska Kinoteka, the National Cinèmatheque of Serbia (Serbia, Belgrade); University of Milano Bicocca-Dipartimento di Scienze Umane per la Formazione Riccardo Massa (Milan, Italy). The platform includes interactive didactical resources with which the users can engage and thus develop their film literacy skills. The pedagogical resources will focus on film education skills explored through a number of EU national and non-national films.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                The Film Corner. Online and offline activities for Film Literacy project is co-financed by the European Union in the context of the Creative Europe Programme of the European Union.
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                <ui-title title="Registration and Deadline"/>
                There are 180 places available for the conference and it is free of charge. If you’d like to join us, you can register using the form below until 2017, october, 10th. Keep updated through our social media accounts on Facebook and Twitter. Further details will be announced on the official website of The Film Corner.
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiSpecialText, UiTitle } from '../../ui'

export default {
    name: 'ConferenceHome',
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiSpecialText,
        UiTitle,
    },
    data: function() {
        return {
        }
    },
    mounted: function() {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
