<template>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Filmography"
                    color="white"/>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                <ui-list>
                    <ui-list-item
                        v-for="(item, i, key) in this.filmography"
                        :key="key">
                        {{ item.text }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import filmography from '../dummies/filmography'
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiTitle } from '../ui'

export default {
    name: 'Filmography',
    components: {
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiTitle,
    },
    data: function() {
        return {
            filmography: filmography,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
