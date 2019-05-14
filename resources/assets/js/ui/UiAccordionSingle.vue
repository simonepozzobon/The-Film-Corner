<template lang="html">
    <div
        :id="randomID"
        class="ui-accordion-single"
        ref="accordion">
        <div
            class="ui-accordion-single__head"
            @click="openPanel(true)"
            ref="header">
            <div class="ui-accordion-single__arrow">
                <ui-accordion-arrow :is-open="isOpen"/>
            </div>
            <div class="ui-accordion-single__title" ref="title">
                {{ title }}
            </div>
        </div>

        <div class="ui-accordion-single__body" ref="panel">
            <div class="ui-accordion-single__content" ref="content">
                <p v-html="content"></p>
            </div>
        </div>
    </div>
</template>

<script>
import UiAccordionArrow from './UiAccordionArrow.vue'

export default {
    name: 'UiAccordionSingle',
    components: {
        UiAccordionArrow
    },
    props: {
        idx: {
            type: Number,
            default: null,
            required: true,
        },
        title: {
            type: String,
            default: 'titolo'
        },
        content: {
            type: String,
            default: 'Contenuto'
        }
    },
    data: function() {
        return {
            master: null,
            isOpen: false,
            panelHeight: 0,
            isAnimating: false,
            panel: null,
        }
    },
    computed: {
        randomID: function() {
            //https://gist.github.com/gordonbrander/2230317
            return '_' + Math.random().toString(36).substr(2, 9)
        }
    },
    methods: {
        reset: function() {
            let panel = this.$refs.panel
            let content = this.$refs.content
            let cRect = content.getBoundingClientRect()
            let cHeight = cRect.height + 16

            if (this.panel) {
                if (this.isOpen) {
                    TweenLite.set(panel, {
                        clearProps: 'all'
                    })
                    this.panel.kill()

                    TweenLite.to(panel, .3, {
                        height: cHeight,
                        autoAlpha: 1,
                        transformOrigin: "left top 0",
                    })

                    this.panel = TweenMax.fromTo(panel, .6, {
                        height: 0,
                        autoAlpha: 0,
                        transformOrigin: "left top 0",
                        ease: Power3.easeInOut
                    },{
                        height: cHeight,
                        autoAlpha: 1,
                        transformOrigin: "left top 0",
                        ease: Power3.easeInOut,
                    })
                    this.master.add(this.panel, 0)
                } else {
                    TweenLite.set(panel, {
                        clearProps: 'all'
                    })
                    this.panel.kill()

                    this.panel = TweenMax.fromTo(panel, .6, {
                        height: 0,
                        autoAlpha: 0,
                        transformOrigin: "left top 0",
                        ease: Power3.easeInOut
                    },{
                        height: cHeight,
                        autoAlpha: 1,
                        transformOrigin: "left top 0",
                        ease: Power3.easeInOut,
                    })
                    this.master.add(this.panel, 0)
                }
            }
        },
        init: function() {
            let panel = this.$refs.panel
            let content = this.$refs.content
            let title = this.$refs.title

            if (this.master) {
                this.isOpen = false
                this.master.kill()
            }

            let cRect = content.getBoundingClientRect()
            let cHeight = cRect.height + 16

            this.panelHeight = cHeight

            TweenLite.set(panel, {
                height: 0,
                autoAlpha: 0,
                transformOrigin: "left top 0",
            })

            this.master = new TimelineMax({
                paused: true,
            })

            this.panel = TweenMax.fromTo(panel, .6, {
                height: 0,
                autoAlpha: 0,
                transformOrigin: "left top 0",
                ease: Power3.easeInOut
            },{
                height: cHeight,
                autoAlpha: 1,
                transformOrigin: "left top 0",
                ease: Power3.easeInOut,
            })
            this.master.add(this.panel, 0)

            this.master.fromTo(content, .9, {
                autoAlpha: 0,
            }, {
                autoAlpha: 1,
                ease: Sine.easeInOut
            }, 0)

            this.master.progress(1).progress(0)

            if (this.$parent.scrollOnComplete) {
                this.master.eventCallback('onComplete', () => {
                    let scroller = TweenMax.to(window, .2, {
                        scrollTo: {
                            y: '#'+this.randomID,
                            offsetY: 90,
                            autoKill: false,
                        },
                        onComplete: () => {
                            scroller.kill()
                        }
                    })
                })

                this.master.eventCallback('onReverseComplete', () => {
                    let scroller = TweenMax.to(window, .2, {
                        scrollTo: {
                            y: '#'+this.randomID,
                            offsetY: 90,
                            autoKill: false,
                        },
                        onComplete: () => {
                            scroller.kill()
                        }
                    })
                })
            }

        },
        openPanel: function(isInternal = null) {
            this.$parent.$emit('open-accordion', this.idx, isInternal)
            if (this.isOpen) {
                this.isOpen = false
                this.$nextTick(() => {
                    this.master.reverse()
                })
            } else {
                this.isOpen = true
                this.$nextTick(() => {
                    this.master.play()
                })
            }
        },
    },
    mounted: function() {
        this.$parent.$on('open-accordion', (idx) => {
            if (this.idx != idx && this.isOpen) {
                this.openPanel()
            }
        })

        this.$parent.$on('toggle-accordion', (idx) => {
            if (this.idx == idx) {
                this.openPanel()
            }
        })
        this.$on('loaded', () => {
            this.reset()
        })

        this.$nextTick(() => {
            this.init()
        })
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-accordion-single {
    $self: &;

    &__head {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        cursor: pointer;
        padding: ($spacer / 4) * 1.618;
    }

    &__title {
        font-weight: bold;
        text-transform: capitalize;
    }

    &__arrow {
        margin-right: $spacer / 2;
    }

    &__body {
        position: relative;
        // height: 0;

        visibility:hidden; /* hides all .Tile-flyout on load so GSAP autoAlpha can do its thing */
        height:auto; /* tell the browser that initial height is auto */
        overflow:hidden;
    }

    &__content {
        padding-left: $spacer * 2;
        padding-right: $spacer * 2;
        padding-top: $spacer;
        padding-bottom: $spacer;
    }

    &__button {
        #{$self}--disable & {
            background-color: $blue;
            z-index: -1;

        }
    }

    &#{$self}--no-padding & {
        &__head {
            padding: 0;
        }

        &__content {
            // padding-top: $spacer * 1.618;
            padding-bottom: 0;
        }
    }
}
</style>
