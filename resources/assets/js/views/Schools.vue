<template lang="html">
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="Schools"
                    color="white"/>
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <ui-paragraph>
                <ui-title title="Italy" />
                <ui-list>
                    <ui-list-item
                        v-for="(item, i, key) in this.scIT"
                        :key="key">
                        {{ item.text }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="Northern Ireland" />
                <ui-list>
                    <ui-list-item
                        v-for="(item, i, key) in this.scNR"
                        :key="key">
                        {{ item.text }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="Serbia" />
                <ui-list>
                    <ui-list-item
                        v-for="(item, i, key) in this.scSR"
                        :key="key">
                        {{ item.text }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
            <ui-paragraph>
                <ui-title title="UK"/>
                <ui-list>
                    <ui-list-item
                        v-for="(item, i, key) in this.scUK"
                        :key="key">
                        {{ item.text }}
                    </ui-list-item>
                </ui-list>
            </ui-paragraph>
        </ui-container>
    </ui-container>
</template>

<script>
import { schoolsIT, schoolsNr, schoolsSR, schoolsUK } from '../dummies/schools'
import { UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiTitle } from '../ui'

export default {
    name: 'Schools',
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
            scIT: schoolsIT,
            scNR: schoolsNr,
            scSR: schoolsSR,
            scUK: schoolsUK,
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
