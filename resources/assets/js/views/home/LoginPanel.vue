<template lang="html">
    <login-form
        ref="login"/>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../../ui'
import LoginForm from './LoginForm.vue'

export default {
    name: 'LoginPanel',
    components: {
        LoginForm,
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
    data: function() {
        return {
            open: false,
        }
    },
    methods: {
        // init: function() {
        //     if (this.master) {
        //         this.master.kill()
        //     }
        //
        //     let container = this.$refs.container.$el
        //     let buttons = container.getElementsByClassName('login-button')
        //
        //     let rect = container.getBoundingClientRect()
        //     let height = rect.height
        //
        //     this.master = new TimelineMax({
        //         paused: true,
        //     })
        //
        //     this.master.staggerFromTo(buttons, .3, {
        //         scale: 1,
        //         autoAlpha: 1,
        //     }, {
        //         scale: 0,
        //         autoAlpha: 0,
        //     }, .02, 0)
        //
        //     this.master.fromTo(container, .3, {
        //         x: 0,
        //         height: height,
        //     }, {
        //         x: 20,
        //         height: 0,
        //     }, 0)
        //
        //     this.master.progress(1).progress(0)
        //     this.master.eventCallback('onComplete', () => {
        //         this.open = true
        //         this.$refs.login.show()
        //     })
        //     this.master.eventCallback('onReverseComplete', () => {
        //         this.open = false
        //     })
        // },
        // toggle: function() {
        //     if (this.open) {
        //         this.master.reverse()
        //     } else {
        //         this.master.play()
        //     }
        // },
        goTo: function(name) {
            this.toggle()
        },
        goToHome: function() {
            this.$router.push({ name: 'home' })
        }
    },
    mounted: function() {
        // this.init()
        this.$refs.login.show()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

</style>
