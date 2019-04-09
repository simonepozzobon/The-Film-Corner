<template lang="html">
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg" :full-width="true">
            <ui-container :full-width="true">
                <ui-row>
                    <ui-block :size="4" color="green">
                        <ui-title title="Welcome" color="white" size="h4"/>
                        <ul class="block-menu">
                            <li class="block-menu__menu-head">Inquadratura</li>
                            <li class="block-menu__menu-item">Confronta le immagini</li>
                            <li class="block-menu__menu-item">Componi l’inquadratura</li>
                            <li class="block-menu__menu-item">Ritaglia l’inquadratura</li>
                            <li class="block-menu__menu-div"></li>
                            <li class="block-menu__menu-head">Montaggio</li>
                            <li class="block-menu__menu-item">Montaggio parallelo</li>
                            <li class="block-menu__menu-item">Fuoricampo</li>
                        </ul>
                    </ui-block>
                    <ui-block :size="4" color="red">
                        <ui-title title="Film Specific" color="white" size="h4"/>
                        <ul class="block-menu">
                            <li class="block-menu__menu-head">Inquadratura</li>
                            <li class="block-menu__menu-item">Confronta le immagini</li>
                            <li class="block-menu__menu-item">Componi l’inquadratura</li>
                            <li class="block-menu__menu-item">Ritaglia l’inquadratura</li>
                            <li class="block-menu__menu-div"></li>
                            <li class="block-menu__menu-head">Montaggio</li>
                            <li class="block-menu__menu-item">Montaggio parallelo</li>
                            <li class="block-menu__menu-item">Fuoricampo</li>
                            <li class="block-menu__menu-div"></li>
                            <li class="block-menu__menu-head">Suono</li>
                            <li class="block-menu__menu-item">Cosa sta succedendo?</li>
                            <li class="block-menu__menu-item">Effetti sonori</li>
                        </ul>
                    </ui-block>
                    <ui-block :size="4" color="yellow">
                        <ui-title title="Creative Studio" color="white" size="h4"/>
                        <ul class="block-menu">
                            <li class="block-menu__menu-head">Riscaldamento</li>
                            <li class="block-menu__menu-item">Montaggio parallelo attivo</li>
                            <li class="block-menu__menu-item">Fuoricampo attivo</li>
                            <li class="block-menu__menu-item">Laboratorio sonoro</li>
                            <li class="block-menu__menu-div"></li>
                            <li class="block-menu__menu-head">Story Telling</li>
                            <li class="block-menu__menu-item">Costruisci il personaggio</li>
                            <li class="block-menu__menu-item">Storytelling</li>
                            <li class="block-menu__menu-div"></li>
                            <li class="block-menu__menu-head">Concorso MyCorner</li>
                            <li class="block-menu__menu-item">Minuto Lumiére</li>
                            <li class="block-menu__menu-item">Gira il tuo film</li>
                        </ul>
                    </ui-block>
                </ui-row>
            </ui-container>
        </ui-hero-banner>
    </ui-container>
</template>

<script>
import { UiBlock, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'

export default {
    name: 'ConferenceHome',
    components: {
        UiBlock,
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
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

.block-menu {
    text-align: center;
    list-style-type: none;
    padding-inline-start: 0;
    color: $white;
    font-size: $font-size-base;

    &__menu-item {
        cursor: pointer;
    }

    &__menu-div {
        margin-bottom: $spacer;
    }

    &__menu-head {
        font-weight: $font-weight-bold;
        cursor: pointer;
    }

    &__menu-item,
    &__menu-head {
        &:hover {
            text-decoration: underline;
        }
    }
}
</style>
