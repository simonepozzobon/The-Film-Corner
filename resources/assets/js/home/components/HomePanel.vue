<template lang="html">
    <ui-container :full-width="true">
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
            <ui-row min-width="400px" align="center">
                <ui-block :size="6" :hasContainer="false">
                    <ui-button color="white" :block="true" @click.native="goToLogin">Login</ui-button>
                </ui-block>
            </ui-row>
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../ui'
export default {
    name: 'HomePanel',
    components: {
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
    },
    methods: {
        goToLogin: function() {
            this.$router.push({ name: 'login' })
        }
    }
}
</script>

<style lang="css" scoped>
</style>
