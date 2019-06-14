<template>
<ui-container>
    <ui-hero-banner
        image="/img/grafica/propaganda/bg-app-80.jpg"
        :full-width="true"
    >
        <ui-row
            align="center"
            ver-align="center"
        >
            <ui-title
                :title="title"
                font-size="h1"
                align="center"
                :uppercase="false"
                :has-container="true"
            />

            <ui-row
                :full-width="true"
                ver-align="center"
            >
                <ui-special-text
                    :has-padding="false"
                    display="inline-block"
                    class="mr-3"
                    text="search the clips and didactical content through the timeline below or through the advanced"
                />

                <ui-button
                    title="search engine"
                    color="red"
                    :has-container="false"
                    :has-margin="false"
                />
            </ui-row>

            <ui-roadmap />
        </ui-row>
    </ui-hero-banner>
    <ui-container>
        Contenuto
    </ui-container>
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
    UiRoadmap,
    UiSpecialText,
    UiTitle,
    UiRow,
} from '../../../ui'
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
        UiRoadmap,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function() {
        return {
            title: 'Welcome'
        }
    },
    watch: {
        '$root.user': function(user) {
            this.setWelcome()
        }
    },
    methods: {
        setWelcome: function() {
            this.title = 'Welcome ' + this.$root.user.name
            console.log(this.title);
        },
        enter: function() {},
        leave: function() {}
    },
    mounted: function() {
        this.$nextTick(this.setWelcome)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
