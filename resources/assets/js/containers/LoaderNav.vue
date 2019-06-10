<template>
<div
    class="loader-nav progress"
    ref="menu"
>
    <div
        class="progress-bar progress-bar-striped progress-bar-animated"
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
</template>

<script>
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
        }
    },
    watch: {
        '$root.progress': function (value) {
            this.value = value
        },
        value: function (value) {
            if (value >= 100) {
                this.destroyLoader()
            }
        }
    },
    methods: {
        init: function () {
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
        destroyLoader: function () {
            let master = TweenMax.fromTo(this.$refs.menu, .5, {
                y: 0,
                autoAlpha: 1,
            }, {
                delay: 1,
                y: -100,
                autoAlpha: 0,
                onComplete: () => {
                    console.log('completo', this.$refs.menu);
                }
            })
        }
    },
    mounted: function () {
        this.$nextTick(this.init)
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.loader-nav {
    position: fixed;
    top: 155px;
    width: 100%;
    @include border-radius(0);
    z-index: $zindex-fixed - 3;
}
</style>
