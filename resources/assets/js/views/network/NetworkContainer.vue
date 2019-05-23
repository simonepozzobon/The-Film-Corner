<template lang="html">
    <div>
        <transition
            @enter="enter"
            @leave="leave">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
import { TweenMax } from 'gsap'
export default {
    name: 'NetworkContainer',
    components: {
    },
    methods: {
        enter: function(el, done) {
            let master = TweenMax.fromTo(el, 1, {
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
            let master = TweenMax.fromTo(el, 1, {
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
    mounted: function() {
        this.$root.conferenceMenu = true
    },
    beforeDestroy: function() {
        this.$root.conferenceMenu = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
