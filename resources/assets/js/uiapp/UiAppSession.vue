<template>
<div
    ref="container"
    class="ua-session"
    :class="[
            colorClass,
        ]"
    @mouseover="showHover"
    @mouseleave="hideHover"
>
    <div class="ua-session__container">
        <div class="ua-session__name">
            {{ title }}
        </div>
        <div class="ua-session__delete">
            <ui-button
                v-if="isStudent"
                color="dark"
                :has-container="false"
                :has-margin="false"
                :title="getCmd('share')"
                @click="shareSession"
            />
            <ui-button
                color="dark"
                :has-container="false"
                :has-margin="false"
                :title="getCmd('open')"
                @click="openSession"
            />
            <ui-button
                color="dark"
                :has-container="false"
                :has-margin="false"
                :title="getCmd('delete')"
                @click="deleteSession"
            />
        </div>
    </div>
</div>
</template>

<script>
import {
    UiButton
}
from '../ui'
import Utility from '../Utilities'
import {
    TimelineMax,
}
from 'gsap/all'
import TranslateCmd from '_js/TranslateCmd'

export default {
    name: 'UiAppSession',
    mixins: [TranslateCmd],
    components: {
        UiButton,
    },
    props: {
        idx: {
            type: Number,
            default: 0,
        },
        counter: {
            type: Number,
            default: 0,
        },
        title: {
            type: String,
            default: 'title',
        },
        app: {
            type: String,
            default: 'app',
        },
        token: {
            type: String,
            default: null,
        },
        isShared: [Boolean, String, Number]
    },
    data: function () {
        return {
            selected: false,
        }
    },
    computed: {
        colorClass: function () {
            let odd = Boolean((this.counter) % 2)

            if (odd) {
                return 'ua-session--light'
            }
        },
        isOdd: function () {
            return Boolean((this.counter) % 2)
        },
        isStudent: function () {
            if (this.$root.user && this.$root.user.role_id == 2) {
                return true
            }
            return false
        },
    },
    methods: {
        init: function () {
            let el = this.$refs.container
            let gray = getComputedStyle(document.documentElement).getPropertyValue('--gray-dark')
            let rgbaObj = Utility.hexToRgbA(gray)
            let rgba = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', .18)'
            let transparent = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', 0)'

            if (this.isOdd) {
                let white = getComputedStyle(document.documentElement).getPropertyValue('--white')
                rgbaObj = Utility.hexToRgbA(white)
                transparent = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', .28)'
            }

            this.master = new TimelineMax({
                paused: true,
                yoyo: true
            })

            this.master.fromTo(el, .3, {
                backgroundColor: transparent
            }, {
                backgroundColor: rgba,
            })

            this.master.progress(1).progress(0)
        },
        showHover: function () {
            if (this.master) {
                this.master.play()
            }
        },
        hideHover: function () {
            if (this.master) {
                this.master.reverse()
            }
        },
        deleteSession: function () {
            this.$emit('delete-session', this.token)
        },
        openSession: function () {
            this.$emit('open-session', this.token)
        },
        shareSession: function () {
            this.$emit('share-session', this.token)
        },
    },
    mounted: function () {
        this.init()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-session {
    width: 100%;
    padding: $spacer * 1.618 / 2 $spacer * 1.618;

    &__container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    &__title {
        font-weight: 600;
        text-transform: capitalize;
    }

    &__info {
        text-transform: capitalize;
    }

    &__tools {
        display: flex;
        align-items: center;
    }

    &__icon {
        display: flex;
        align-items: center;
        padding-right: $spacer * 1.618;
    }

    &__delete {
        margin-left: auto;
    }

    &__figure {
        font-size: $h4-font-size;
        color: $black;
        line-height: 1;
    }

    &--light {
        background-color: rgba($white, .28);
    }
}
</style>
