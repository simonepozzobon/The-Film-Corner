<template lang="html">
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Conference"
                    color="white"/>
                <ui-special-text color="white" align="center">
                    Downloads & Press
                </ui-special-text>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                The Film Corner International Conference is open to the public and addressed to professionals and trainers of film education, media education, information and communication technology as well as gaming professionals. The conference will take place during the 9th edition of Piccolo Grande Cinema Festival in Milan, a film festival dedicated to young audiences organised by Fondazione Cineteca Italiana. The main issues of the conference are:
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
