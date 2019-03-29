<template lang="html">
    <main class="main">
        <main-nav></main-nav>
        <div class="main__content">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
import { TweenMax } from 'gsap'
import MainNav from './MainNav.vue'

export default {
    name: 'MainTemplate',
    components: {
        MainNav,
    },
    methods: {
        // conferenceMenuEnter: function(el, done) {
        //     TweenMax.fromTo(el, .5, {
        //         y: -100,
        //         autoAlpha: 0,
        //     }, {
        //         y: 0,
        //         autoAlpha: 1,
        //         onComplete: () => {
        //             done()
        //         }
        //     })
        // },
        // conferenceMenuLeave: function (el, done) {
        //     TweenMax.fromTo(el, .5, {
        //         y: 0,
        //         autoAlpha: 1,
        //     }, {
        //         y: -100,
        //         autoAlpha: 0,
        //         onComplete: () => {
        //             done()
        //         }
        //     })
        // }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.main {
    &__content {
        padding-top: 60px;
    }
}
</style>
