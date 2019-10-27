<template>
<div
    class="menu-overlay"
    ref="container"
>
    <div
        class="menu-overlay__content"
        ref="content"
    >
        <ui-menu-item
            title="Home"
            target="_self"
            url="home"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="The Project"
            target="_self"
            url="project"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="Schools"
            target="_self"
            url="schools"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="Conference"
            target="_self"
            url="conference"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="Filmography"
            target="_self"
            url="filmography"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="Login"
            target="_self"
            url="#"
            @main-click="mainClick"
        />
        <ui-menu-item
            title="Language"
            target="_self"
            url="#"
            @main-click="mainClick"
        />
    </div>
    <div
        class="menu-overlay__pin ui-pin-mobile"
        ref="pin"
        @click="promemoria"
    >
        <div class="ui-pin-mobile__content">
            <span class="ui-pin-text ui-pin-text--light">
                Codice fiscale
            </span>
            <span class="ui-pin-text">
                07636600962
            </span>
            <span class="ui-pin-text ui-pin-text--light">
                Scarica Promemoria
            </span>
        </div>
    </div>
</div>
</template>

<script>
import {
    UiMenuItem
}
from '../ui'
import {
    TweenMax,
    Power4,
    Sine,
    Back
}
from 'gsap/all'

const plugins = [
    Power4,
    Sine,
    Back,
]

export default {
    name: 'MenuOverlay',
    components: {
        UiMenuItem,
    },
    data: function () {
        return {
            master: null,
            duration: .6,
            scale: 2,
            ease: Sine.easeOut,
            back: Back.easeOut.config(1.3),
            backSoft: Back.easeIn.config(1.1),
            status: false,
            height: 0,
            containerAnim: null,
            tempTimeline: null,
            scrollTemp: null,
            url: null,
        }
    },
    watch: {
        '$root.window': function (w) {
            this.height = w.h
        }
    },
    methods: {
        promemoria: function () {
            let url = '/files/OSR-5xmille-promemoria-2019-stampa.pdf'
            if (window.mobilecheck()) {
                url = '/files/OSR-5xmille-promemoria-2019-mobile.pdf'
            }

            window.open(url, '_blank')
        },
        init: function () {
            if (!this.master) {
                let duration = this.duration
                let scale = 2
                let invscale = 1 / scale

                let container = this.$refs.container
                let el = this.$refs.content
                let links = el.getElementsByClassName('menu-item__link')

                let rect = container.getBoundingClientRect()
                let height = window.innerHeight

                let linksDuration = duration * .4
                let linksDelay = linksDuration / links.length
                let linksStart = duration * 0.27

                this.master = new TimelineMax({
                    paused: true,
                    reversed: true,
                })

                this.master.fromTo(container, duration, {
                    opacity: 0,
                    yPercent: 100,
                    display: 'none',
                    ease: ExpoScaleEase.config(scale, 1, this.backSoft),
                }, {
                    yPercent: 0,
                    opacity: 1,
                    display: 'block',
                    ease: ExpoScaleEase.config(scale, 1, this.backSoft),
                }, 0)

                this.master.staggerFromTo(links, linksDuration, {
                    opacity: 0,
                    x: -30,
                    y: 5,
                    scaleY: .8,
                    ease: ExpoScaleEase.config(invscale, 1, Power4.easeIn),
                }, {
                    opacity: 1,
                    x: 0,
                    y: 0,
                    scaleY: 1,
                    ease: ExpoScaleEase.config(invscale, 1, Power4.easeIn),
                }, linksDelay, linksStart)

                this.master.progress(1).progress(0)

                // vai sempre in alto quando apre il il menu
                this.master.eventCallback('onComplete', () => {
                    this.url = null
                    // this.$nextTick(() => {
                    //     this.tempTimelineCheck()
                    // })
                })

                this.master.eventCallback('onReverseComplete', () => {
                    if (this.tempTimeline) {
                        // console.log('reverse complete');
                        // this.tempTimeline.play()
                    }
                })

                this.$emit('ready')

            }
            else {
                this.master.kill()
                this.master = null
                this.$nextTick(() => {
                    this.init()
                })
            }
        },
        toggle: function () {
            if (this.status) {
                this.status = false
                return this.close()
            }
            this.status = true
            return this.open()
        },
        open: function () {
            this.master.play()
        },
        close: function () {
            this.master.reverse()
        },
        mainClick: function (url = null, target = null) {
            this.$emit('main-click')
            if (target == '_self') {
                if (url != 'contatti') {
                    this.$root.goToAndScroll('home', url)
                }
                else {
                    this.$root.goTo('contatti')
                }
            }
        }
    },
    filters: {
        decode: function (url) {
            return decodeURIComponent(url.replace(/\+/g, ' '))
        }
    },
    mounted: function () {
        this.height = this.$root.window.h
        this.init()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.menu-overlay {
    width: 100vw;
    height: 100vh;
    background-color: $white;
    // height: auto;
    overflow-x: hidden;
    overflow-y: scroll;
    padding-top: 90px;
    // padding-bottom: $spacer * 5;
    opacity: 0;
    // z-index: 1090;
    z-index: ($zindex-fixed - 2);

    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;

    &__content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        width: 100%;
        min-height: 70vh;
        // padding-top: $spacer * 2;
        padding-left: $spacer;
        padding-right: $spacer;
        // overflow-y: scroll;
    }

    .ui-pin-mobile {
        $pin: &;
        margin-top: $spacer * 2/3;

        &__content {
            background-color: $white;
            padding: $spacer * 2/3;
            display: flex;
            flex-direction: column;
            width: inherit;
            cursor: pointer;
            transition: $transition-base;
            min-height: 30vh;
            justify-content: center;

            &:hover {
                background-color: darken($red, 4);
                transition: $transition-base;

                .ui-pin-text {
                    color: darken($white, 4);
                }
            }
        }
    }

    .ui-pin-text {
        display: block;
        width: 100%;
        color: $white;
        text-align: center;
        text-transform: uppercase;
        font-weight: $font-weight-bold;
        font-size: $h4-font-size;
        line-height: 1.5;

        &--light {
            font-size: $font-size-base;
            font-weight: $font-weight-light;
        }
    }
}
</style>
