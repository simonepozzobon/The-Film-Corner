<template>
    <div
        ref="container"
        class="ui-app-session"
        :class="[
            colorClass,
        ]"
        @mouseover="showHover"
        @mouseleave="hideHover">
        <div class="ui-app-session__container">
            <div class="ui-app-session__name">
                {{ title }}
            </div>
            <div class="ui-app-session__delete">
                <ui-button
                    color="black"
                    :has-container="false"
                    :has-margin="false"
                    title="Open"
                    @click="openSession"/>
                <ui-button
                    color="black"
                    :has-container="false"
                    :has-margin="false"
                    title="delete"
                    @click="deleteSession"/>
            </div>
        </div>
    </div>
</template>

<script>
import { UiButton } from '../ui'
import Utility from '../Utilities'

export default {
    name: 'UiAppSession',
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
    },
    data: function() {
        return {
            selected: false,
        }
    },
    computed: {
        colorClass: function() {
            let odd = Boolean((this.counter) % 2)

            if (odd) {
                return 'ui-app-session--light'
            }
        },
        isOdd: function() {
            return Boolean((this.counter) % 2)
        },
    },
    methods: {
        init: function() {
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
        showHover: function() {
            if (this.master) {
                this.master.play()
            }
        },
        hideHover: function() {
            if (this.master) {
                this.master.reverse()
            }
        },
        deleteSession: function() {
            this.$emit('delete-session', this.token)
        },
        openSession: function() {
            this.$emit('open-session', this.token)
        },
    },
    mounted: function() {
        this.init()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-session {
    width: 100%;
    padding-top:  $spacer * 1.618 / 2;
    padding-bottom: $spacer * 1.618 / 2;
    padding-left:  $spacer * 1.618;
    padding-right:  $spacer * 1.618;

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
        background-color: rgba($white, .28)
    }
}
</style>
