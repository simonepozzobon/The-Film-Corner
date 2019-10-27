<template>
<ui-row
    direction="column"
    min-width="400px"
    align="center"
    ref="container"
>
    <ui-block
        size="auto"
        :has-container="false"
        class="login-form__container"
    >
        <ui-title
            title="Login"
            color="white"
            :uppercase="false"
            align="center"
            class="login-form__title"
        />

        <ui-form-group
            name="Email"
            type="email"
            class="login-form__input"
            @changed="changed"
        />

        <ui-form-group
            name="Password"
            type="password"
            class="login-form__input"
            @changed="changed"
        />

        <ui-button
            color="white"
            :block="true"
            class="login-form__submit"
            @click.native="attemptLogin"
        >
            Login
        </ui-button>

        <ui-button
            color="white"
            :block="true"
            class="login-form__submit"
            @click.native="goBack"
        >
            Back
        </ui-button>
    </ui-block>
</ui-row>
</template>

<script>
import axios from 'axios'
import {
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
}
from '../../ui'
import {
    TweenMax
}
from 'gsap/all'

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
    data: function () {
        return {
            master: null,
            obj: {
                email: null,
                password: null,
            }
        }
    },
    methods: {
        init: function () {
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
        },
        show: function () {
            this.master.play()
        },
        hide: function () {
            this.master.reverse()
        },
        goBack: function () {
            this.$router.push({
                name: 'home'
            })
        },
        attemptLogin: function () {
            // login
            let data = new FormData()

            data.append('email', this.obj.email)
            data.append('password', this.obj.password)

            axios.post('/api/v2/login', data).then(response => {
                if (response.data.success) {
                    this.$root.user = response.data.user
                    this.$root.token = response.data.token
                    this.$root.login()
                    this.$root.goTo('apps-home')
                }
            })
        },
        changed: function (v, name) {
            this.obj[name] = v
        }
    },
    mounted: function () {
        this.init()
    }
}
</script>

<style lang="css" scoped>
</style>
