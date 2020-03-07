<template>
<div
    ref="menu"
    class="loader-nav"
>
    <div class="loader-nav__progress progress">
        <div
            class="progress-bar progress-bar-striped progress-bar-animated loader-nav__bar"
            :class="progressClass"
            role="progressbar"
            :aria-valuenow="value"
            aria-valuemin="0"
            aria-valuemax="100"
            :style="progress"
        >
            {{ percent }}
        </div>
    </div>
</div>
</template>

<script>
import {
    gsap,
    TimelineMax,
    TweenMax,
    Power4,
    Sine,
}
from 'gsap/all'

const plugins = [
    Power4,
    Sine,
]

export default {
    name: 'LoaderNav',
    computed: {
        progress: function () {
            return 'width: ' + this.value + '%;'
        },
        percent: function () {
            return this.value + '%'
        },
        progressClass: function () {
            return 'bg-success'
        },
    },
    data: function () {
        return {
            value: 0,
            master: null,
            destroy: null,
            stretch: 10,
        }
    },
    watch: {
        '$root.objectsToLoad': function (count, oldCount) {
            // console.log('old', oldCount, 'new', count);
            if (count > 0 && oldCount == 0) {
                // console.log('inizia', count, oldCount);
                this.master.tweenFromTo('start', 'endOpen')
            }
            else {
                // console.log('siamo qui', count, oldCount);
            }
        },
        '$root.objectsLoaded': function (count) {
            let percent = 0
            if (this.$root.objectsToLoad > 0) {
                percent = Math.floor(count * 100 / (this.$root.objectsToLoad - 1))
            }

            if (percent > 100) {
                this.value = 100
            }
            else if (percent < 0) {
                this.value = 0
            }
            else {
                this.value = percent
            }
            // console.log('counter', percent);
        },
        value: function (value) {
            // console.log('valueee', value, this.master.isActive(), this.master.progress());
            if (value >= 100) {
                // console.log('counter', value, this.master.isActive());
                if (this.master) {
                    if (this.master.isActive() == false) {
                        this.master.tweenFromTo('endOpen', 'end')
                    }
                    else {
                        // console.log('freeesze');
                    }
                }
            }
        }
    },
    methods: {
        init: function () {
            // console.log('init');
            let el = this.$refs.menu
            let content = document.getElementsByClassName('main__content')[0]

            this.master = gsap.timeline({
                paused: true,
                smoothChildTiming: true
            })

            this.master.addLabel('start', 0)

            this.master.set(content, {
                autoAlpha: 0
            })

            this.master.fromTo(el, {
                scaleX: 0,
            }, {
                duration: .5,
                scaleX: 1,
                ease: 'sine.out',
                onStart: () => {
                    this.$root.loaderOpen = true
                },
                // immediateRender: false,
            }, 'start')

            this.master.fromTo(el, {
                scaleY: 0,
                autoAlpha: 0,
            }, {
                duration: .3,
                scaleY: 1,
                autoAlpha: 1,
                ease: 'power4.in',
                // immediateRender: false,
            }, `start+=0.2`).addLabel('endOpen')

            this.master.addLabel('close', 'endOpen+=0')

            this.master.to(content, {
                duration: .5,
                autoAlpha: 1,
                ease: 'sine.in',
            }, 'close+=0.5')

            this.master.to(el, {
                duration: .7,
                autoAlpha: 0,
                ease: 'sine.out',
                onComplete: () => {
                    this.$root.loaderOpen = false
                    this.$root.objectsToLoad = 0
                    this.$root.objectsLoaded = 0
                },
            }, 'close+=0.5')

            this.master.addLabel('end')
        },
    },
    mounted: function () {
        this.$nextTick(this.init)
    },
    beforeDestroy: function () {
        this.$root.loaderOpen = false
        if (this.master) {
            this.master.kill()
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.loader-nav {
    position: fixed;
    top: 154px;
    width: 100%;
    height: calc(100vh - 154px);
    z-index: $zindex-fixed - 3;
    display: flex;
    align-items: center;
    justify-content: center;
    @include gradient-radial(rgba($gray-700, .95), rgba($gray-800, .95));

    &__progress {
        width: 50%;
        height: $spacer * 1.618;
    }

    &__bar {
        color: $gray-800;
        padding: $spacer / 2;
    }
}
</style>
