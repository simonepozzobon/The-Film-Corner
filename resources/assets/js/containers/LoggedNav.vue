<template lang="html">
    <nav class="logged-nav navbar navbar-dark navbar-expand-lg fixed-top" ref="menu">
        <ul class="navbar-nav ml-auto logged-nav__nav">
            <li class="logged-nav__item nav-item">
                <a href="#" @click.prevent="goTo('apps-home')" class="nav-link logged-nav__link">Apps</a>
            </li>
            <li class="logged-nav__item nav-item">
                <a href="#" @click.prevent="goTo('network-home')" class="nav-link logged-nav__link">Network</a>
            </li>
            <li class="logged-nav__item nav-item">
                <a href="#" @click.prevent="goTo('teacher-profile')" class="nav-link logged-nav__link">Students</a>
            </li>
            <li class="logged-nav__item nav-item">
                <a href="#" @click.prevent="goTo('apps-help')" class="nav-link logged-nav__link disabled" disabled>Help</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'LoggedNav',
    methods: {
        goTo: function(name) {
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

.logged-nav {
    top: 60px;
    height: 48px;
    z-index: $zindex-fixed - 1;
    background-color: $light-gray;

    &__nav {
        margin-right: $spacer * 2;
    }

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-bold;
        color: $white !important;

        &.disabled {
            color: rgba($white, .6) !important;
        }
    }
}
</style>
