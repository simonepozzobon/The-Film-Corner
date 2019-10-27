<template lang="html">
    <div ref="loader" class="loader">
        <svg viewBox="0 0 32 32" width="50%" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <circle id="c1" cx="16" cy="16" r="4" ref="c1"/>
            <circle id="c2" cx="16" cy="16" r="4" ref="c2"/>
            <circle id="c3" cx="16" cy="16" r="4" ref="c3"/>
            <circle id="c4" cx="16" cy="16" r="4" ref="c4"/>
        </svg>
    </div>
</template>

<script>
import {
    TweenMax,
    Power2,
    Power3,
    Sine,
}
from 'gsap/all'

const plugins = [
    Power2,
    Power3,
    Sine,
]

const yPercent = 35
const xPercent = 40
const time = 1.2
const minScale = .8
const maxScale = 1
const easing = Power2.easeInOut
const easing2 = Sine.easeInOut
const easing3 = Power3.easeNone
const minO = .3
const maxO = 1

export default {
    name: 'UiLoader',
    data: function () {
        return {
            master: new TimelineMax({
                paused: true,
                repeat: -1,
                yoyo: true,
            }),
            anims: [],
            refs: ['c1', 'c2', 'c3', 'c4'],
            toggle: null,
        }
    },
    computed: {
        matrix: function () {},

    },
    methods: {
        iterateRefs: function (refs = []) {
            let positions = [
                [
                    [0, 0, maxScale, minO],
                    [xPercent, yPercent, minScale, maxO],
                ],
                [
                    [xPercent, yPercent, minScale, maxO],
                    [0, 0, minScale, minO],
                ],
                [
                    [0, 0, minScale, minO],
                    [-xPercent, -yPercent, minScale, maxO],
                ],
                [
                    [-xPercent, -yPercent, minScale, maxO],
                    [0, 0, maxScale, minO],
                ],
            ]

            for (let i = 0; i < refs.length; i++) {
                // this.setAnim(refs[i], i)
                let key = refs[i]
                let el = this.$refs[key]
                this.initAnim(el, i, positions)
            }

            this.master.add(this.anims, 0)
            this.master.progress(1).progress(0)
            this.master.play()
        },

        initAnim: function (el, idx = 0, pos, timeline = new TimelineMax()) {

            let max = pos.length - 1
            let debugX = ''
            let debugY = ''

            for (let i = 0; i < pos.length; i++) {
                let newpos = i + idx

                if (newpos > max) {
                    let difference = newpos - max - 1
                    newpos = difference
                }
                // console.log(newpos);

                let x = pos[newpos][0][0]
                let y = pos[newpos][0][1]
                let s = pos[newpos][0][2]
                let o = pos[newpos][0][3]

                let xE = pos[newpos][1][0]
                let yE = pos[newpos][1][1]
                let sE = pos[newpos][1][2]
                let oE = pos[newpos][1][3]

                let curve = easing

                if (idx % 2 != 0) {
                    let tmp = 0

                    x = -x
                    y = y
                    xE = -xE
                    yE = yE

                    tmp = s
                    s = sE
                    sE = tmp

                    curve = easing2
                }

                // debugX = debugX + '' + pos[newpos][0][0] + ' ' + pos[newpos][1][0] + ' | '
                // debugY = debugY + '' + pos[newpos][0][1] + ' ' + pos[newpos][1][1] + ' | '

                if (i == 0) {
                    timeline.fromTo(el, time, {
                        scale: s,
                        xPercent: x,
                        yPercent: y,
                        opacity: o,
                    }, {
                        scale: sE,
                        xPercent: xE,
                        yPercent: yE,
                        opacity: oE,
                        ease: curve,
                    }, 0)
                }
                else {
                    timeline.fromTo(el, time, {
                        scale: s,
                        xPercent: x,
                        yPercent: y,
                        opacity: o,
                    }, {
                        scale: sE,
                        xPercent: xE,
                        yPercent: yE,
                        opacity: oE,
                        ease: curve,
                    })
                }



            }
            // console.log('IDX ->', idx);
            // console.log(debugX);
            // console.log(debugY);
            this.anims.push(timeline)
        },
        initLoader: function () {
            let el = this.$refs.loader

            this.iterateRefs(this.refs)
        },
        hide: function () {
            if (!this.toggle) {
                this.toggle = new TimelineMax({
                    paused: true,
                    reversed: true,
                })

                this.toggle.fromTo(this.$refs.loader, .6, {
                    autoAlpha: 1,
                    display: 'flex'
                }, {
                    autoAlpha: 0,
                    display: 'none'
                }, 0)

                this.toggle.progress(1).progress(0)
            }
            this.toggle.progress(0).play()
        },
        show: function () {
            this.toggle.progress(1).reverse()
        }
    },
    mounted: function () {
        this.initLoader()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
.loader {
    padding-top: $spacer * 2;
    display: flex;
    justify-content: center;
    align-content: center;

    > svg {
        > #c1 {
            fill: rgba($primary, .5);
        }

        > #c2 {
            fill: rgba($red, .5);
        }

        > #c3 {
            fill: rgba($green, .5);
        }

        > #c4 {
            fill: rgba($yellow, .5);
        }
    }
}
</style>
