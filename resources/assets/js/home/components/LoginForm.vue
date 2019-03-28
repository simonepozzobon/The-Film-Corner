<template lang="html">
    <ui-container
        direction="column"
        min-width="400px"
        ref="container">
        <ui-block
            :size="9"
            :has-container="false"
            class="login-form__container">
            <ui-title
                title="Teacher Login"
                color="white"
                :uppercase="false"
                align="center"
                class="login-form__title"/>

            <ui-form-group
                name="Email Address"
                type="email"
                class="login-form__input"/>

            <ui-form-group
                name="Password"
                type="password"
                class="login-form__input"/>

            <ui-button
                color="white"
                :block="true"
                class="login-form__submit">
                Login
            </ui-button>

            <ui-button
                color="white"
                :block="true"
                class="login-form__submit"
                @click.native="goBack">
                Back
            </ui-button>
        </ui-block>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiFormGroup, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../ui'
import { TimelineMax } from 'gsap'

export default {
    name: 'LoginForm',
    components: {
        UiBlock,
        UiButton,
        UiContainer,
        UiFormGroup,
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
            master: null,
        }
    },
    methods: {
        init: function() {
            let container = this.$refs.container.$el
            let inputs = container.getElementsByClassName('login-form__input')
            let btn = container.getElementsByClassName('login-form__submit')

            let rect = container.getBoundingClientRect()
            let height = rect.height

            this.master = new TimelineMax({
                paused: true
            })

            this.master.fromTo(container, .3, {
                height: 0,
                autoAlpha: 0,
            }, {
                height: height,
                autoAlpha: 1,
            }, 0)

            this.master.progress(1).progress(0)
            this.hide()
        },
        show: function() {
            this.master.play()
        },
        hide: function() {
            this.master.reverse()
        },
        goBack: function() {
            this.hide()
            this.$emit('go-back')
        }
    },
    mounted: function() {
        this.init()
    }
}
</script>

<style lang="css" scoped>
</style>
