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
                    Contact Informations
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph :has-padding="false">
                <ui-title title="Contacts and Informations" />
                Fondazione Cineteca Italiana<br>
                Viale Fulvio Testi, 121<br>
                20126 Milan<br>
                Tel. +39 02 87 24 21 14<br>
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                Info:<br>
                <a href="mailto:thefilmcorner@cinetecamilano.it">thefilmcorner@cinetecamilano.it</a><br>
            </ui-paragraph>
            <ui-paragraph :has-padding="false">
                Press Office:<br>
                Cristiana Ferrari<br>
                <a href="mailto:ufficiostampa@cinetecamilano.it">ufficiostampa@cinetecamilano.it</a><br>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiSpecialText, UiTitle } from '../../ui'

export default {
    name: 'ConferenceContact',
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
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
