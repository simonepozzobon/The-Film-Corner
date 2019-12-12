<template>
<div class="a-topbar-container">
    <div class="a-topbar-container__wrapper">
        <div
            class="a-topbar"
            :class="stickyClass"
        >
            <container
                ref="container"
                class="a-topbar__container"
                padding="sm"
                :contains="true"
                :has-animations="true"
                @completed="getWidth"
            >
                <div class="a-clip-panel__topbar topbar">
                    <div class="topbar__head">
                        <ui-title
                            title="Nuova Clip"
                            tag="h1"
                            font-size="h1"
                            class="topbar__title"
                        />
                    </div>
                    <div class="topbar__steps">
                        <step
                            :number="1"
                            :completed="this.cursor | completed(0)"
                        />
                        <step
                            :number="2"
                            :completed="this.cursor | completed(1)"
                        />
                        <step
                            :number="3"
                            :completed="this.cursor | completed(2)"
                        />
                        <step
                            :number="4"
                            :completed="this.cursor | completed(3)"
                        />
                    </div>
                </div>
            </container>
        </div>
        <div
            v-if="stickyNavbar"
            ref="dummy"
            class="a-topbar-dummy"
            :style="`height: ${this.dummyHeigth}px; min-width: ${this.width}px max-width: 100%;`"
        ></div>
    </div>
</div>
</template>

<script>
import {
    Container,
}
from '../../adminui'

import {
    UiTitle,
}
from '../../../ui'

import Step from '../../components/clips/Step.vue'

export default {
    name: 'Topbar',
    components: {
        Container,
        Step,
        UiTitle,
    },
    props: {
        cursor: {
            type: Number,
            default: 0,
        },
    },
    data: function () {
        return {
            width: 0,
            height: 0,
            stickyNavbar: false,
            lastScrollPosition: 0,
            topLimit: 30,
        }
    },
    computed: {
        stickyClass: function () {
            if (this.stickyNavbar) {
                return 'a-topbar--sticky'
            }
            return null
        },
        dummyVisible: function () {
            if (this.stickyNavbar) {
                return 'a-topbar--dummy-visible'
            }
            return null
        },
        dummyHeigth: function () {
            return (this.height) + 52
        }
    },
    methods: {
        getWidth: function () {
            this.width = this.$refs.container.$el.offsetWidth
            this.height = this.$refs.container.$el.offsetHeight

            // this.$refs.container.$el.style.minWidth = this.width + 'px'
        },
        onScroll: function () {
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop

            if (currentScrollPosition < 0) {
                return
            }

            // if (Math.abs(currentScrollPosition - this.lastScrollPosition) < 30) {
            //     return
            // }

            this.stickyNavbar = currentScrollPosition > this.topLimit

            // console.log(this.stickyNavbar, currentScrollPosition);
        },
    },
    filters: {
        completed: function (value, cursor) {
            if (cursor >= value) {
                return false
            }
            else {
                return true
            }
        },
    },
    mounted: function () {
        window.addEventListener('scroll', this.onScroll)
        this.$nextTick(() => {
            this.getWidth()
        })
    },
    beforeDestroy: function () {
        window.removeEventListener('scroll', this.onScroll)
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

@mixin calc($key, $value) {
    #{$key}: -webkit-calc(#{$value});
    #{$key}: -moz-calc(#{$value});
    #{$key}: calc(#{$value});
}

.a-topbar {
    z-index: 1;
    width: 100%;
    transition: $transition-base;

    &--sticky {
        position: fixed;
        top: 64px;
        left: 53.5%;
        max-width: 79%;
        transform: translateX(-45%);
        transition: $transition-base;
    }

    &__dummy {
        display: none;
    }

    &--dummy-visible &__dummy {
        display: block;
    }
}
</style>
