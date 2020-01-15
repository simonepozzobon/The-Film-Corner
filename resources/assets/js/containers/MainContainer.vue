<template>
<transition
    @enter="enter"
    @leave="leave"
>
    <router-view></router-view>
</transition>
</template>

<script>
import {
    gsap,
    TweenMax,
}
from 'gsap/all'

export default {
    name: 'MainContainer',
    methods: {
        enter: function (el, done) {
            let master = TweenMax.fromTo(el, .6, {
                autoAlpha: 0,
            }, {
                autoAlpha: 1,
                onComplete: () => {
                    master.kill()
                    done()
                }
            })
        },
        leave: function (el, done) {
            let master = TweenMax.fromTo(el, .6, {
                autoAlpha: 1,
                position: 'absolute',
                zIndex: 1,
            }, {
                autoAlpha: 0,
                position: 'absolute',
                zIndex: 1,
                onComplete: () => {
                    master.kill()
                    done()
                }
            })
        }
    },
    mounted: function () {
        this.$nextTick(() => {
            console.log('Main Container Rendered');
            TweenMax.to(window, .2, {
                delay: .5,
                scrollTo: {
                    y: 0,
                    autoKill: false,
                },
            })
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
