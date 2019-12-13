<template>
<div
    class="a-topbar"
    v-sticky="stickyEnabled"
    sticky-offset="{top: 96, bottom: 0}"
    sticky-z-index="10"
>
    <container
        ref="container"
        class="a-topbar__container"
        :class="stickyClass"
        padding="sm"
        :contains="true"
        :has-animations="true"
        @completed="getWidth"
        :top-margin="false"
    >
        <div
            class="a-clip-panel__topbar topbar"
            :class="stickyClassTitle"
        >
            <div class="topbar__head">
                <ui-title
                    :title="title"
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
        title: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            width: 0,
            height: 0,
            stickyNavbar: false,
            lastScrollPosition: 0,
            topLimit: 30,
            stickyEnabled: false,
        }
    },
    computed: {
        stickyClass: function () {
            if (this.stickyNavbar) {
                return 'admin-container--sticky'
            }
            return null
        },
        stickyClassTitle: function () {
            if (this.stickyNavbar) {
                return 'topbar--sticky'
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
        },
        onScroll: function () {
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop

            if (currentScrollPosition < 0) {
                return
            }
            this.stickyNavbar = currentScrollPosition > this.topLimit
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
            this.stickyEnabled = true
        })
    },
    beforeDestroy: function () {
        window.removeEventListener('scroll', this.onScroll)
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.topbar {

    &--sticky .ui-title {
        color: $light;
        transition: $transition-base;
    }
}
</style>
