<template>
    <transition
        @enter="enter"
        @leave="leave">
        <router-view></router-view>
    </transition>
</template>

<script>
import { TweenMax } from 'gsap'
export default {
    name: 'MainContainer',
    methods: {
        enter: function(el, done) {
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
        leave: function(el, done) {
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
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
