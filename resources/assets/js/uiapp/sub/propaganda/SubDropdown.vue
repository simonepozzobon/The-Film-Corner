<template>
<div class="sub-dropdown">
    <div
        class="sub-dropdown__head"
        @click="toggle"
    >
        <i
            class="sub-dropdown__caret fa fa-caret-right"
            ref="icon"
        ></i>
        <ui-title
            class="sub-dropdown__title"
            :title="title"
            tag="h5"
            font-size="h5"
            :has-container="false"
            :has-margin="false"
            :has-padding="false"
            :uppercase="false"
            display="inline-block"
        />
        <!-- <h5 class="sub-dropdown__title">{{ title }}</h5> -->
    </div>
    <div
        class="sub-dropdown__list"
        ref="list"
    >
        <div class="sub-item">
            <a
                href="#"
                v-for="item in items"
                :key="item.id"
                class="sub-item__link"
                @click.stop.prevent="openSub(item.id)"
            >
                {{ item.title }}
            </a>
        </div>
    </div>
</div>
</template>

<script>
import {
    UiTitle
}
from '../../../ui'

import {
    gsap
}
from 'gsap'

// import {
//     ExpoScaleEase
// }
// from 'gsap/ExpoScaleEase'
//
// gsap.registerPlugin(ExpoScaleEase)

export default {
    name: 'SubDropDown',
    components: {
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: 'titolo',
        },
        items: {
            type: Array,
            default: function () {
                return []
            },
        }
    },
    data: function () {
        return {
            status: false,
            master: null,
            duration: .6,
            scale: 2,
            baseEase: 'power4.inOut',
            initialHeight: 0,
        }
    },
    methods: {
        initAnim: function () {
            if (!this.master) {
                let el = this.$refs.icon
                let scale = this.scale
                let invscale = 1 / scale
                let duration = this.duration
                let baseEase = this.baseEase

                let list = this.$refs.list
                let rect = list.getBoundingClientRect()

                let height = rect.height

                let inputs = Array.prototype.slice.apply(list.getElementsByClassName('sub-item'))

                let inputDur = (duration / (inputs.length * 2))
                // console.log(inputs);

                gsap.set(list, {
                    height: 0,
                })

                gsap.set(inputs, {
                    autoAlpha: 0,
                })

                this.master = gsap.timeline({
                    paused: true,
                    reversed: true
                })

                this.master.fromTo(el, {
                    rotation: 0,
                    transformOrigin: 'center center 0',
                }, {
                    duration: duration,
                    rotation: 90,
                    transformOrigin: 'center center 0',
                    ease: `expoScale(${scale}, 1, ${baseEase})`,
                }, 0)

                this.master.fromTo(list, {
                    height: 0,
                    transformOrigin: 'top',
                }, {
                    duration: duration,
                    height: height,
                    transformOrigin: 'top',
                    ease: `expoScale(${invscale}, 1, ${baseEase})`,
                }, 0)

                this.master.fromTo(inputs, {
                    autoAlpha: 0,
                    ease: `expoScale(${invscale}, 1, ${baseEase})`,
                }, {
                    duration: duration,
                    autoAlpha: 1,
                    ease: `expoScale(${scale}, 1, ${baseEase})`,
                    stagger: inputDur,
                }, 0)

                this.master.progress(1).progress(0)

            }
            else {
                this.master.kill()
                this.master = null
                this.$nextTick(() => {
                    this.initAnim()
                })
            }
        },
        closeMenu: function () {
            if (this.master) {
                this.status = false
                this.$nextTick(() => {
                    this.master.reverse()
                })
            }
        },
        openMenu: function () {
            if (this.master) {
                this.status = true
                this.$nextTick(() => {
                    this.master.play()
                })
            }
        },
        toggle: function () {
            if (this.status) {
                return this.closeMenu()
            }

            return this.openMenu()
        },
        openSub: function (id) {
            this.$emit('open-sub', id)
        }
    },
    mounted: function () {
        this.initAnim()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.sub-dropdown {
    margin-left: - ($spacer / 3) * 2;

    &__head {
        display: flex;
        justify-content: flex-start;
        align-items: baseline;
    }

    &__title {
        margin-left: $spacer / 3;
        display: inline-block;
    }

    &__caret {
        display: inline-block;
        left: 0;
        padding: 0;
    }

    &__list {
        overflow: hidden;
        height: auto;

        .sub-item {
            margin-left: $spacer;

            &__link {
                display: block;
                font-size: $font-size-lg;
                color: $black;
            }
        }
    }
}
</style>
