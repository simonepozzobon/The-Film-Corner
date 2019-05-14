<template lang="html">
    <nav class="network-nav navbar navbar-dark navbar-expand-lg fixed-top" ref="menu">
        <ul class="navbar-nav network-nav__nav">
            <li class="network-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-home')" class="nav-link network-nav__link">Most Recent</a>
            </li>
            <li class="network-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-home')" class="nav-link network-nav__link">Most Liked</a>
            </li>
            <li class="network-nav__item nav-item">
                <a href="#" @click="goTo($event, 'apps-home')" class="nav-link network-nav__link">Filter By App</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'NetworkNav',
    methods: {
        goTo: function(event, name) {
            event.preventDefault()
            this.$router.push({name: name})
        },
        show: function() {
            let master = TweenMax.fromTo(this.$refs.menu, .5, {
                y: -150,
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
                y: -150,
                autoAlpha: 0,
                onComplete: () => {
                    master.kill()
                }
            })
        }
    },
    mounted: function() {
        console.log('mounted');
        this.show()
    },
    beforeDestroy: function() {
        this.hide()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';


.network-nav {
    top: 107px;
    height: 48px;
    z-index: $zindex-fixed - 2;
    background-color: $dark-gray;
    justify-content: center;

    &__nav {
        max-width: map-get($container-max-widths, xl);
        width: 100%;
        justify-content: flex-end;
    }

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-bold;
        color: $white !important;
    }
}
</style>
