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
                    Accomodation
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-title title="Novotel Milano Nord Cà Granda" />
            <ui-paragraph :has-padding="false">
                Viale Suzzani 13, Milano<br>
                MM Cà Granda<br>
                Reservation: <a href="mailto:H1140-FO@accor.com">H1140-FO@accor.com</a><br>
                <i>(please specify: “Richiesta prenotazione The Film Corner”)</i>
            </ui-paragraph>
        </ui-container>
        <ui-container class="pb-5" :contain="true">
            <ui-title title="Hotel Ibis Cà Granda" />
            <ui-paragraph :has-padding="false">
                Viale Suzzani 13, Milano<br>
                MM Cà Granda<br>
                Reservation: <a href="mailto:h1135@accor.com ">h1135@accor.com </a><br>
                <i>(please specify: “Richiesta prenotazione The Film Corner”)</i>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTeam, UiTitle } from '../../ui'
export default {
    name: 'Accomodation',
    components: {
        UiBlock,
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTeam,
        UiTitle,
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
