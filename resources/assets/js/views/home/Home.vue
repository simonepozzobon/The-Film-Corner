<template>
<ui-container>
    <ui-container>
        <ui-hero-banner image="./img/grafica/bg.jpg">
            <transition
                mode="out-in"
                @enter="enter"
                @leave="leave"
            >
                <router-view></router-view>
            </transition>
        </ui-hero-banner>
    </ui-container>
    <ui-container :contain="true">
        <ui-title
            title="The Project"
            :is-main="true"
        />

        <ui-paragraph align="center">
            THE FILM CORNER. Online and offline activities for Film Literacy” project is aimed to the design, release and testing of an online digital virtual user- centered platform for Film Literacy, taking advantage of the opportunities offered by
            web 2.0 and crossmedia innovative approach in the digital era in order to raise the average film literacy level of EU young audiences. The general aim of the project is to contribute to draw an easy-going model for Film Literacy that
            could improve Film Literacy skills among the audience in order to foster Audience Development and Engagement towards film as an art form, with a particular focus on young and non-core audience...
        </ui-paragraph>
        <ui-link
            @click.native="goTo($event, 'project')"
            align="center"
        >Read more</ui-link>
        <news></news>
    </ui-container>
</ui-container>
</template>

<script>
import News from '../../components/News.vue'
import {
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
}
from '../../ui'
import {
    TweenMax,
    TimelineMax,
    Back,
}
from 'gsap/all'

const plugins = [
    Back,
]
export default {
    name: 'Home',
    components: {
        News,
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
        goTo: function (event, name) {
            event.preventDefault()
            this.$router.push({
                name: name
            })
        },
        leave: function (el, done) {
            let master = new TimelineMax({
                paused: true
            })

            master.fromTo(el, .3, {
                xPercent: 0,
                scaleY: 1,
                autoAlpha: 1,
            }, {
                xPercent: -200,
                scaleY: .7,
                autoAlpha: 0,
                ease: Back.easeIn.config(1.2),
            })

            master.progress(1).progress(0)
            master.eventCallback('onComplete', () => {
                done()
            })
            master.play()
        },
        enter: function (el, done) {
            let master = new TimelineMax({
                paused: true
            })

            master.fromTo(el, .3, {
                xPercent: 200,
                scaleY: .7,
                autoAlpha: 0,
            }, {
                xPercent: 0,
                scaleY: 1,
                autoAlpha: 1,
                ease: Back.easeOut.config(1.2),
            })

            master.progress(1).progress(0)
            master.eventCallback('onComplete', () => {
                done()
            })
            master.play()
        }
    },
    mounted: function () {}
}
</script>

<style lang="scss" scoped>
.test {
    min-width: 400px;
}
</style>
