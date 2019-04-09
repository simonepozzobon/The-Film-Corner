<template lang="html">
    <nav class="apps-nav navbar navbar-dark bg-dark navbar-expand-lg fixed-top" ref="menu">
        <ul class="navbar-nav ml-auto">
            <li class="apps-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-home')" class="nav-link apps-nav__link">Apps</a>
            </li>
            <li class="apps-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-network')" class="nav-link apps-nav__link">Network</a>
            </li>
            <li class="apps-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-students')" class="nav-link apps-nav__link">Students</a>
            </li>
            <li class="apps-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-help')" class="nav-link apps-nav__link">Help</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'ConferenceNav',
    methods: {
        goTo: function(event, name) {
            event.preventDefault()
            this.$router.push({name: name})
        },
        show: function() {
            let master = TweenMax.fromTo(this.$refs.menu, .5, {
                y: -100,
                autoAlpha: 0,
            }, {
                y: 0,
                autoAlpha: 1,
                onComplete: () => {
                    master.kill()
                }
            })
        },
        hide: function() {
            let master = TweenMax.fromTo(this.$refs.menu, .5, {
                y: 0,
                autoAlpha: 1,
            }, {
                y: -100,
                autoAlpha: 0,
                onComplete: () => {
                    master.kill()
                }
            })
        }
    },
    mounted: function() {
        this.show()
    },
    beforeDestroy: function() {
        this.hide()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.apps-nav {
    top: 60px;
    z-index: $zindex-fixed - 1;

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-base;
        color: $white;
    }
}
</style>
