<template>
<nav
    class="logged-nav navbar navbar-dark navbar-expand-lg fixed-top"
    ref="menu"
>
    <ul class="navbar-nav ml-auto logged-nav__nav">
        <li class="logged-nav__item nav-item">
            <a
                href="#"
                @click.stop.prevent="$root.goTo('apps-home')"
                class="nav-link logged-nav__link"
            >
                {{ this.$root.getCmd('studios') }}
            </a>
        </li>
        <li class="logged-nav__item nav-item">
            <a
                href="#"
                @click.stop.prevent="$root.goTo('network-home')"
                class="nav-link logged-nav__link"
            >
                {{ this.$root.getCmd('network') }}
            </a>
        </li>
        <li
            v-if="isTeacher"
            class="logged-nav__item nav-item"
        >
            <a
                href="#"
                @click.stop.prevent="$root.goTo('teacher-profile')"
                class="nav-link logged-nav__link"
            >
                {{ this.$root.getCmd('students') }}
            </a>
        </li>
        <li class="logged-nav__item nav-item">
            <a
                href="#"
                @click.stop.prevent="$root.goTo('apps-help')"
                class="nav-link logged-nav__link disabled"
                disabled
            >
                {{ this.$root.getCmd('help') }}
            </a>
        </li>
    </ul>
</nav>
</template>

<script>
import {
    TweenMax
}
from 'gsap/all'

export default {
    name: 'LoggedNav',
    data: function () {
        return {}
    },
    computed: {
        isTeacher: function () {
            if (this.$root.user && this.$root.user.role_id == 1) {
                return true
            }
            return false
        },
    },
    methods: {
        show: function () {
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
        hide: function () {
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
    mounted: function () {
        this.show()
    },
    beforeDestroy: function () {
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
