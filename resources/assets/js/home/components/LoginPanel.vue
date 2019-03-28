<template lang="html">
    <ui-container :full-width="true" ref="container">
        <ui-container direction="column">
            <ui-row min-width="400px" align="center" class="login-button">
                <ui-block :size="8" :hasContainer="false">
                    <ui-button color="white" :block="true" @click.native="goTo('teacher')">Teacher</ui-button>
                </ui-block>
            </ui-row>
            <ui-row min-width="400px" align="center" class="login-button">
                <ui-block :size="8" :hasContainer="false">
                    <ui-button color="white" :block="true" @click.native="goTo('student')">Student</ui-button>
                </ui-block>
            </ui-row>
            <ui-row min-width="400px" align="center" class="login-button">
                <ui-block :size="8" :hasContainer="false">
                    <ui-button color="white" :block="true" @click.native="goTo('guest')">Guest</ui-button>
                </ui-block>
            </ui-row>
        </ui-container>
        <ui-container direction="column" class="mt-4">
            <ui-row min-width="400px" align="center" class="login-button">
                <ui-block :size="8" :hasContainer="false">
                    <ui-button color="white" :block="true" @click.native="goToHome">Back</ui-button>
                </ui-block>
            </ui-row>
        </ui-container>
        <login-form
            ref="login"
            @go-back="goBack"/>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../ui'
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
        init: function() {
            if (this.master) {
                this.master.kill()
            }

            let container = this.$refs.container.$el
            let buttons = container.getElementsByClassName('login-button')

            let rect = container.getBoundingClientRect()
            let height = rect.height

            this.master = new TimelineMax({
                paused: true,
            })

            this.master.staggerFromTo(buttons, .3, {
                scale: 1,
                autoAlpha: 1,
            }, {
                scale: 0,
                autoAlpha: 0,
            }, .02, 0)

            this.master.fromTo(container, .3, {
                x: 0,
                height: height,
            }, {
                x: 20,
                height: 0,
            }, 0)

            this.master.progress(1).progress(0)
            this.master.eventCallback('onComplete', () => {
                this.open = true
                this.$refs.login.show()
            })
            this.master.eventCallback('onReverseComplete', () => {
                this.open = false
            })
        },
        toggle: function() {
            if (this.open) {
                this.master.reverse()
            } else {
                this.master.play()
            }
        },
        goTo: function(name) {
            this.toggle()
        },
        goToHome: function() {
            this.$router.push({ name: 'home-header' })
        }
    },
    mounted: function() {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

</style>
