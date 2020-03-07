<template>
<ui-container
    ref="container"
    class="app-container"
    :contain="true"
    v-if="this.app"
    @init="scrollTop"
>
    <ui-app-folder :app="app" />
    <ui-container
        class="pt-4"
        :contain="true"
    >
        <ui-row :no-gutters="true">
            <ui-block
                :size="left"
                :full-height="false"
                :has-container="false"
            >
                <slot name="left"></slot>
            </ui-block>
            <ui-block
                :size="right"
                :full-height="false"
                :has-container="false"
            >
                <slot name="right"></slot>
            </ui-block>
        </ui-row>
        <slot></slot>
    </ui-container>
</ui-container>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiRow
}
from '../../ui'
import {
    UiAppFolder
}
from '../../uiapp'

import {
    gsap,
    ScrollToPlugin
}
from 'gsap/all'
gsap.registerPlugin(ScrollToPlugin);

import TranslationFilter from '../../TranslationFilter'

export default {
    name: 'AppTemplate',
    mixins: [TranslationFilter],
    components: {
        UiAppFolder,
        UiBlock,
        UiContainer,
        UiRow,
    },
    props: {
        app: {
            type: Object,
            default: function () {},
        },
        left: {
            type: Number,
            default: 8,
        },
        right: {
            type: Number,
            default: 4,
        }
    },
    watch: {
        'app': function (app) {
            if (app) {
                this.scrollTop()
            }
        }
    },
    methods: {
        scrollTop: function () {
            if (this.$refs.container) {
                let tween = gsap.to(window, .2, {
                    scrollTo: {
                        y: 0,
                        autoKill: false,
                    },
                    immediateRender: false,
                    onComplete: () => {
                        tween.kill()
                    }
                })
            }
        },
    },
    created: function () {
        this.$root.isApp = true
    },
    mounted: function () {
        this.$nextTick(() => {

        })
    },
    beforeDestroy: function () {
        this.$root.isApp = false
        this.$root.session = {
            app: null,
            app_id: 0,
            content: {},
            token: null
        }
        this.$root.isOpen = false
        this.$root.isTeacherCheck = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.app-container {
    margin-top: $spacer * 5;
    padding-bottom: $spacer * 2.5;

    &__row {
        width: 100%;
        height: 100%;
    }
}
</style>
