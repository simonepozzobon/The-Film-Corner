<template>
<div
    ref="container"
    class="pro-session"
    :class="[
            colorClass,
        ]"
    @mouseover="showHover"
    @mouseleave="hideHover"
>
    <div class="pro-session__container">
        <div class="pro-session__details">
            <div class="pro-session__title">
                {{ title }}
            </div>
            <div class="pro-session__info">
                {{ app }} Made by {{ fullName }}
            </div>
        </div>
        <div class="pro-session__tools">
            <div class="pro-session__icon">
                <div class="pro-session__value">
                    1
                </div>
                <div class="pro-session__figure">
                    <i class="fa fa-heart"></i>
                </div>
            </div>
            <div class="pro-session__icon">
                <div class="pro-session__value">
                    1
                </div>
                <div class="pro-session__figure">
                    <i class="fa fa-comment"></i>
                </div>
            </div>
            <div
                class="pro-session__icon"
                @click.prevent="deleteNetwork"
            >
                <div class="pro-session__value">
                </div>
                <div class="pro-session__trash">
                    <i class="fa fa-trash"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Utility from '../Utilities'

export default {
    name: 'ProSession',
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
        name: {
            type: String,
            default: 'no-name',
        },
        surname: {
            type: String,
            default: 'no-surname',
        },
        network: {
            type: Object,
            default: function () {
                return {}
            },
        },
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
                return 'pro-session--light'
            }
        },
        isOdd: function () {
            return Boolean((this.counter) % 2)
        },
        fullName: function () {
            if (this.name) {
                if (this.surname) {
                    return this.name + ' ' + this.surname
                }

                return this.name
            }

            return 'no-name'
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
        deleteNetwork: function () {
            this.$emit('delete-network', this.idx)
        },
    },
    mounted: function () {
        this.init()
        console.log(this.network);
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.pro-session {
    width: 100%;
    padding: $spacer * 1.618 / 2 $spacer * 1.618;

    &__container {
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        padding-left: $spacer * 1.618;
    }

    &__value {
        font-size: $h5-font-size;
        font-weight: 500;
        line-height: 1;
        padding-right: $spacer / 1.618;
    }

    &__figure {
        font-size: $h4-font-size;
        color: $white;
        line-height: 1;
    }

    &__trash {
        font-size: $h4-font-size;
        color: $black;
        line-height: 1;
        cursor: pointer;
    }

    &--light {
        background-color: rgba($white, .28);
    }
}
</style>
